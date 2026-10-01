<?php

namespace App\Observers;

use App\Models\Rating;
use App\Services\NotificationService;

class RatingObserver
{
    public function created(Rating $rating): void
    {
        $doctor = $rating->doctor;

        if (!$doctor) {
            return;
        }

        app(NotificationService::class)->send(
            $doctor,
            'rating',
            'تقييم جديد',
            'تم إضافة تقييم جديد إلى ملفك الطبي.',
            route('doctor.reviews')
        );
    }
}
