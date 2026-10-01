<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'plan_id',
        'start_date',
        'end_date',
        'status',
        'price',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'decimal:2',
    ];
    public function doctor(){
            return $this->belongsTo(Doctor::class);
    }
    public function plan(){
            return $this->belongsTo(Plan::class);
    }



}
