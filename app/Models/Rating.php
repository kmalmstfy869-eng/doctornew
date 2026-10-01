<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Doctor;
class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'user_id',
        'rating',
        'comment',
        'status',
        ];

    protected $CAST=[
            'created_at'=>'datetime',
            'updated_at'=>'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}

