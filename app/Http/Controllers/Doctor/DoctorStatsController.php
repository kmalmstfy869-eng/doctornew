<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\SiteVisitStat;
use Illuminate\Http\Request;

class DoctorStatsController extends Controller
{
    private const RANGES = [
        7   => 'آخر 7 أيام',
        30  => 'آخر 30 يوم',
        90  => 'آخر 3 شهور',
        365 => 'آخر سنة',
    ];

    private const WEEKDAYS = [
        0 => 'الأحد', 1 => 'الإثنين', 2 => 'الثلاثاء', 3 => 'الأربعاء',
        4 => 'الخميس', 5 => 'الجمعة', 6 => 'السبت',
    ];

    public function index(Request $request)
    {
        $doctor = $request->user()?->doctor;
        abort_if(! $doctor, 403);

        $range = (int) $request->query('range', 30);
        $range = isset(self::RANGES[$range]) ? $range : 30;

        $allTime = SiteVisitStat::forDoctor($doctor->id);

        $data = [
            'ranges'    => self::RANGES,
            'range'     => $range,
            'allTime'   => $allTime,
            'hasAccess' => $this->hasAnalytics($request),
        ];

        if (! $data['hasAccess']) {
            return view('doctor.dashboard.stats.index', $data);
        }

        // الساعة 12 ظهرًا: آمنة من أي تحويل توقيت صيفي/شتوي
        $today = now()->setTime(12, 0, 0);
        $from  = $today->copy()->subDays($range - 1);

        $current  = SiteVisitStat::forDoctor($doctor->id, $from->toDateString(), $today->toDateString());
        $todayRow = SiteVisitStat::forDoctor($doctor->id, $today->toDateString(), $today->toDateString());

        $rows = SiteVisitStat::dailySeries($from->toDateString(), $today->toDateString(), $doctor->id)
            ->keyBy(fn ($r) => $r->stat_date->toDateString());

        // عدد الأيام ثابت = $range بالظبط، من غير مقارنة تواريخ
        $daily = [];
        for ($i = 0; $i < $range; $i++) {
            $d       = $from->copy()->addDays($i)->setTime(12, 0, 0);
            $row     = $rows->get($d->toDateString());
            $daily[] = [
                'date'   => $d,
                'views'  => (int) ($row->views ?? 0),
                'unique' => (int) ($row->unique_visitors ?? 0),
            ];
        }

        [$labels, $views, $uniques] = $this->bucket($daily, $range);

        $weekdayTotals = array_fill(0, 7, 0);
        foreach ($daily as $day) {
            $weekdayTotals[$day['date']->dayOfWeek] += $day['views'];
        }
        $maxWeekday = max($weekdayTotals);
        $weekdays   = [];
        foreach ([6, 0, 1, 2, 3, 4, 5] as $i) {
            $weekdays[] = [
                'name'    => self::WEEKDAYS[$i],
                'views'   => $weekdayTotals[$i],
                'percent' => $maxWeekday > 0 ? round($weekdayTotals[$i] / $maxWeekday * 100) : 0,
                'top'     => $maxWeekday > 0 && $weekdayTotals[$i] === $maxWeekday,
            ];
        }

        $bestDay = collect($daily)->sortByDesc('views')->first();

        return view('doctor.dashboard.stats.index', $data + [
            'current'   => $current,
            'today'     => $todayRow,
            'average'   => round($current['views'] / $range, 1),
            'returning' => max(0, $current['views'] - $current['unique_visitors']),
            'bestDay'   => $bestDay && $bestDay['views'] > 0 ? [
                'label' => $bestDay['date']->copy()->locale('ar')->translatedFormat('l j F'),
                'views' => $bestDay['views'],
            ] : null,
            'weekdays'  => $weekdays,
            'chart'     => ['labels' => $labels, 'views' => $views, 'unique' => $uniques],
        ]);
    }

    private function hasAnalytics(Request $request): bool
    {
        return (bool) $request->user()?->doctor?->hasFeature('subscription');
    }

    /** 7/30 يوم = يومي، 90 = أسبوعي، 365 = شهري */
    private function bucket(array $daily, int $range): array
    {
        $groups = collect($daily);

        if ($range <= 30) {
            $groups = $groups->groupBy(fn ($d) => $d['date']->toDateString());
            $fmt    = 'j M';
        } elseif ($range <= 90) {
            $groups = $groups->chunk(7)->map(fn ($c) => $c->values());
            $fmt    = 'j M';
        } else {
            $groups = $groups->groupBy(fn ($d) => $d['date']->format('Y-m'));
            $fmt    = 'M Y';
        }

        $labels = $views = $uniques = [];
        foreach ($groups as $group) {
            $group     = $group->values();
            $labels[]  = $group->first()['date']->copy()->locale('ar')->translatedFormat($fmt);
            $views[]   = (int) $group->sum('views');
            $uniques[] = (int) $group->sum('unique');
        }

        return [$labels, $views, $uniques];
    }
}
