<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteVisitStat;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SiteStatsController extends Controller
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
        $range = (int) $request->query('range', 30);
        $range = isset(self::RANGES[$range]) ? $range : 30;

        // الساعة 12 ظهرًا: آمنة من تغيير التوقيت الصيفي/الشتوي
        $today    = now()->setTime(12, 0, 0);
        $from     = $today->copy()->subDays($range - 1);
        $prevTo   = $from->copy()->subDay();
        $prevFrom = $prevTo->copy()->subDays($range - 1);

        $current  = $this->totals($from, $today);
        $previous = $this->totals($prevFrom, $prevTo);
        $todayRow = $this->totals($today, $today);
        $allTime  = $this->totals();

        // تقسيم الفترة: الرئيسية vs صفحات الأطباء (إجماليات فقط، بدون تفاصيل كل طبيب)
        $split = ['home' => ['views' => 0, 'unique' => 0], 'profiles' => ['views' => 0, 'unique' => 0]];
        $typeRows = SiteVisitStat::query()
            ->whereBetween('stat_date', [$from->toDateString(), $today->toDateString()])
            ->selectRaw('page_type, COALESCE(SUM(views),0) as v, COALESCE(SUM(unique_visitors),0) as u')
            ->groupBy('page_type')
            ->toBase()->get();

        foreach ($typeRows as $r) {
            $key = (string) $r->page_type === (string) SiteVisitStat::HOME ? 'home'
                : ((string) $r->page_type === (string) SiteVisitStat::DOCTOR_PROFILE ? 'profiles' : null);
            if ($key) {
                $split[$key] = ['views' => (int) $r->v, 'unique' => (int) $r->u];
            }
        }
        $splitMax = max(1, $split['home']['views'], $split['profiles']['views']);

        // السلسلة اليومية
        $rows = SiteVisitStat::query()
            ->whereBetween('stat_date', [$from->toDateString(), $today->toDateString()])
            ->selectRaw('stat_date, COALESCE(SUM(views),0) as v, COALESCE(SUM(unique_visitors),0) as u')
            ->groupBy('stat_date')
            ->toBase()->get()
            ->keyBy(fn ($r) => substr((string) $r->stat_date, 0, 10));

        $daily = [];
        for ($i = 0; $i < $range; $i++) {
            $d       = $from->copy()->addDays($i)->setTime(12, 0, 0);
            $row     = $rows->get($d->toDateString());
            $daily[] = [
                'date'   => $d,
                'views'  => (int) ($row->v ?? 0),
                'unique' => (int) ($row->u ?? 0),
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

        return view('admin.stats.index', [
            'ranges'    => self::RANGES,
            'range'     => $range,
            'current'   => $current,
            'today'     => $todayRow,
            'allTime'   => $allTime,
            'average'   => round($current['views'] / $range, 1),
            'returning' => max(0, $current['views'] - $current['unique']),
            'viewsChange'  => $this->change($current['views'], $previous['views']),
            'uniqueChange' => $this->change($current['unique'], $previous['unique']),
            'split'     => $split,
            'splitMax'  => $splitMax,
            'weekdays'  => $weekdays,
            'bestDay'   => $bestDay && $bestDay['views'] > 0 ? [
                'label' => $bestDay['date']->copy()->locale('ar')->translatedFormat('l j F'),
                'views' => $bestDay['views'],
            ] : null,
            'chart'     => ['labels' => $labels, 'views' => $views, 'unique' => $uniques],
        ]);
    }

    /** إجماليات الموقع كله (null = منذ البداية) */
    private function totals(?Carbon $from = null, ?Carbon $to = null): array
    {
        $row = SiteVisitStat::query()
            ->when($from && $to, fn ($q) => $q->whereBetween('stat_date', [$from->toDateString(), $to->toDateString()]))
            ->selectRaw('COALESCE(SUM(views),0) as v, COALESCE(SUM(unique_visitors),0) as u')
            ->toBase()->first();

        return ['views' => (int) ($row->v ?? 0), 'unique' => (int) ($row->u ?? 0)];
    }

    /** نسبة التغيير عن الفترة السابقة (null لو مفيش بيانات سابقة) */
    private function change(int $now, int $before): ?float
    {
        return $before > 0 ? round(($now - $before) / $before * 100, 1) : null;
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
