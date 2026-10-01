<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
class Visit extends Model
{
    use HasFactory;


    protected $fillable = [
        'doctor_id',
        'patient_id',
        'patient_name',
        'patient_phone',
        'visit_date',
        'complaint',
        'symptoms',
        'diagnosis',
        'required_tests',
        'required_radiology',
        'notes',
        'next_visit_date',
    ];

    protected $casts = [
        'visit_date'       => 'date',
        'next_visit_date'  => 'date',
        'treatment'        => 'array',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

     public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /** زيارات دكتور معين فقط */
    public function scopeForDoctor(Builder $query, int $doctorId): Builder
    {
        return $query->where('doctor_id', $doctorId);
    }

    /** اسم المريض للعرض: لو مسجل ناخد اسمه الحالي، غير كده الاسم المحفوظ وقت الزيارة */
    public function getDisplayNameAttribute(): ?string
    {
        return $this->patient?->name ?: $this->patient_name;
    }

    public function getDisplayPhoneAttribute(): ?string
    {
        return $this->patient?->phone ?: $this->patient_phone;
    }

    public function getVisitDateLabelAttribute(): ?string
    {
        return $this->visit_date?->locale('ar')->translatedFormat('l، d M Y');
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
            'visit_date' => optional($this->visit_date)->format('Y-m-d'),
            'complaint' => (string) ($this->complaint ?? ''),
            'symptoms' => (string) ($this->symptoms ?? ''),
            'diagnosis' => (string) ($this->diagnosis ?? ''),
            'required_tests' => (string) ($this->required_tests ?? ''),
            'required_radiology' => (string) ($this->required_radiology ?? ''),
            'notes' => (string) ($this->notes ?? ''),
            'next_visit_date' => optional($this->next_visit_date)->format('Y-m-d'),
        ];
    }
}
