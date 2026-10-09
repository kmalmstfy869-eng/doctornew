<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\PatientFile;
use App\Models\PatientFileBackup;
use App\Models\Doctor;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class PatientFileService
{

    private const EXTENSIONS = [
        'application/pdf' => 'pdf',
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    // نستخدم Disk مخصص لملفات المرضى حتى نقدر ننقل التخزين لاحقًا إلى Cloudflare R2 بدون تغيير منطق النظام.
    public function disk(): FilesystemAdapter
    {
        return Storage::disk(config('clinic.patient_files_disk', 'medical_files'));
    }

    /* ------------------------------------------------------------------ */
    /* المساحة                                                             */
    /* ------------------------------------------------------------------ */

    // الحد بيتقرأ من عمود المساحة المسموحة الخاص بالطبيب، ولو فاضي بنستخدم الرقم الافتراضي من config.
    public function limitBytes(int $doctorId): int
    {
        $gb = Doctor::query()->whereKey($doctorId)->value('patient_files_quota_gb');
        $gb = $gb !== null ? (float) $gb : (float) config('clinic.patient_files_storage_gb', 25);

        return (int) round($gb * 1024 ** 3);
    }

    // المساحة المستخدمة بتتحسب من أحجام الملفات الموجودة فعلًا، فالحذف بيحرر المساحة تلقائيًا.
    public function usedBytes(int $doctorId): int
    {
        return (int) PatientFile::query()->where('doctor_id', $doctorId)->sum('size');
    }

    // بنحدّث عمود المتبقي من أحجام الملفات الفعلية، فمهما حصل مفيش رقم بيتراكم غلط.
    public function syncRemaining(int $doctorId): void
    {
        $remaining = max(0, $this->limitBytes($doctorId) - $this->usedBytes($doctorId));

        Doctor::query()->whereKey($doctorId)->toBase()
            ->update(['patient_files_remaining_gb' => round($remaining / 1024 ** 3, 3)]);
    }

    public function stats(int $doctorId): array
    {
        $limit = $this->limitBytes($doctorId);
        $used = $this->usedBytes($doctorId);
        $remaining = max(0, $limit - $used);
        $percent = $limit > 0 ? min(100, round($used / $limit * 100, 1)) : 100.0;

        return [
            'limit_bytes' => $limit,
            'used_bytes' => $used,
            'remaining_bytes' => $remaining,
            'percent' => $percent,
            'limit_label' => self::formatBytes($limit),
            'used_label' => self::formatBytes($used),
            'remaining_label' => self::formatBytes($remaining),
        ];
    }

    public static function formatBytes(int $bytes): string
    {
        $units = [['GB', 1024 ** 3], ['MB', 1024 ** 2], ['KB', 1024]];

        foreach ($units as [$unit, $size]) {
            if ($bytes >= $size) {
                return rtrim(rtrim(number_format($bytes / $size, 1, '.', ''), '0'), '.') . ' ' . $unit;
            }
        }

        return $bytes . ' B';
    }

    /* ------------------------------------------------------------------ */
    /* الرفع                                                               */
    /* ------------------------------------------------------------------ */

    public function store(int $doctorId, int $patientId, UploadedFile $file): PatientFile
    {
        $mime = (string) $file->getMimeType();
        $ext = self::EXTENSIONS[$mime] ?? null;

        if ($ext === null) {
            throw $this->fail('file', 'نوع الملف غير مسموح. المسموح: PDF, JPG, JPEG, PNG, WEBP.');
        }

        $size = (int) $file->getSize();

        return DB::transaction(function () use ($doctorId, $patientId, $file, $mime, $ext, $size) {

            // قفل صف الدكتور عشان رفعين في نفس اللحظة ما يعدّوش الحد مع بعض.
            Doctor::query()->whereKey($doctorId)->lockForUpdate()->first(['id']);

            // التحقق من المساحة قبل أي حفظ: لو الحد اتعدى لا ملف يتحفظ ولا سجل يتعمل.
            $stats = $this->stats($doctorId);
            if ($stats['used_bytes'] + $size > $stats['limit_bytes']) {
                throw $this->fail('file',
                    'مساحة ملفات المرضى لا تكفي لرفع هذا الملف. '
                    . "المتاح: {$stats['remaining_label']} وحجم الملف: " . self::formatBytes($size)
                    . '. احذف بعض الملفات القديمة ثم حاول مرة أخرى.');
            }

            // اسم عشوائي (UUID) بدل اسم الملف الأصلي. الاسم الأصلي بيتخزن في الداتابيز بس.
            $path = "doctors/{$doctorId}/patients/{$patientId}/" . Str::uuid() . ".{$ext}";

            $this->disk()->putFileAs(dirname($path), $file, basename($path));

            try {
                $model = PatientFile::create([
                    'doctor_id' => $doctorId,
                    'patient_id' => $patientId,
                    'original_name' => Str::limit($file->getClientOriginalName(), 240, ''),
                    'stored_path' => $path,
                    'mime_type' => $mime,
                    'size' => $size,
                ]);

                // تحديث المتبقي بعد الرفع.
                $this->syncRemaining($doctorId);

                return $model;
            } catch (Throwable $e) {
                // لو تسجيل الداتابيز فشل، نمسح الملف اللي اتحفظ عشان ما يفضلش ملف يتيم.
                try {
                    $this->disk()->delete($path);
                } catch (Throwable $inner) {
                    Log::error('orphan patient file after db failure', ['path' => $path]);
                }
                throw $e;
            }
        });
    }

    /* ------------------------------------------------------------------ */
    /* العرض / التحميل                                                     */
    /* ------------------------------------------------------------------ */

    // الملف بيتبعت عن طريق route محمي وstream من الـ Disk، من غير روابط عامة.
    public function response(PatientFile $file, bool $download = false): StreamedResponse
    {
        $disk = $this->disk();

        if (! $disk->exists($file->stored_path)) {
            abort(404);
        }

        return $disk->response($file->stored_path, $file->original_name, [
            'Content-Type' => $file->mime_type,
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, no-store, max-age=0',
        ], $download ? 'attachment' : 'inline');
    }

    /* ------------------------------------------------------------------ */
    /* الحذف                                                               */
    /* ------------------------------------------------------------------ */

    public function delete(PatientFile $file): void
    {
        DB::transaction(function () use ($file) {

            // نسجل وقت الحذف من الـ Primary على نسخة الـ Backup. منها بيبدأ عدّاد الـ 30 يوم، والنسخة نفسها ما بتتمسحش دلوقتي.
            PatientFileBackup::query()
                ->where('source_path', $file->stored_path)
                ->whereNull('source_deleted_at')
                ->update(['source_deleted_at' => now()]);

            // نحذف من الـ Storage الأول. لو فشل بيرمي Exception والـ transaction بترجّع كل حاجة، فالسجل ما بيضيعش.
            $disk = $this->disk();
            if ($disk->exists($file->stored_path)) {
                $disk->delete($file->stored_path);
            }

            $file->delete();

            // تحديث المتبقي بعد الحذف.
            $this->syncRemaining((int) $file->doctor_id);
        });
    }

    // لما مريض يتحذف، سجلات ملفاته بتتمسح بالـ cascade. هنا بنسجل وقت الحذف للـ Backup ونمسح الملفات من الـ Storage بعد نجاح الـ commit.
    public function handlePatientDeleting(Patient $patient): void
    {
        $paths = $patient->files()->pluck('stored_path')->all();

        if (empty($paths)) {
            return;
        }

        PatientFileBackup::query()
            ->whereIn('source_path', $paths)
            ->whereNull('source_deleted_at')
            ->update(['source_deleted_at' => now()]);

        DB::afterCommit(function () use ($paths) {
            foreach ($paths as $path) {
                try {
                    $this->disk()->delete($path);
                } catch (Throwable $e) {
                    Log::error('فشل حذف ملف المريض من التخزين بعد حذف المريض', [
                        'path' => $path,
                    ]);
                }
            }
        });
    }

    private function fail(string $field, string $message): ValidationException
    {
        return ValidationException::withMessages([$field => $message])->errorBag('patient_file');
    }
}
