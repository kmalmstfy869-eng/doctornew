<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * ترتيب أيام الأسبوع بالعربي، وقيمة DAYOFWEEK بتاعة MySQL لكل يوم
     * (1 = الأحد ... 7 = السبت).
     */
    private const WEEK_DAYS = [
        7 => 'السبت',
        1 => 'الأحد',
        2 => 'الإثنين',
        3 => 'الثلاثاء',
        4 => 'الأربعاء',
        5 => 'الخميس',
        6 => 'الجمعة',
    ];

    /**
     * الحالات دي مش حجز فعلي (لسه في انتظار الحضور أو مؤكد بس ماحضرش)،
     * فمستبعدة من أي عدّ للحجوزات في الصفحة دي — عدا الحجوزات الملغاة
     * اللي بتتحسب لوحدها في خانتها الخاصة.
     */
    private const NOT_ACTUAL_BOOKING_STATUSES = ['pending', 'confirmed'];

    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $doctor = $user->doctor()->firstOrFail();

        $period = $request->query('period', 'month');

        if (! in_array($period, ['week', 'month', 'quarter', 'year'], true)) {
            $period = 'month';
        }

        [$from, $to] = $this->periodRange($period);

        $fromDate = $from->toDateString();
        $toDate = $to->toDateString();

        /*
        |--------------------------------------------------------------------------
        | كويري واحد: إحصائيات الحجوزات + مصادر الحجز خلال الفترة
        |--------------------------------------------------------------------------
        |
        | مستبعد منها pending و confirmed لأنها مش حجز فعلي حتى الآن؛
        | الملغاة و"لم يحضر" (cancelled, no_show) متضمنة في خانة واحدة
        | لأنها منطقيًا نفس الشيء: مريض لم يُشاهَد.
        |
        */

        $stats = DB::table('bookings')
            ->where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', '>=', $fromDate)
            ->whereDate('appointment_date', '<=', $toDate)
            ->whereNotIn('status', self::NOT_ACTUAL_BOOKING_STATUSES)
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status IN ('cancelled', 'no_show') THEN 1 ELSE 0 END) as cancelled,
                SUM(CASE WHEN booking_type = 'online' THEN 1 ELSE 0 END) as online,
                SUM(CASE WHEN booking_type != 'online' OR booking_type IS NULL THEN 1 ELSE 0 END) as clinic
            ")
            ->first();

        $total = (int) $stats->total;
        $completed = (int) $stats->completed;
        $cancelled = (int) $stats->cancelled;
        $online = (int) $stats->online;
        $clinicSource = (int) $stats->clinic;

        $completedPercentage = $total > 0 ? round(($completed / $total) * 100, 1) : 0;
        $cancelledPercentage = $total > 0 ? round(($cancelled / $total) * 100, 1) : 0;
        $onlinePercentage = $total > 0 ? round(($online / $total) * 100, 1) : 0;
        $clinicPercentage = $total > 0 ? round(($clinicSource / $total) * 100, 1) : 0;

        $daysInPeriod = max(1, $from->diffInDays($to->min(today())) + 1);
        $averageBookingsPerDay = round($total / $daysInPeriod, 1);

        /*
        |--------------------------------------------------------------------------
        | كويري تاني: توزيع الحجوزات على أيام الأسبوع خلال نفس الفترة
        |--------------------------------------------------------------------------
        */

        $dayCounts = DB::table('bookings')
            ->where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', '>=', $fromDate)
            ->whereDate('appointment_date', '<=', $toDate)
            ->whereNotIn('status', self::NOT_ACTUAL_BOOKING_STATUSES)
            ->selectRaw('DAYOFWEEK(appointment_date) as dow, COUNT(*) as c')
            ->groupBy('dow')
            ->pluck('c', 'dow');

        $busyDays = [];

        foreach (self::WEEK_DAYS as $dow => $label) {
            $busyDays[] = [
                'day' => $label,
                'count' => (int) ($dayCounts[$dow] ?? 0),
            ];
        }

        $maxBusyDay = ! empty($busyDays) ? max(array_column($busyDays, 'count')) : 0;

        $topDay = collect($busyDays)->sortByDesc('count')->first();

        /*
        |--------------------------------------------------------------------------
        | كويري تالت: الحجوزات شهريًا لآخر 6 شهور (أونلاين مقابل عيادة)
        | مستقل عن فلتر الفترة، زي التصميم الأصلي
        |--------------------------------------------------------------------------
        */

        $chartStart = today()->subMonths(5)->startOfMonth();

        $monthlyRowsFull = DB::table('bookings')
            ->where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', '>=', $chartStart->toDateString())
            ->whereDate('appointment_date', '<=', today()->toDateString())
            ->whereNotIn('status', self::NOT_ACTUAL_BOOKING_STATUSES)
            ->selectRaw("
                DATE_FORMAT(appointment_date, '%Y-%m') as ym,
                SUM(CASE WHEN booking_type = 'online' THEN 1 ELSE 0 END) as online,
                SUM(CASE WHEN booking_type != 'online' OR booking_type IS NULL THEN 1 ELSE 0 END) as clinic
            ")
            ->groupBy('ym')
            ->get()
            ->keyBy('ym');

        $months = [];
        $cursor = $chartStart->copy();

        for ($i = 0; $i < 6; $i++) {
            $key = $cursor->format('Y-m');
            $row = $monthlyRowsFull->get($key);

            $months[] = [
                'label' => $cursor->translatedFormat('M'),
                'online' => (int) ($row->online ?? 0),
                'clinic' => (int) ($row->clinic ?? 0),
            ];

            $cursor->addMonth();
        }

        $chartMax = max(1, collect($months)->flatMap(fn ($m) => [$m['online'], $m['clinic']])->max());

        $monthlyChart = array_map(function ($m) use ($chartMax) {
            $m['onlineHeight'] = (int) round(($m['online'] / $chartMax) * 100);
            $m['clinicHeight'] = (int) round(($m['clinic'] / $chartMax) * 100);

            return $m;
        }, $months);

        /*
        |--------------------------------------------------------------------------
        | كويري رابع: إجمالي المرضى + مرضى جدد هذا الشهر (aggregate واحد)
        |--------------------------------------------------------------------------
        */

        $patientStats = DB::table('patients')
            ->where('doctor_id', $doctor->id)
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN created_at >= ? THEN 1 ELSE 0 END) as new_this_month
            ', [today()->startOfMonth()->toDateTimeString()])
            ->first();

        $totalPatients = (int) $patientStats->total;
        $newPatientsThisMonth = (int) $patientStats->new_this_month;

        /*
        |--------------------------------------------------------------------------
        | مصادر الحجز جاهزة للعرض
        |--------------------------------------------------------------------------
        */

        $bookingSources = [
            [
                'label' => 'حجز أونلاين من التطبيق',
                'icon' => 'globe',
                'badge' => 'badge-success',
                'count' => $online,
                'percentage' => $onlinePercentage,
            ],
            [
                'label' => 'حجز من العيادة',
                'icon' => 'hospital',
                'badge' => 'badge-primary',
                'count' => $clinicSource,
                'percentage' => $clinicPercentage,
            ],
        ];

        return view('doctor.clinic.reports.index', [
            'period' => $period,

            'totalBookings' => $total,
            'completedBookings' => $completed,
            'completedPercentage' => $completedPercentage,
            'cancelledBookings' => $cancelled,
            'cancelledPercentage' => $cancelledPercentage,
            'averageBookingsPerDay' => $averageBookingsPerDay,

            'totalPatients' => $totalPatients,
            'newPatientsThisMonth' => $newPatientsThisMonth,

            'busyDays' => $busyDays,
            'maxBusyDay' => $maxBusyDay,
            'topDay' => $topDay,

            'monthlyChart' => $monthlyChart,

            'bookingSources' => $bookingSources,
        ]);
    }

    /**
     * @return array{0: Carbon, 1: Carbon}
     */
    private function periodRange(string $period): array
    {
        return match ($period) {
            'week' => [today()->subDays(6), today()],
            'quarter' => [today()->subMonths(3)->addDay(), today()],
            'year' => [today()->startOfYear(), today()],
            default => [today()->startOfMonth(), today()],
        };
    }
}
