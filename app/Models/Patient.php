<?php

namespace App\Models;

use App\Services\PatientFileService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $fillable = [
        'doctor_id',
        'name',
        'phone',
        'birth_date',
        'gender',
        'address',
        'notes',
    ];
    protected $casts = [
        'birth_date' => 'date',
    ];

    // لما المريض يتحذف نمسح ملفاته من الـ Storage ونسجل وقت الحذف للـ Backup، عشان ما تفضلش ملفات يتيمة.
    protected static function booted(): void
    {
        static::deleting(function (Patient $patient) {
            app(PatientFileService::class)->handlePatientDeleting($patient);
        });
        // بعد حذف المريض (وملفاته بالـ cascade) بنحدّث المتبقي للطبيب.
        static::deleted(function (Patient $patient) {
            app(PatientFileService::class)->syncRemaining((int) $patient->doctor_id);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
    public function notes()
    {
        return $this->hasMany(PatientNote::class);
    }

    // علاقة ملفات المريض الطبية.
    public function files(): HasMany
    {
        return $this->hasMany(PatientFile::class);
    }
}
