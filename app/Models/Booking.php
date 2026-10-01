<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
protected $fillable = [
    'doctor_id',
    'patient_id',
    'patient_name',
    'patient_phone',
    'booking_type',
    'appointment_date',
    'start_time',
    'status',
    'price',
    'paid',
    'service',
    'queue_position',
    'arrived_at',
    'called_at',
    'started_at',
    'completed_at',
];

    protected $casts = [
        'appointment_date' => 'date',
        'started_at' => 'datetime',
        'arrived_at' => 'datetime',
        'called_at' => 'datetime',
        'completed_at' => 'datetime',
        'price' => 'decimal:2',
    ];




    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}

