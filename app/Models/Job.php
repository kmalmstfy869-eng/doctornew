<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Job extends Model
{
   use HasFactory;

    protected $casts = [
        'tasks' => 'array',
        'requirements' => 'array',
        'application_deadline' => 'date',
        'created_at'=>'datetime',
        'updated_at'=>'datetime',
];

    protected $fillable = [
            'user_id',
            'title',
            'company_name',
            'phone',
            'whatsapp',
            'category',
            'qualification',
            'location',
            'job_type',
            'experience',
            'salary_min',
            'salary_max',
            'description',
            'vacancies',
            'working_hours',
            'working_days',
            'application_deadline',
            'status',
        ];
    public function scopeActive(Builder $query)
    {
        return $query->where('jobs.status', 'approved')
        ->where('application_deadline', '>=', now());
    }


public function scopeNotActive(Builder $query)
{
    return $query
        ->where('jobs.status',"!=", 'approved')->orwhere('application_deadline', '<', now());

}


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
