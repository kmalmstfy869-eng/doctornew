<?php

namespace App\Models;

use App\Services\PatientFileService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientFile extends Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'original_name',
        'stored_path',
        'mime_type',
        'size',
    ];

    // مسار الملف الداخلي مايتبعتش أبدًا في أي JSON.
    protected $hidden = ['stored_path'];

    protected $casts = [
        'size' => 'integer',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    // كل الاستعلامات لازم تتحصر على الدكتور الحالي.
    public function scopeForDoctor(Builder $query, int $doctorId): Builder
    {
        return $query->where('doctor_id', $doctorId);
    }

    public function getIsImageAttribute(): bool
    {
        return str_starts_with((string) $this->mime_type, 'image/');
    }

    public function getKindLabelAttribute(): string
    {
        return $this->is_image ? 'صورة' : 'PDF';
    }

    public function getSizeLabelAttribute(): string
    {
        return PatientFileService::formatBytes((int) $this->size);
    }

    public function getDateLabelAttribute(): string
    {
        return $this->created_at
            ? $this->created_at->copy()->timezone('Africa/Cairo')->locale('ar')->translatedFormat('d M Y')
            : '';
    }
}
