<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageSubscription extends Model
{
    protected $fillable = ['doctor_id', 'period', 'units', 'gb', 'start_date', 'end_date', 'status', 'locked_price'];

    protected $casts = [
        'units' => 'integer',
        'gb' => 'float',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'locked_price' => 'decimal:2',
    ];

    public function doctor(){ return $this->belongsTo(Doctor::class); }

    /* ---------- الكتالوج ---------- */
    public static function plans(): array { return (array) config('clinic.extra_storage.plans', []); }
    public static function unitGb(): int { return max(1, (int) config('clinic.extra_storage.unit_gb', 25)); }
    public static function periodDays(string $p): int { return (int) (self::plans()[$p]['days'] ?? 30); }
    public static function catalog(string $p, int $units): float
    {
        return round((float) (self::plans()[$p]['price'] ?? 0) * $units, 2);
    }


    public function scopeRunning($q)
    {
        return $q->where('status', 'active')->whereDate('end_date', '>', today());
    }

    public function scopeEnded($q)
    {
        return $q->where(fn ($w) => $w->where('status', '!=', 'active')->orWhereDate('end_date', '<=', today()));
    }

    public function scopeExpiringIn($q, int $days = 7)
    {
        return $q->running()->whereDate('end_date', '<=', today()->addDays($days));
    }

    /* ---------- Accessors ---------- */
    public function getDaysLeftAttribute(): int { return (int) today()->diffInDays($this->end_date, false); }
    public function getIsRunningAttribute(): bool { return $this->status === 'active' && $this->days_left > 0; }
    public function getPeriodLabelAttribute(): string { return self::plans()[$this->period]['label'] ?? $this->period; }
    public function getGbLabelAttribute(): string { return rtrim(rtrim(number_format((float) $this->gb, 2, '.', ''), '0'), '.'); }


    public function getCreditAttribute(): float
    {
        if (! $this->is_running) {
            return 0.0;
        }

        return round(((float) $this->locked_price / max(1, self::periodDays($this->period))) * $this->days_left, 2);
    }

    /** بصمة الحالة: تمنع تنفيذ عملية على نافذة قديمة (أدمنين في نفس الوقت) */
    public function getTokenAttribute(): string
    {
        return substr(sha1(implode('|', [
            $this->id, $this->period, $this->units, $this->status,
            $this->end_date?->toDateString(), (string) $this->locked_price,
        ])), 0, 16);
    }

    public function modalPayload(): array
    {
        return [
            'id' => $this->id,
            'token' => $this->token,
            'doctor' => $this->doctor?->user?->name,
            'period' => $this->period,
            'period_label' => $this->period_label,
            'units' => $this->units,
            'gb' => $this->gb,
            'gb_label' => $this->gb_label,
            'price' => (float) $this->locked_price,
            'catalog' => self::catalog($this->period, $this->units),
            'start' => $this->start_date->toDateString(),
            'end' => $this->end_date->toDateString(),
            'left' => $this->days_left,
            'running' => $this->is_running,
            'credit' => $this->credit,
            'used_gb' => round(((int) ($this->used_bytes ?? 0)) / 1073741824, 2),
            'url_change' => route('admin.storage.extra.change', $this),
            'url_renew' => route('admin.storage.extra.renew', $this),
        ];
    }
}
