<?php

namespace App\Models;

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
}
