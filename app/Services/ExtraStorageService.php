<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\StorageSubscription;

class ExtraStorageService
{
    public function __construct(private PatientFileService $files) {}

    public function base(): float { return (float) config('clinic.patient_files_storage_gb', 25); }
    public function maxUnits(): int { return max(1, (int) config('clinic.extra_storage.max_units', 20)); }

    public function settings(): array
    {
        return [
            'base_gb' => $this->base(),
            'unit_gb' => StorageSubscription::unitGb(),
            'max_units' => $this->maxUnits(),
            'plans' => collect(StorageSubscription::plans())
                ->map(fn ($p, $k) => ['key' => $k, 'label' => $p['label'], 'days' => (int) $p['days'], 'price' => (float) $p['price']])
                ->values()->all(),
        ];
    }

    /** المساحة = الأساسي + الاشتراكات السارية. المصدر الوحيد اللي بيكتب في العمود. */
    public function sync(int $doctorId): float
    {
        $extra = (float) StorageSubscription::running()->where('doctor_id', $doctorId)->sum('gb');
        $quota = round($this->base() + $extra, 3);

        Doctor::query()->whereKey($doctorId)->toBase()->update(['patient_files_quota_gb' => $quota]);
        $this->files->syncRemaining($doctorId);

        return $quota;
    }

    public function expireDue(): int
    {
        $due = StorageSubscription::where('status', 'active')->whereDate('end_date', '<=', today())->get();

        foreach ($due as $s) {
            $s->update(['status' => 'expired']);
            $this->sync($s->doctor_id);
        }

        return $due->count();
    }
}
