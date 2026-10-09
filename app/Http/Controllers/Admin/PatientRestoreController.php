<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PatientFile;
use App\Models\PatientFileBackup;
use App\Services\PatientFileBackupService;
use App\Services\PatientFileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Throwable;

class PatientRestoreController extends Controller
{
    public function index(Request $request, PatientFileService $service)
    {
        $search = trim((string) $request->input('search', ''));
        $scope = in_array($request->input('scope'), ['deleted', 'no_record'], true) ? $request->input('scope') : null;
        $like = $search !== '' ? '%' . addcslashes($search, '%_\\') . '%' : null;

        $rows = PatientFileBackup::query()
            ->leftJoin('patients', 'patients.id', '=', 'patient_file_backups.patient_id')
            ->leftJoin('doctors', 'doctors.id', '=', 'patient_file_backups.doctor_id')
            ->leftJoin('users', 'users.id', '=', 'doctors.user_id')
            ->select([
                'patient_file_backups.id', 'patient_file_backups.source_path', 'patient_file_backups.original_name',
                'patient_file_backups.size', 'patient_file_backups.backed_up_at', 'patient_file_backups.source_deleted_at',
                'patients.name as patient_name', 'users.name as doctor_name',
            ])
            ->selectSub(PatientFile::query()->selectRaw('1')
                ->whereColumn('patient_files.stored_path', 'patient_file_backups.source_path')->limit(1), 'row_ok')
            ->when($scope === 'deleted', fn ($q) => $q->whereNotNull('patient_file_backups.source_deleted_at'))
            ->when($scope === 'no_record', fn ($q) => $q->whereNotExists(fn ($x) => $x->select(DB::raw(1))
                ->from('patient_files')->whereColumn('patient_files.stored_path', 'patient_file_backups.source_path')))
            ->when($like, fn ($q) => $q->where(fn ($w) => $w
                ->where('patient_file_backups.original_name', 'like', $like)
                ->orWhere('patients.name', 'like', $like)
                ->orWhere('users.name', 'like', $like)))
            ->latest('patient_file_backups.backed_up_at')
            ->paginate(10)
            ->withQueryString();

        // هل الملف موجود فعلًا في الـ Primary؟ بنفحصه للصفحة الحالية بس.
        $disk = $service->disk();
        $rows->getCollection()->transform(function ($b) use ($disk) {
            $b->primary_ok = $disk->exists($b->source_path);

            return $b;
        });

        return view('admin.storage.restore', [
            'rows' => $rows,
            'search' => $search,
            'scope' => $scope,
            'preview' => session('restore_preview'),
            'result' => session('restore_result'),
            'retention' => (int) config('clinic.patient_files_backup_retention_days', 30),
        ]);
    }

    // معاينة الاسترجاع الجماعي من غير تنفيذ: بتعيد استخدام restoreAll في وضع dry-run.
    public function preview(PatientFileBackupService $service): RedirectResponse
    {
        @set_time_limit(0);

        $would = [];
        $lines = [];

        $r = $service->restoreAll(null, false, true, function ($m) use (&$would, &$lines) {
            str_starts_with($m, 'would restore: ') ? $would[] = substr($m, 15) : $lines[] = $m;
        });

        $names = $this->names(array_slice($would, 0, 200));

        return back()->with('restore_preview', [
            'count' => $r['restored'],
            'skipped' => $r['skipped'],
            'failed' => $r['failed'],
            'items' => array_map(fn ($p) => $names[$p] ?? 'ملف', array_slice($would, 0, 200)),
            'more' => max(0, count($would) - 200),
            'errors' => $this->failures($lines),
        ]);
    }

    // استرجاع جماعي للملفات الناقصة: مش بيرجّع الملفات اللي اتحذفت عمدًا، ومحمي بتأكيد وقفل.
    public function restoreAll(Request $request, PatientFileBackupService $service): RedirectResponse
    {
        $request->validate(['confirm' => ['accepted']], ['confirm.accepted' => 'لازم تأكد قبل الاسترجاع الجماعي.']);

        $lock = Cache::lock('patient-files-restore', 900);

        if (! $lock->get()) {
            return back()->with('error', 'فيه عملية استرجاع شغالة دلوقتي، استنى لحد ما تخلص.');
        }

        try {
            @set_time_limit(0);
            $lines = [];
            $r = $service->restoreAll(null, false, false, function ($m) use (&$lines) {
                $lines[] = $m;
            });
        } finally {
            $lock->release();
        }



        return back()->with('restore_result', $r + ['errors' => $this->failures($lines)]);
    }

    // استرجاع ملف واحد. لو الملف اتحذف عمدًا لازم تأكيد صريح.
    public function restoreOne(Request $request, PatientFileBackup $backup, PatientFileBackupService $service): RedirectResponse
    {
        if ($backup->source_deleted_at && ! $request->boolean('confirm_deleted')) {
            return back()->with('error', 'الملف ده اتحذف عمدًا من الـ Primary. لازم تأكد إنك عايز ترجّعه.');
        }

        $lock = Cache::lock('patient-files-restore', 900);

        if (! $lock->get()) {
            return back()->with('error', 'فيه عملية استرجاع شغالة دلوقتي، استنى لحد ما تخلص.');
        }

        $meta = ['file' => $backup->original_name, 'was_deleted' => (bool) $backup->source_deleted_at];

        try {
            $did = $service->restore($backup);
        } catch (Throwable $e) {
            report($e);

            return back()->with('error', 'فشل الاسترجاع. النسخة الاحتياطية لسه سليمة، راجع storage/logs/laravel.log.');
        } finally {
            $lock->release();
        }

        $hasRecord = PatientFile::query()->where('stored_path', $backup->source_path)->exists();


        if (! $did) {
            return back()->with('success', 'الملف والسجل موجودين أصلًا، مفيش حاجة محتاجة استرجاع.');
        }

        return back()->with('success', $hasRecord
            ? "تم استرجاع «{$backup->original_name}» بنجاح."
            : "تم استرجاع ملف «{$backup->original_name}» للتخزين، لكن المريض مش موجود فمتعملش له سجل.");
    }

    // أسماء الملفات من المسارات الداخلية، عشان المسار ما يتعرضش للأدمن.
    private function names(array $paths): array
    {
        return PatientFileBackup::query()->whereIn('source_path', $paths)->pluck('original_name', 'source_path')->all();
    }

    private function failures(array $lines): array
    {
        $out = [];
        $paths = [];

        foreach ($lines as $l) {
            if (preg_match('/^failed: (.+) \((.*)\)$/s', $l, $m)) {
                $paths[] = $m[1];
                $out[] = ['path' => $m[1], 'error' => $m[2]];
            }
        }

        $names = $this->names($paths);

        return array_map(fn ($x) => ['name' => $names[$x['path']] ?? 'ملف', 'error' => $x['error']], $out);
    }
}
