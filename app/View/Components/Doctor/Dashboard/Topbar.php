<?php

namespace App\View\Components\Doctor\Dashboard;

use App\Models\Doctor;
use App\Models\Subscription;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Favorite;
use App\Models\SiteVisitStat;

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

    public int $profileViews = 0;

    public int $uniqueVisitors = 0;

    public int $favoritesCount = 0;

    public function __construct(Doctor $doctor, string $doctorname = "طبيب")
    {
        $this->doctor = $doctor;

        $this->doctorName = $doctorname;

        $this->prepareSubscription();

        $this->prepareRating();

        $this->prepareStatistics();

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

        $this->planName = $subscription->plan?->name ?? 'اشتراك نشط';

        if ($subscription->end_date) {
            $this->expirationDate = $subscription->end_date->translatedFormat('d F Y');

            $remainingDays = max(
                0,
                (int) ceil(now()->diffInSeconds($subscription->end_date, false) / 86400)
            );

            $this->remainingDaysText = $this->formatRemainingDays($remainingDays);

            if ($remainingDays <= 7) {
                $this->isExpiringSoon = true;
                $this->subscriptionStatus = 'أوشك على الانتهاء';

                return;
            }
        }

        $this->subscriptionStatus = 'نشط';
    }

    protected function prepareStatistics(): void
    {
        $stats = SiteVisitStat::forDoctor($this->doctor->id);

        $this->profileViews   = $stats['views'];
        $this->uniqueVisitors = $stats['unique_visitors'];
        $this->favoritesCount = Favorite::where('doctor_id', $this->doctor->id)->count();
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

    protected function formatRemainingDays(int $days): string
    {
        if ($days <= 0) {
            return 'منتهي';
        }

        if ($days === 1) {
            return 'متبقي يوم واحد';
        }

        return 'متبقي ' . $days . ' يوم';
    }

    public function render(): View|Closure|string
    {
        return view('components.doctor.dashboard.topbar');
    }
}
