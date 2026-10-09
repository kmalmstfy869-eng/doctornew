<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientFileBackupRun extends Model
{
    protected $guarded = [];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];


    public static function lastSuccessful(): ?self
    {
        return static::query()->where('status', 'success')->latest('finished_at')->first();
    }


    public static function cairo($date): string
    {
        return $date ? $date->copy()->timezone('Africa/Cairo')->translatedFormat('d M Y - h:i A') : '—';
    }

    public function getStartedLabelAttribute(): string
    {
        return self::cairo($this->started_at);
    }

    public function getFinishedLabelAttribute(): string
    {
        return self::cairo($this->finished_at);
    }

    public function getDurationLabelAttribute(): string
    {
        if (! $this->finished_at) {
            return '—';
        }

        $s = (int) abs($this->started_at->diffInSeconds($this->finished_at));

        return $s < 60 ? "{$s} ث" : floor($s / 60) . ' د ' . ($s % 60) . ' ث';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'success' => 'ناجح',
            'partial' => 'جزئي',
            'failed' => 'فشل',
            'running' => 'شغال / معلّق',
            default => (string) $this->status,
        };
    }

    // لون الـ Badge: ok / warn / bad / info.
    public function getStatusToneAttribute(): string
    {
        return match ($this->status) {
            'success' => 'ok',
            'partial' => 'warn',
            'failed' => 'bad',
            default => 'info',
        };
    }
}
