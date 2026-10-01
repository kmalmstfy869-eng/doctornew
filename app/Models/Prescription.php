<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prescription extends Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'patient_name',
        'patient_phone',
        'prescription_date',
        'next_visit_date',
        'medications',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'prescription_date' => 'date',
            'next_visit_date' => 'date',
            'medications' => 'array',
        ];
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /** روشتات دكتور معين فقط */
    public function scopeForDoctor(Builder $query, int $doctorId): Builder
    {
        return $query->where('doctor_id', $doctorId);
    }


    /** اسم المريض للعرض: لو مسجل ناخد اسمه الحالي، غير كده الاسم المحفوظ وقت الروشتة */
    public function getDisplayNameAttribute(): ?string
    {
        return $this->patient?->name ?: $this->patient_name;
    }

    public function getDisplayPhoneAttribute(): ?string
    {
        return $this->patient?->phone ?: $this->patient_phone;
    }

    public function getPrescriptionDateLabelAttribute(): ?string
    {
        return $this->prescription_date?->locale('ar')->translatedFormat('l، d M Y');
    }

    public function getNextVisitDateLabelAttribute(): ?string
    {
        return $this->next_visit_date?->locale('ar')->translatedFormat('l، d M Y');
    }

    /** بيانات جاهزة لتعبئة modal التعديل (Alpine payload) — بتتنقل بـ @js() في البلايد */
    public function editPayload(): array
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'patient_name' => (string) $this->display_name,
            'patient_phone' => (string) $this->display_phone,
            'prescription_date' => optional($this->prescription_date)->format('Y-m-d'),
            'next_visit_date' => optional($this->next_visit_date)->format('Y-m-d'),
            'notes' => (string) ($this->notes ?? ''),
            'medications' => collect($this->medications ?? [])
                ->map(fn ($m) => [
                    'name' => (string) ($m['name'] ?? ''),
                    'dose' => (string) ($m['dose'] ?? ''),
                    'frequency' => (string) ($m['frequency'] ?? ''),
                    'duration' => (string) ($m['duration'] ?? ''),
                    'timing' => (string) ($m['timing'] ?? ''),
                    'notes' => (string) ($m['notes'] ?? ''),
                ])
                ->values()
                ->all(),
        ];
    }
}
