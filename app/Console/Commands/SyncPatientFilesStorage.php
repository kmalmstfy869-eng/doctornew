<?php

namespace App\Console\Commands;

use App\Models\Doctor;
use App\Services\PatientFileService;
use Illuminate\Console\Command;

class SyncPatientFilesStorage extends Command
{
    protected $signature = 'patient-files:sync-storage';

    protected $description = 'إعادة حساب المساحة المتبقية لكل الأطباء';

    public function handle(PatientFileService $service): int
    {
        // نمر على الأطباء على دفعات ونحدّث عمود المتبقي لكل واحد.
        Doctor::query()->select('id')->chunkById(200, function ($doctors) use ($service) {
            foreach ($doctors as $doctor) {
                $service->syncRemaining($doctor->id);
            }
        });

        $this->info('تم تحديث المساحة المتبقية.');

        return self::SUCCESS;
    }
}
