<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;
        protected $fillable = [
            'user_id',
            'area_id',
            'specialty_id',
            'phone',
            'whatsapp',
            'experience',
            'consultation_price',
            'clinic_name',
            'address',
            'google_maps_url',
            'working_hours',
            'bio',
            'status',
            'services',
            'doctor_image',
            'clinic_images',
        ];

    protected $casts = [
        'clinic_images' => 'array',
        'services' => 'array',
        'created_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    */

public function hasFeature(string $feature): bool
{
    if (
        ! $this->subscription ||
        $this->subscription->status !== 'active' ||
        ! $this->subscription->start_date ||
        $this->subscription->start_date->isFuture() ||
        ! $this->subscription->end_date ||
        ! $this->subscription->end_date->isFuture()
    ) {
        return false;
    }

    $planName = strtolower(
        trim($this->subscription->plan?->name ?? '')
    );

    return match (strtolower($feature)) {
        'booking' => in_array(
            $planName,
            ['professional', 'clinic system']
        ),

        'subscription' => $planName !== 'free',

        'clinic_system' => $planName === 'clinic system',

        default => false,
    };
}
    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeOrderByPlan(Builder $query)
    {
        return $query
            ->join(
                'subscriptions',
                'doctors.id',
                '=',
                'subscriptions.doctor_id'
            )
            ->join(
                'plans',
                'subscriptions.plan_id',
                '=',
                'plans.id'
            )
            ->orderByRaw("
                CASE
                    WHEN subscriptions.status = 'active'
                        AND subscriptions.end_date IS NOT NULL
                        AND subscriptions.end_date > NOW()
                    THEN plans.sort_order
                    ELSE 999
                END ASC
            ")
            ->select('doctors.*');
    }

    public function scopeDoctors(Builder $query)
    {
        return $query->whereHas('user', function ($query) {
            $query->where('role', 'doctor');
        });
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('doctors.status', 'approved');
    }

    public function scopeNotactive(Builder $query)
    {
        return $query->where('doctors.status', 'pending');
    }

    public function scopeRejected(Builder $query)
    {
        return $query->where('status', 'rejected');
    }
    public function scopeSubscribed(Builder $query)
    {
        return $query
            ->whereHas('subscription.plan', function ($query) {
                $query->where('name', '!=', 'free');
            })
            ->whereHas('subscription', function ($query) {
                $query
                    ->where('status', 'active')
                    ->whereNotNull('start_date')
                    ->where('start_date', '<=', now())
                    ->whereNotNull('end_date')
                    ->where('end_date', '>', now());
            });
    }

    public function scopeNotSubscribed(Builder $query)
    {
        return $query->where(function ($query) {
            $query
                ->whereHas('subscription.plan', function ($query) {
                    $query->where('name', 'free');
                })
                ->orWhereHas('subscription', function ($query) {
                    $query
                        ->where('status', '!=', 'active')
                        ->orWhere(function ($query) {
                            $query
                                ->whereNotNull('end_date')
                                ->where('end_date', '<=', now());
                        })
                        ->orWhere(function ($query) {
                            $query
                                ->whereNotNull('start_date')
                                ->where('start_date', '>', now());
                        });
                });
        });
    }
        public function scopeSearch($query, ?string $term)
        {
            $term = trim((string) $term);
            if ($term === '') {
                return $query;
            }

            $like = '%' . addcslashes($term, '%_\\') . '%';
            $id   = ltrim($term, '#');

            return $query->where(function ($q) use ($like, $id) {
                $q->where('phone', 'like', $like)
                ->orwhere('whatsapp', 'like', $like)
                ->orWhereHas('user', fn ($u) => $u->where('name', 'like', $like))
                ->orWhereHas('specialty', fn ($s) => $s->where('name', 'like', $like))
                ->orWhereHas('area', fn ($a) => $a->where('name', 'like', $like));

                if (ctype_digit($id)) {
                    $q->orWhere('id', (int) $id);
                }
            });
        }
    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialties::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }
    public function notifications(): HasMany
    {
        return $this->hasMany(DoctorNotification::class);
    }

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function clinicSchedules(): HasMany
    {
        return $this->hasMany(ClinicSchedule::class);
    }
    public function assistants(): HasMany
    {
        return $this->hasMany(DoctorAssistant::class);
    }    public function patientFiles(): HasMany
    {
        return $this->hasMany(PatientFile::class);
    }
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }
    public function storageSubscription()
    {
        return $this->hasOne(StorageSubscription::class);
    }
}
