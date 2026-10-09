<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\PatientFile;
use App\Models\PatientFileBackup;
use App\Models\PatientFileBackupRun;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class PatientFileBackupService
{
    // نستخدم Backup Storage منفصل عن التخزين الأساسي حتى لو حصلت مشكلة في الـ Primary تفضل النسخة الاحتياطية متاحة للاسترجاع.
    private function primary(): Filesystem
    {
        return Storage::disk(config('clinic.patient_files_disk', 'medical_files'));
    }

    private function backup(): Filesystem
    {
        return Storage::disk(config('clinic.patient_files_backup_disk', 'medical_files_backup'));
    }

    // تشغيل النسخ الاحتياطي اليومي للملفات الجديدة بس. الملف اللي له سجل في patient_file_backups بيتعدّى.
    public function run(): PatientFileBackupRun
    {
        $run = PatientFileBackupRun::create(['started_at' => now(), 'status' => 'running']);
        $c = ['copied' => 0, 'failed' => 0, 'bytes' => 0, 'purged' => 0];
        $error = null;

        try {
            PatientFile::query()
                ->whereNotExists(function ($q) {
                    $q->select(DB::raw(1))
                        ->from('patient_file_backups')
                        ->whereColumn('patient_file_backups.source_path', 'patient_files.stored_path');
                })
                ->chunkById(100, function ($files) use (&$c) {
                    foreach ($files as $file) {
                        try {
                            $this->copyOne($file);
                            $c['copied']++;
                            $c['bytes'] += (int) $file->size;
                        } catch (Throwable $e) {
                            // فشل ملف واحد ما يوقفش الباقي. هيتعاد تلقائيًا في الـ Backup الجاي.
                            $c['failed']++;
                            // نسجل سبب الفشل على الملف نفسه عشان الأدمن يشوفه في صفحة الملفات.
                            PatientFile::query()->whereKey($file->id)->toBase()->update([
                                'backup_last_error' => Str::limit($e->getMessage(), 240, ''),
                                'backup_attempted_at' => now(),
                            ]);
                            Log::error('patient file backup failed', ['file_id' => $file->id, 'error' => $e->getMessage()]);
                        }
                    }
                });

            $this->markDeletedSources();
            $c['purged'] = $this->purgeExpired();

            $status = $c['failed'] > 0 ? 'partial' : 'success';
        } catch (Throwable $e) {
            $status = 'failed';
            $error = Str::limit($e->getMessage(), 500);
            report($e);
        }

        $run->update([
            'status' => $status,
            'copied_count' => $c['copied'],
            'failed_count' => $c['failed'],
            'purged_count' => $c['purged'],
            'copied_bytes' => $c['bytes'],
            'error' => $error,
            'finished_at' => now(),
        ]);

        return $run;
    }

    private function copyOne(PatientFile $file): void
    {
        $backup = $this->backup();

        $stream = $this->primary()->readStream($file->stored_path);
        if (! is_resource($stream)) {
            throw new \RuntimeException('primary file unreadable');
        }

        try {
            $backup->writeStream($file->stored_path, $stream);
        } finally {
            fclose($stream);
        }

        // نتأكد إن الحجم المنسوخ مطابق قبل ما نسجل إن النسخة تمت.
        if ((int) $backup->size($file->stored_path) !== (int) $file->size) {
            $backup->delete($file->stored_path);
            throw new \RuntimeException('size mismatch');
        }

        PatientFileBackup::create([
            'patient_file_id' => $file->id,
            'doctor_id' => $file->doctor_id,
            'patient_id' => $file->patient_id,
            'original_name' => $file->original_name,
            'source_path' => $file->stored_path,
            'mime_type' => $file->mime_type,
            'size' => $file->size,
            'backed_up_at' => now(),
        ]);
    }

    // شبكة أمان: أي نسخة ملفها اختفى من الـ Primary من غير ما حد يسجل وقت الحذف، نسجله دلوقتي.
    private function markDeletedSources(): void
    {
        PatientFileBackup::query()
            ->whereNull('source_deleted_at')
            ->whereNotExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('patient_files')
                    ->whereColumn('patient_files.stored_path', 'patient_file_backups.source_path');
            })
            ->update(['source_deleted_at' => now()]);
    }

    // نحتفظ بالنسخة الاحتياطية لمدة 30 يومًا بعد حذف الملف من التخزين الأساسي حتى نقدر نسترجعه لو الحذف كان بالخطأ.
    public function purgeExpired(): int
    {
        $cutoff = now()->subDays((int) config('clinic.patient_files_backup_retention_days', 30));
        $purged = 0;

        PatientFileBackup::query()
            ->whereNotNull('source_deleted_at')
            ->where('source_deleted_at', '<=', $cutoff)
            ->chunkById(100, function ($rows) use (&$purged) {
                foreach ($rows as $row) {
                    try {
                        if ($this->backup()->exists($row->source_path)) {
                            $this->backup()->delete($row->source_path);
                        }
                        $row->delete();
                        $purged++;
                    } catch (Throwable $e) {
                        // لو الحذف فشل نسيب السجل ونحاول بكرة.
                        Log::error('backup purge failed', ['backup_id' => $row->id]);
                    }
                }
            });

        return $purged;
    }

    /* ------------------------------------------------------------------ */
    /* Restore                                                             */
    /* ------------------------------------------------------------------ */

    // استرجاع ملف من الـ Backup للـ Primary، ولو سجله في الداتابيز ناقص (والمريض لسه موجود) بنعيد إنشاءه.
    public function restore(PatientFileBackup $b): bool
    {
        $did = false;

        if (! $this->primary()->exists($b->source_path)) {
            $stream = $this->backup()->readStream($b->source_path);
            if (! is_resource($stream)) {
                throw new \RuntimeException('backup file unreadable');
            }
            try {
                $this->primary()->writeStream($b->source_path, $stream);
            } finally {
                fclose($stream);
            }
            $did = true;
        }

        $rowMissing = ! PatientFile::query()->where('stored_path', $b->source_path)->exists();
        $patientOk = Patient::query()->whereKey($b->patient_id)->where('doctor_id', $b->doctor_id)->exists();

        if ($rowMissing && $patientOk) {
            $row = new PatientFile();
            $row->forceFill([
                'doctor_id' => $b->doctor_id,
                'patient_id' => $b->patient_id,
                'original_name' => $b->original_name,
                'stored_path' => $b->source_path,
                'mime_type' => $b->mime_type,
                'size' => $b->size,
            ]);
            if ($b->patient_file_id && ! PatientFile::query()->whereKey($b->patient_file_id)->exists()) {
                $row->id = $b->patient_file_id;
            }
            $row->save();
            // تحديث المتبقي بعد استرجاع السجل.
            app(PatientFileService::class)->syncRemaining((int) $b->doctor_id);
            $did = true;
        }

        if ($b->source_deleted_at) {
            $b->update(['source_deleted_at' => null]);
        }

        return $did;
    }

    public function restoreAll(?string $path, bool $includeDeleted, bool $dry, callable $log): array
    {
        $r = ['restored' => 0, 'skipped' => 0, 'failed' => 0];

        PatientFileBackup::query()
            ->when($path, fn ($q) => $q->where('source_path', $path))
            ->when(! $includeDeleted && ! $path, fn ($q) => $q->whereNull('source_deleted_at'))
            ->chunkById(100, function ($rows) use (&$r, $dry, $log) {
                foreach ($rows as $b) {
                    try {
                        $needs = ! $this->primary()->exists($b->source_path)
                            || ! PatientFile::query()->where('stored_path', $b->source_path)->exists();

                        if (! $needs) {
                            $r['skipped']++;
                            continue;
                        }
                        if ($dry) {
                            $log("would restore: {$b->source_path}");
                            $r['restored']++;
                            continue;
                        }
                        $this->restore($b) ? $r['restored']++ : $r['skipped']++;
                    } catch (Throwable $e) {
                        $r['failed']++;
                        $log("failed: {$b->source_path} ({$e->getMessage()})");
                    }
                }
            });

        return $r;
    }
}
