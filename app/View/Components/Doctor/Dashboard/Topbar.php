<?php

namespace App\View\Components\Doctor\Dashboard;

use App\Models\Doctor;
use App\Models\Subscription;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Topbar extends Component
{
    public Doctor $doctor;

    public string $doctorName;

    public bool $isSubscribed = false;

    public bool $isExpiringSoon = false;

    public ?Subscription $subscription = null;

    public string $planName = 'مجاني';

    public string $subscriptionStatus = 'مجاني';

    public string $remainingDaysText = 'غير محدد';

    public ?string $expirationDate = null;

    public string $rating = 'لا توجد تقييمات';

    public bool $hasClinicPhotos = false;

    public bool $hasProfilePhoto = false;

    public int $completion = 0;


    public function __construct(Doctor $doctor , string $doctorname="طبيب")
    {
        $this->doctor = $doctor;

        $this->doctorName = $doctorname;

        $this->prepareSubscription();

        $this->prepareRating();

        $this->prepareProfileCompletion();
    }



    protected function prepareSubscription(): void
    {

        $subscription = $this->doctor->subscription;


        $this->isSubscribed = $this->doctor->hasFeature('subscription');

        if (! $this->isSubscribed || ! $subscription) {

            $this->planName = 'مجاني';

            $this->subscriptionStatus = 'مجاني';

            $this->remainingDaysText = 'غير محدد';

            $this->expirationDate = null;

            return;
        }

        $this->subscription = $subscription;


        $this->planName =
            $subscription->plan?->name
            ?? 'اشتراك نشط';



        if ($subscription->end_date) {

            $this->expirationDate =
                $subscription->end_date
                    ->translatedFormat('d F Y');
        }



        if ($subscription->end_date) {

            $remainingDays =
                max(
                    0,
                    now()->diffInHours(
                        $subscription->end_date,
                        false
                    ) / 24
                );



            $this->remainingDaysText =
                $this->formatRemainingDays($remainingDays);



            if ($remainingDays <= 7) {

                $this->isExpiringSoon = true;

                $this->subscriptionStatus =
                    'أوشك على الانتهاء';

                return;
            }
        }


        $this->subscriptionStatus = 'نشط';
    }



    protected function prepareRating(): void
    {

    $rating = $this->doctor->rating()->avg('rating');

        $this->rating = $rating
            ? number_format((float) $rating, 1) . ' / 5'
            : 'لا توجد تقييمات';
    }



    protected function prepareProfileCompletion(): void
    {
        // البيانات الأساسية + التخصص + العنوان + مواعيد العمل: إجبارية دايمًا صح
        $mandatoryDone = 4;
        $optionalTotal = 2; // صور العيادة + الصورة الشخصية بس

        $clinicImages = $this->doctor->clinic_images;

        $this->hasClinicPhotos = ! empty($clinicImages)
            && is_array($clinicImages)
            && count($clinicImages) > 0;

        $this->hasProfilePhoto = (bool) $this->doctor->doctor_image;

        $optionalDone = 0;
        if ($this->hasClinicPhotos) $optionalDone++;
        if ($this->hasProfilePhoto) $optionalDone++;

        $totalItems = $mandatoryDone + $optionalTotal;
        $doneItems  = $mandatoryDone + $optionalDone;

        $this->completion = (int) round(($doneItems / $totalItems) * 100);
    }



    protected function formatRemainingDays(float $days): string
    {
        if ($days <= 0) {
            return 'منتهي';
        }

        if ($days < 1) {
            return 'أقل من يوم';
        }

        $days = round($days, 1);

        return 'متبقي ' . number_format($days, 1) . ' يوم';
    }


    public function render(): View|Closure|string
    {
        return view('components.doctor.dashboard.topbar');
    }
}
