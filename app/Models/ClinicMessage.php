<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClinicMessage extends Model
{
    public const TYPE_DOCTOR_CALL = 'doctor_call_patient';
    public const TYPE_PATIENT_MISSING = 'assistant_patient_missing';

    public const TYPES = [
        self::TYPE_DOCTOR_CALL,
        self::TYPE_PATIENT_MISSING,
    ];

    public const STATUS_ACTIVE = 'active';
    public const STATUS_RESOLVED = 'resolved';
    public const STATUS_DELETED = 'deleted';

    public const ROLE_DOCTOR = 'doctor';
    public const ROLE_ASSISTANT = 'assistant';

    protected $fillable = [
        'doctor_id',
        'booking_id',
        'sender_user_id',
        'resolved_by_user_id',
        'recipient_role',
        'type',
        'status',
        'patient_name',
        'message',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * دور المستخدم الحالي مع الدكتور ده: doctor | assistant | null
     */
    public static function roleFor(User $user, ?Doctor $doctor): ?string
    {
        if (!$doctor) {
            return null;
        }

        if ((int) $doctor->user_id === (int) $user->id) {
            return self::ROLE_DOCTOR;
        }

        $isAssistant = DoctorAssistant::query()
            ->where('doctor_id', $doctor->id)
            ->where('user_id', $user->id)
            ->where('is_active', true)
            ->exists();

        return $isAssistant ? self::ROLE_ASSISTANT : null;
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }
}