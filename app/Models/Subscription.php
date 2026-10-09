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
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function doctor(){
            return $this->belongsTo(Doctor::class);
    }
    public function plan(){
            return $this->belongsTo(Plan::class);
    }


    public function scopePaidPlans($q)
    {
        return $q->whereHas('plan', fn ($p) => $p->where('slug', '!=', 'free'));
    }



    public function scopeRunning($q)
    {
        return $q->where('status', 'active')
            ->whereDate('start_date', '<=', today())
            ->whereDate('end_date', '>', today());
    }

    public function scopeEnded($q)
    {
        return $q->where(fn ($w) => $w->where('status', '!=', 'active')
            ->orWhereDate('end_date', '<=', today())
            ->orWhereDate('start_date', '>', today()));
    }

    public function scopeExpiringIn($q, int $days = 7)
    {
        return $q->running()->whereDate('end_date', '<=', today()->addDays($days));
    }

    public function getIsRunningAttribute(): bool
    {
        return $this->status === 'active'
            && ! $this->start_date->isFuture()
            && $this->days_left > 0;
    }

    public function getDaysLeftAttribute(): int
    {
        return (int) today()->diffInDays($this->end_date, false);
    }



    public function modalPayload(): array
    {
        return [
            'id'         => $this->id,
            'doctor'     => $this->doctor?->user?->name,
            'plan_id'    => $this->plan_id,
            'plan_name'  => $this->plan?->name,
            'plan_price' => (float) $this->plan?->price,
            'paid'       => (float) $this->price,
            'start'      => $this->start_date->toDateString(),
            'end'        => $this->end_date->toDateString(),
            'days_left'  => $this->days_left,
            'running'    => $this->is_running,
            'url_change' => route('admin.subscriptions.change', $this, false),
            'url_renew'  => route('admin.subscriptions.renew', $this, false),
        ];
    }
    }
