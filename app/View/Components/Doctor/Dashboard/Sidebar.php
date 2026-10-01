<?php

namespace App\View\Components\Doctor\Dashboard;

use App\Models\Doctor;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public Doctor $doctor;

    public string $doctorname;

    public string $planSlug;

    public ?string $doctorImage;

    public int $newRatingsCount = 0;

    public int $notificationsCount = 0;

    /**
     * Create a new component instance.
     */
    public function __construct(
        Doctor $doctor,
        string $doctorname
    ) {

        $this->doctor = $doctor;

        $this->doctorname = $doctorname;

        $this->planSlug = strtolower(
            $doctor->subscription?->plan?->slug ?? ''
        );

        $this->doctorImage = $doctor->doctor_image;

        /*
        |--------------------------------------------------------------------------
        | New Ratings
        |--------------------------------------------------------------------------
        */

        try {

            $this->newRatingsCount = $doctor->ratings()
                ->where('is_read', false)
                ->where('status', 'approved')
                ->count();

        } catch (\Throwable $e) {

            // لو حصل أي خطأ، خصوصًا لو is_read مش موجود لسه
            $this->newRatingsCount = 0;
        }
        try {

            $this->notificationsCount = $this->doctor
            ->notifications()
            ->where('is_read', false)
            ->count();

        } catch (\Throwable $e) {

            // لو حصل أي خطأ، خصوصًا لو is_read مش موجود لسه
            $this->notificationsCount = 0;
        }



    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.doctor.dashboard.sidebar');
    }
}
