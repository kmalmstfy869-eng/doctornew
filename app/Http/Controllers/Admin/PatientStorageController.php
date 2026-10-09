<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ParsesDates;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\PatientFile;
use App\Models\PatientFileBackup;
use App\Models\PatientFileBackupRun;
use App\Services\PatientFileBackupService;
use App\Services\PatientFileService;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PatientStorageController extends Controller
{
    use ParsesDates;

    /* ------------------------------------------------------------------ */
    /* نظرة عامة                                                           */
    /* ------------------------------------------------------------------ */

    public function overview()
    {
        // كل رقم هنا متحسب من الداتابيز مباشرة.
        $totalFiles = PatientFile::count();
        $usedBytes = (int) PatientFile::sum('size');

        $backedUp = PatientFile::whereExists($this->hasBackup())->count();
        $failed = PatientFile::whereNotExists($this->hasBackup())->whereNotNull('backup_last_error')->count();
        $pending = max(0, $totalFiles - $backedUp - $failed);

        $backupBytes = (int) PatientFileBackup::sum('size');
        $restorable = PatientFileBackup::count();
        $deletedKept = PatientFileBackup::whereNotNull('source_deleted_at')->count();

        $lastRun = PatientFileBackupRun::latest('id')->first();
        $lastSuccess = PatientFileBackupRun::lastSuccessful();

        $attention = $this->limitFilter($this->quotaQuery(), 'attention')
            ->orderByRaw('used_bytes / (doctors.patient_files_quota_gb * 1073741824) desc')
            ->get();

        return view('admin.storage.overview', compact(
            'totalFiles', 'usedBytes', 'backedUp', 'failed', 'pending', 'backupBytes',
            'restorable', 'deletedKept', 'lastRun', 'lastSuccess', 'attention'
        ));
    }

    /* ------------------------------------------------------------------ */
    /* الملفات والنسخ                                                      */
    /* ------------------------------------------------------------------ */

    public function files(Request $request, PatientFileService $service)
    {
        $view = $request->input('view') === 'deleted' ? 'deleted' : 'current';
        $search = trim((string) $request->input('search', ''));
        $doctorId = (int) $request->input('doctor_id');
        $status = in_array($request->input('status'), ['done', 'pending', 'failed'], true) ? $request->input('status') : null;
        $type = in_array($request->input('type'), ['pdf', 'image'], true) ? $request->input('type') : null;
        $from = $this->dateOrNull($request->input('from'));
        $to = $this->dateOrNull($request->input('to'));
        $like = $search !== '' ? '%' . addcslashes($search, '%_\\') . '%' : null;

        if ($view === 'deleted') {
            // نسخ احتياطية اتحذف أصلها من الـ Primary وماسكينها فترة الاحتفاظ.
            $rows = PatientFileBackup::query()
                ->leftJoin('patients', 'patients.id', '=', 'patient_file_backups.patient_id')
                ->leftJoin('doctors', 'doctors.id', '=', 'patient_file_backups.doctor_id')
                ->leftJoin('users', 'users.id', '=', 'doctors.user_id')
                ->whereNotNull('patient_file_backups.source_deleted_at')
                ->select([
                    'patient_file_backups.id', 'patient_file_backups.original_name', 'patient_file_backups.mime_type',
                    'patient_file_backups.size', 'patient_file_backups.source_deleted_at', 'patient_file_backups.backed_up_at',
                    'patients.name as patient_name', 'users.name as doctor_name',
                ])
                ->when($doctorId, fn ($q) => $q->where('patient_file_backups.doctor_id', $doctorId))
                ->when($type === 'pdf', fn ($q) => $q->where('patient_file_backups.mime_type', 'application/pdf'))
                ->when($type === 'image', fn ($q) => $q->where('patient_file_backups.mime_type', 'like', 'image/%'))
                ->when($from, fn ($q) => $q->whereDate('patient_file_backups.source_deleted_at', '>=', $from))
                ->when($to, fn ($q) => $q->whereDate('patient_file_backups.source_deleted_at', '<=', $to))
                ->when($like, fn ($q) => $q->where(fn ($w) => $w
                    ->where('patient_file_backups.original_name', 'like', $like)
                    ->orWhere('patients.name', 'like', $like)
                    ->orWhere('users.name', 'like', $like)))
                ->latest('patient_file_backups.source_deleted_at')
                ->paginate(12)
                ->withQueryString();
        } else {
            $rows = PatientFile::query()
                ->leftJoin('patients', 'patients.id', '=', 'patient_files.patient_id')
                ->leftJoin('doctors', 'doctors.id', '=', 'patient_files.doctor_id')
                ->leftJoin('users', 'users.id', '=', 'doctors.user_id')
                ->select([
                    'patient_files.id', 'patient_files.stored_path', 'patient_files.original_name',
                    'patient_files.mime_type', 'patient_files.size', 'patient_files.created_at',
                    'patient_files.backup_last_error', 'patient_files.backup_attempted_at',
                    'patients.name as patient_name', 'users.name as doctor_name',
                ])
                ->selectSub(PatientFileBackup::query()->select('backed_up_at')
                    ->whereColumn('patient_file_backups.source_path', 'patient_files.stored_path')->limit(1), 'backed_up_at')
                ->selectSub(PatientFileBackup::query()->select('id')
                    ->whereColumn('patient_file_backups.source_path', 'patient_files.stored_path')->limit(1), 'backup_id')
                ->when($doctorId, fn ($q) => $q->where('patient_files.doctor_id', $doctorId))
                ->when($type === 'pdf', fn ($q) => $q->where('patient_files.mime_type', 'application/pdf'))
                ->when($type === 'image', fn ($q) => $q->where('patient_files.mime_type', 'like', 'image/%'))
                ->when($status === 'done', fn ($q) => $q->whereExists($this->hasBackup()))
                ->when($status === 'pending', fn ($q) => $q->whereNotExists($this->hasBackup())->whereNull('patient_files.backup_last_error'))
                ->when($status === 'failed', fn ($q) => $q->whereNotExists($this->hasBackup())->whereNotNull('patient_files.backup_last_error'))
                ->when($from, fn ($q) => $q->whereDate('patient_files.created_at', '>=', $from))
                ->when($to, fn ($q) => $q->whereDate('patient_files.created_at', '<=', $to))
                ->when($like, fn ($q) => $q->where(function ($w) use ($like, $search) {
                    $w->where('patient_files.original_name', 'like', $like)
                        ->orWhere('patients.name', 'like', $like)
                        ->orWhere('patients.phone', 'like', $like)
                        ->orWhere('users.name', 'like', $like);

                    if (ctype_digit($search)) {
                        $w->orWhere('patient_files.id', (int) $search);
                    }
                }))
                ->latest('patient_files.created_at')
                ->latest('patient_files.id')
                ->paginate(12)
                ->withQueryString();

            // حالة الملف في الـ Primary: بنفحصها للصفحة الحالية بس (12 ملف).
            $disk = $service->disk();
            $rows->getCollection()->transform(function ($f) use ($disk) {
                $f->primary_ok = $disk->exists($f->stored_path);

                return $f;
            });
        }

        $doctors = $this->doctorOptions();
        $retention = (int) config('clinic.patient_files_backup_retention_days', 30);

        return view('admin.storage.files', compact('rows', 'view', 'search', 'doctors', 'retention'));
    }

    /* ------------------------------------------------------------------ */
    /* سجل التشغيلات                                                       */
    /* ------------------------------------------------------------------ */

    public function runs(Request $request)
    {
        $status = in_array($request->input('status'), ['success', 'partial', 'failed', 'running'], true) ? $request->input('status') : null;
        $from = $this->dateOrNull($request->input('from'));
        $to = $this->dateOrNull($request->input('to'));

        $runs = PatientFileBackupRun::query()
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($from, fn ($q) => $q->whereDate('started_at', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('started_at', '<=', $to))
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.storage.runs', compact('runs', 'status', 'from', 'to'));
    }

    // تشغيل Backup يدوي: محمي بقفل يمنع نسختين في نفس الوقت، والنتيجة بتتسجل في جدول التشغيلات.
    public function runNow(PatientFileBackupService $service): RedirectResponse
    {
        $lock = Cache::lock('patient-files-backup', 3600);

        if (! $lock->get()) {
            return back()->with('error', 'فيه Backup شغال دلوقتي، استنى لحد ما يخلص.');
        }

        try {
            @set_time_limit(0);
            $run = $service->run();
        } finally {
            $lock->release();
        }



        $msg = "الـ Backup خلص ({$run->status_label}): اتنسخ {$run->copied_count} ملف وفشل {$run->failed_count}.";

        return back()->with($run->status === 'success' ? 'success' : 'error', $msg);
    }

    /* ------------------------------------------------------------------ */
    /* مساحات الأطباء                                                      */
    /* ------------------------------------------------------------------ */

    public function quotas(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $limit = in_array($request->input('limit'), ['near', 'full', 'attention'], true) ? $request->input('limit') : null;
        $sort = in_array($request->input('sort'), ['used', 'percent', 'name'], true) ? $request->input('sort') : 'percent';

        $q = $this->quotaQuery();

        if ($search !== '') {
            $like = '%' . addcslashes($search, '%_\\') . '%';
            $q->where(fn ($w) => $w->where('users.name', 'like', $like)->orWhere('users.email', 'like', $like));
        }

        $this->limitFilter($q, $limit);

        $q->orderByRaw(match ($sort) {
            'used' => 'used_bytes desc',
            'name' => 'users.name asc',
            default => 'used_bytes / (doctors.patient_files_quota_gb * 1073741824) desc',
        })->orderBy('doctors.id');

        $doctors = $q->paginate(12)->withQueryString();

        return view('admin.storage.quotas', [
            'doctors' => $doctors,
            'search' => $search,
            'limit' => $limit,
            'sort' => $sort,
            'defaultGb' => (float) config('clinic.patient_files_storage_gb', 25),
        ]);
    }


    /* ------------------------------------------------------------------ */
    /* مساعدات                                                             */
    /* ------------------------------------------------------------------ */

    // شرط "الملف له نسخة احتياطية".
    private function hasBackup(): Closure
    {
        return fn ($q) => $q->select(DB::raw(1))->from('patient_file_backups')
            ->whereColumn('patient_file_backups.source_path', 'patient_files.stored_path');
    }

    // قائمة الأطباء مع المساحة المستخدمة وعدد الملفات. المستخدم بيتحسب من أحجام الملفات الفعلية.
    private function quotaQuery()
    {
        return Doctor::query()->doctors()->active()
            ->join('users', 'users.id', '=', 'doctors.user_id')
            ->select([
                'doctors.id', 'doctors.patient_files_quota_gb', 'doctors.patient_files_remaining_gb',
                'users.name as doctor_name', 'users.email as doctor_email',
            ])
            ->selectSub(PatientFile::query()->selectRaw('COALESCE(SUM(size), 0)')
                ->whereColumn('patient_files.doctor_id', 'doctors.id'), 'used_bytes')
            ->selectSub(PatientFile::query()->selectRaw('COUNT(*)')
                ->whereColumn('patient_files.doctor_id', 'doctors.id'), 'files_count');
    }

    // فلتر حالة الاستهلاك. القيم ثابتة من الكود، ومفيش مدخلات مستخدم بتتركب في الـ SQL.
    private function limitFilter($q, ?string $mode)
    {
        $quota = 'doctors.patient_files_quota_gb * 1073741824';
        $pct = max(1, (int) config('clinic.patient_files_near_limit_percent', 90)) / 100;

        return match ($mode) {
            'full' => $q->havingRaw("used_bytes >= {$quota}"),
            'near' => $q->havingRaw("used_bytes >= {$quota} * ? AND used_bytes < {$quota}", [$pct]),
            'attention' => $q->havingRaw("used_bytes >= {$quota} * ?", [$pct]),
            default => $q,
        };
    }

    private function doctorOptions()
    {
        return Doctor::query()->doctors()->active()
            ->join('users', 'users.id', '=', 'doctors.user_id')
            ->orderBy('users.name')
            ->get(['doctors.id', 'users.name']);
    }
}
