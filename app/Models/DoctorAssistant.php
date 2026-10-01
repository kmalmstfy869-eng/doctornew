<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorAssistant extends Model
{
        protected $fillable = [
            'doctor_id',
            'user_id',
            'phone',
            'is_active',
        ];
            protected $casts = [
        'is_active' => 'boolean',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
