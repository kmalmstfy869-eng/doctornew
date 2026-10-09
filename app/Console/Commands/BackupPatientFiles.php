<?php

namespace App\Console\Commands;

use App\Services\PatientFileBackupService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class BackupPatientFiles extends Command
{
    protected $signature = 'patient-files:backup';

    protected $description = 'نسخ احتياطي للملفات الجديدة فقط + تنظيف النسخ المنتهية الاحتفاظ';

    public function handle(PatientFileBackupService $service): int
    {
        // نفس القفل اللي بيستخدمه زر الأدمن، عشان نسختين ما يشتغلوش مع بعض.
        $lock = Cache::lock('patient-files-backup', 3600);

        if (! $lock->get()) {
            $this->warn('فيه Backup شغال دلوقتي.');

            return self::SUCCESS;
        }

        try {
            $run = $service->run();
        } finally {
            $lock->release();
        }

        $this->info("status={$run->status} copied={$run->copied_count} failed={$run->failed_count} purged={$run->purged_count} bytes={$run->copied_bytes}");

        return $run->status === 'failed' ? self::FAILURE : self::SUCCESS;
    }
}
