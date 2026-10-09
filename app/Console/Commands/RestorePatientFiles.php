<?php

namespace App\Console\Commands;

use App\Services\PatientFileBackupService;
use Illuminate\Console\Command;

class RestorePatientFiles extends Command
{
    protected $signature = 'patient-files:restore
        {--path= : مفتاح ملف واحد}
        {--include-deleted : يشمل الملفات اللي اتحذفت من الـ Primary (جوه مدة الاحتفاظ)}
        {--dry-run : عرض بس من غير تنفيذ}';

    protected $description = 'استرجاع الملفات الناقصة من الـ Backup للـ Primary';

    public function handle(PatientFileBackupService $service): int
    {
        $r = $service->restoreAll(
            $this->option('path') ?: null,
            (bool) $this->option('include-deleted'),
            (bool) $this->option('dry-run'),
            fn ($m) => $this->line($m)
        );

        $this->info("restored={$r['restored']} skipped={$r['skipped']} failed={$r['failed']}");

        return $r['failed'] > 0 ? self::FAILURE : self::SUCCESS;
    }
}
