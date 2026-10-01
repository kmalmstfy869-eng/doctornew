<?php

namespace App\View\Components\Doctor\Dashboard;

use App\Models\Doctor;
use App\Models\Plan;
use App\Models\Subscription as Subs;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Subscription extends Component
{
    public Doctor $doctor;

    public ?Subs $subscription;

    public ?Plan $plan;

    public ?string $planSlug;

    public int $totalDays = 0;

    public float $remainingDays = 0;

    public float $progress = 0;

    public ?string $renewalDate = null;

    public function __construct(Doctor $doctor)
    {
        $this->doctor = $doctor;

        $this->subscription = $doctor->subscription;

        $this->plan = $this->subscription?->plan;

        $this->planSlug = $this->plan?->slug;

        $this->calculateSubscription();
    }

    protected function calculateSubscription(): void
    {
        if (
            ! $this->doctor->hasFeature('subscription') ||
            ! $this->subscription ||
            ! $this->subscription->start_date ||
            ! $this->subscription->end_date
        ) {
            return;
        }

        $startDate = $this->subscription->start_date;

        $endDate = $this->subscription->end_date;


        $this->totalDays = max(
            1,
            $startDate->diffInDays($endDate)
        );


        $this->remainingDays = max(
            0,
            now()->diffInHours($endDate, false) / 24
        );


        $passedDays = max(
            0,
            $this->totalDays - $this->remainingDays
        );


        $this->progress = min(
            100,
            max(
                0,
                ($passedDays / $this->totalDays) * 100
            )
        );


        $this->renewalDate = $endDate->translatedFormat('d F Y');
    }

    public function render(): View|Closure|string
    {
        return view('components.doctor.dashboard.subscription');
    }
}
