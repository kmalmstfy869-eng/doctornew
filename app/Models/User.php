<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;

#[Fillable([
    'name',
    'email',
    'password',
    'email_verified_at',
    'remember_token',
    'role',
])]
#[Hidden([
    'password',
    'remember_token',
])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasPushSubscriptions;

    public const PENDING_EMAIL_TTL_MINUTES = 60;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'pending_email_requested_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function doctorAssistant(): HasOne
    {
        return $this->hasOne(DoctorAssistant::class);
    }

    public function routeNotificationForWebPush(): Collection
    {
        return $this->pushSubscriptions()
            ->where('is_active', true)
            ->get();
    }

    public function clinicDoctor()
    {
        return $this->doctor ?? $this->doctorAssistant?->doctor;
    }
    public function favoriteDoctors()
    {
        return $this->belongsToMany(Doctor::class, 'favorites')->withTimestamps();
    }
    /*
    |--------------------------------------------------------------------------
    | Pending email
    |--------------------------------------------------------------------------
    */

    public function requestEmailChange(string $newEmail): void
    {
        $this->forceFill([
            'pending_email' => $newEmail,
            'pending_email_requested_at' => now(),
        ])->save();
    }

    public function hasValidPendingEmail(): bool
    {
        return $this->pending_email !== null
            && $this->pending_email_requested_at !== null
            && $this->pending_email_requested_at->gt(
                now()->subMinutes(self::PENDING_EMAIL_TTL_MINUTES)
            );
    }

    public function confirmPendingEmail(): bool
    {
        if (! $this->hasValidPendingEmail()) {
            $this->clearPendingEmail();
            return false;
        }

        $this->forceFill([
            'email' => $this->pending_email,
            'email_verified_at' => now(),
            'pending_email' => null,
            'pending_email_requested_at' => null,
        ])->save();

        return true;
    }

    public function clearPendingEmail(): void
    {
        $this->forceFill([
            'pending_email' => null,
            'pending_email_requested_at' => null,
        ])->save();
    }

    public function scopeExpiredPendingEmail(Builder $query): Builder
    {
        return $query->whereNotNull('pending_email')
            ->where(
                'pending_email_requested_at',
                '<',
                now()->subMinutes(self::PENDING_EMAIL_TTL_MINUTES)
            );
    }
}
