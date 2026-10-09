<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Support\Whatsapp;
class SubscriptionController extends Controller
{
    private const TIERS = [
        'prime' => [
            'name' => 'Prime',
            'icon' => 'fa-star',
            'off'  => ['حجز المواعيد أونلاين', 'نظام إدارة العيادة'],
        ],
        'professional' => [
            'name' => 'Professional',
            'icon' => 'fa-crown',
            'off'  => ['نظام إدارة العيادة'],
        ],
        'clinic-system' => [
            'name' => 'Clinic System',
            'icon' => 'fa-gem',
            'off'  => [],
        ],
    ];

    private const DURATIONS = [
        'monthly'  => ['label' => 'شهري',    'unit' => 'شهر'],
        '3-months' => ['label' => '3 شهور', 'unit' => '3 شهور'],
        'yearly'   => ['label' => 'سنوي',    'unit' => 'سنة'],
    ];

    public function index(Request $request)
    {
        $doctor = $request->user()->doctor()->with('subscription.plan')->firstOrFail();
        $doctorName = $doctor->user->name;

        $subscription = $doctor->subscription;
        $keys = array_keys(self::TIERS);

        // ---------- الباقة الحالية ----------
        $currentSlug = strtolower($subscription?->plan?->slug ?? '');
        $currentKey = null;
        $currentDuration = null;

        $pattern = '/^(' . implode('|', array_map('preg_quote', $keys)) . ')-(monthly|3-months|yearly)$/';

        if (preg_match($pattern, $currentSlug, $m)) {
            $currentKey = $m[1];
            $currentDuration = $m[2];
        }

        $isSubscribed = $doctor->hasFeature('subscription') && $currentKey !== null;
        $currentIndex = $currentKey ? array_search($currentKey, $keys, true) : -1;
        $isHighest = $isSubscribed && $currentIndex === count($keys) - 1;

        $daysLeft = null;
        $expiringSoon = false;

        if ($isSubscribed && $subscription?->end_date) {
            $daysLeft = max(0, (int) ceil(now()->diffInDays($subscription->end_date, false)));
            $expiringSoon = $daysLeft <= 7;
        }

        // ---------- الباقات من الجدول ----------
        $plans = Plan::where('slug', '!=', 'free')->get();

        $tiers = [];

        foreach ($keys as $i => $key) {
            $meta = self::TIERS[$key];

            $tierPlans = $plans->filter(
                fn ($p) => preg_match('/^' . preg_quote($key, '/') . '-(monthly|3-months|yearly)$/', strtolower($p->slug))
            );

            $base = $tierPlans->firstWhere('slug', "{$key}-monthly") ?? $tierPlans->first();

            if (! $base) {
                continue;
            }

            $state = ! $isSubscribed ? 'new'
                : ($i === $currentIndex ? 'current' : ($i > $currentIndex ? 'upgrade' : 'lower'));

            $durations = [];

            foreach (self::DURATIONS as $dKey => $d) {
                $plan = $tierPlans->firstWhere('slug', "{$key}-{$dKey}");

                if (! $plan) {
                    continue;
                }

                $link = match ($state) {
                    'new'     => Whatsapp::link("مرحباً، أريد الاشتراك في باقة {$meta['name']} ({$d['label']}). الدكتور: {$doctorName}"),
                    'upgrade' => Whatsapp::link("مرحباً، أريد ترقية اشتراكي إلى باقة {$meta['name']} ({$d['label']}). الدكتور: {$doctorName}"),
                    default   => null,
                };

                $locked = $state === 'current' && $dKey === $currentDuration;

                // السعر الأصلي من الجدول، ولو دي مدة اشتراك الدكتور الحالية نعرض السعر اللي اشترك به
                $price = ($locked && $subscription && (int) $subscription->price > 0)
                    ? $subscription->price
                    : $plan->price;

                $durations[$dKey] = [
                    'unit'   => $d['unit'],
                    'price'  => $price,
                    'locked' => $locked,
                    'link'   => $link,
                ];
            }

            $tiers[] = [
                'key'       => $key,
                'name'      => $meta['name'],
                'icon'      => $meta['icon'],
                'desc'      => $base->description,
                'features'  => $base->features ?? [],
                'off'       => $meta['off'],
                'state'     => $state,
                'durations' => $durations,
            ];
        }

        $currentTier = $currentKey ? collect($tiers)->firstWhere('key', $currentKey) : null;

        $renewLink = $currentTier
            ? Whatsapp::link(
                "مرحباً، أريد تجديد اشتراكي في باقة {$currentTier['name']}"
                . ($currentDuration ? ' (' . self::DURATIONS[$currentDuration]['label'] . ')' : '')
                . ". الدكتور: {$doctorName}"
            )
            : null;

        return view('doctor.dashboard.subscription.index', [
            'doctor'          => $doctor,
            'doctor_name'     => $doctorName,
            'subscription'    => $subscription,
            'tiers'           => $tiers,
            'durations'       => self::DURATIONS,
            'initialDuration' => $currentDuration ?? array_key_first(self::DURATIONS),
            'currentTier'     => $currentTier,
            'currentDuration' => $currentDuration ? self::DURATIONS[$currentDuration]['label'] : null,
            'isSubscribed'    => $isSubscribed,
            'isHighest'       => $isHighest,
            'daysLeft'        => $daysLeft,
            'expiringSoon'    => $expiringSoon,
            'renewLink'       => $renewLink,
        ]);
    }


}
