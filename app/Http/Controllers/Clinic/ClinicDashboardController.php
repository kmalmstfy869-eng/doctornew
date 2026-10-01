<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Doctor;
use App\Models\Payment;
use App\Services\Clinic\AppointmentSlotService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClinicDashboardController extends Controller
{
    private const BOOKING_DONE = 'completed';

    protected string $timezone = 'Africa/Cairo';

    public function __construct(
        protected AppointmentSlotService $slotService
    ) {}

    public function index()
    {
        $user = Auth::user();
        $doctor = $user->clinicDoctor();

        $isClinicSystem = $doctor->hasFeature('clinic_system');
        $isAssistant = (bool) Auth::user()?->doctorAssistant;

        $stats = $this->computeStats($doctor);

        $today = Carbon::today($this->timezone)->format('Y-m-d');

        /*
        |--------------------------------------------------------------------------
        | جدول اليوم — من نفس السيرفس المستخدم في صفحة المواعيد المتاحة
        |--------------------------------------------------------------------------
        */

        $todaySlots = $this->slotService->getDoctorSlots($doctor, $today);

        $slotsStats = [
            'available' => collect($todaySlots)->where('status', 'available')->count(),
            'blocked' => collect($todaySlots)->where('status', 'blocked')->count(),
        ];

        $scheduleSlots = collect($todaySlots)->take(12)->values();

        /*
        |--------------------------------------------------------------------------
        | طابور الانتظار — نفس منطق صفحة الحجوزات (داخل الكشف أولاً ثم المنتظرون)
        |--------------------------------------------------------------------------
        */

        $dashboardQueue = $this->buildDashboardQueue($doctor);

        /*
        |--------------------------------------------------------------------------
        | آخر الحجوزات
        |--------------------------------------------------------------------------
        */

        $recentBookings = $doctor->bookings()
            ->latest()
            ->take(6)
            ->get();

        $income = $this->incomeSummary($doctor->id);

        return view(
            'doctor.clinic.index',
            array_merge(
                compact(
                    'doctor',
                    'income',
                    'isClinicSystem',
                    'isAssistant',
                    'scheduleSlots',
                    'dashboardQueue',
                    'recentBookings',
                    'slotsStats'
                ),
                $stats
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | تحديث AJAX — نفس فكرة queueData في صفحة الحجوزات
    |--------------------------------------------------------------------------
    */

    public function queueData(Request $request)
    {
        $user = Auth::user();
        $doctor = $user->clinicDoctor();

        $stats = $this->computeStats($doctor);

        $today = Carbon::today($this->timezone)->format('Y-m-d');

        $todaySlots = $this->slotService->getDoctorSlots($doctor, $today);

        $slotsStats = [
            'available' => collect($todaySlots)->where('status', 'available')->count(),
            'blocked' => collect($todaySlots)->where('status', 'blocked')->count(),
        ];

        $scheduleSlots = collect($todaySlots)->take(12)->values();

        $dashboardQueue = $this->buildDashboardQueue($doctor);

        $recentBookings = $doctor->bookings()
            ->latest()
            ->take(6)
            ->get();

        $scheduleHtml = view(
            'doctor.clinic.dashboard.partials.schedule-list',
            compact('scheduleSlots')
        )->render();

        $queueHtml = view(
            'doctor.clinic.dashboard.partials.queue-list',
            compact('dashboardQueue')
        )->render();

        $recentBookingsHtml = view(
            'doctor.clinic.dashboard.partials.recent-bookings',
            compact('recentBookings')
        )->render();

        return response()->json(array_merge(
            $stats,
            [
                'slotsAvailable' => $slotsStats['available'],
                'slotsBlocked' => $slotsStats['blocked'],
                'scheduleHtml' => $scheduleHtml,
                'queueHtml' => $queueHtml,
                'recentBookingsHtml' => $recentBookingsHtml,
            ]
        ));
    }

    /* ===================================================================== */

    private function computeStats(Doctor $doctor): array
    {
        $totalBooking = $doctor->bookings()
            ->whereDate('created_at', today())
            ->count();

        $totalBookingOnline = $doctor->bookings()
            ->whereDate('created_at', today())
            ->where('booking_type', 'online')
            ->count();

        $totalBookingClinic = $doctor->bookings()
            ->whereDate('created_at', today())
            ->where('booking_type', 'clinic')
            ->count();

        $waitingPatients = $doctor->bookings()
            ->whereDate('created_at', today())
            ->where(function ($query) {
                $query->where('status', 'pending')
                    ->orWhere('status', 'confirmed');
            })
            ->count();

        $completedPatients = $doctor->bookings()
            ->whereDate('created_at', today())
            ->where('status', 'completed')
            ->count();

        $cancelledPatients = $doctor->bookings()
            ->whereDate('created_at', today())
            ->where(function ($query) {
                $query->where('status', 'cancelled')
                    ->orWhere('status', 'no_show');
            })
            ->count();

        return [
            'TotalBooking' => $totalBooking,
            'TotalBookingOnline' => $totalBookingOnline,
            'TotalBookingClinic' => $totalBookingClinic,
            'waitingPatients' => $waitingPatients,
            'completedPatients' => $completedPatients,
            'cancelledPatients' => $cancelledPatients,
        ];
    }

    /**
     * نفس منطق sortQueue/getOnlineArrivalStatus في BookingController،
     * منسوخة هنا كي لا تتأثر صفحة الحجوزات الأصلية بأي تعديل.
     */
    private function buildDashboardQueue(Doctor $doctor)
    {
        $today = Carbon::today($this->timezone)->toDateString();

        $currentExam = $doctor->bookings()
            ->whereDate('appointment_date', $today)
            ->where('status', 'in_progress')
            ->get()
            ->sortBy(function (Booking $booking) {
                return $booking->started_at
                    ? $booking->started_at->timestamp
                    : PHP_INT_MAX;
            })
            ->values();

        $queuePatients = $this->sortQueue(
            $doctor->bookings()
                ->whereDate('appointment_date', $today)
                ->where('status', 'confirmed')
                ->whereNotNull('arrived_at')
                ->get()
        )->values();

        return $currentExam
            ->concat($queuePatients)
            ->take(6)
            ->values();
    }

    private function sortQueue($bookings)
    {
        return $bookings
            ->groupBy(function (Booking $booking) {
                return Carbon::parse(
                    $booking->appointment_date
                )->toDateString();
            })
            ->sortKeys()
            ->flatMap(function ($dayBookings) {
                $priorityOnline = $dayBookings
                    ->filter(function (Booking $booking) {
                        return $this->isOnlinePriority($booking);
                    })
                    ->sort(function (Booking $a, Booking $b) {
                        $aTime = $a->start_time
                            ? (string) $a->start_time
                            : '99:99:99';

                        $bTime = $b->start_time
                            ? (string) $b->start_time
                            : '99:99:99';

                        if ($aTime === $bTime) {
                            return $a->arrived_at->timestamp
                                <=> $b->arrived_at->timestamp;
                        }

                        return strcmp($aTime, $bTime);
                    })
                    ->values();

                $normalQueue = $dayBookings
                    ->reject(function (Booking $booking) {
                        return $this->isOnlinePriority($booking);
                    })
                    ->sort(function (Booking $a, Booking $b) {
                        return $a->arrived_at->timestamp
                            <=> $b->arrived_at->timestamp;
                    })
                    ->values();

                return $priorityOnline->concat($normalQueue);
            })
            ->values();
    }

    private function isOnlinePriority(Booking $booking): bool
    {
        if (
            $booking->booking_type !== 'online' ||
            !$booking->start_time ||
            !$booking->arrived_at
        ) {
            return false;
        }

        $appointmentTime = Carbon::parse(
            Carbon::parse($booking->appointment_date)->toDateString()
            . ' '
            . $booking->start_time
        );

        $arrivalTime = Carbon::parse($booking->arrived_at);

        $now = now();

        $earlyLimit = $appointmentTime->copy()->subMinutes(30);
        $lateLimit = $appointmentTime->copy()->addMinutes(30);

        if ($arrivalTime->lt($earlyLimit)) {
            return $now->greaterThanOrEqualTo($earlyLimit);
        }

        return $arrivalTime->between($earlyLimit, $lateLimit);
    }

    private function incomeSummary(int $doctorId): array
    {
        $today = Carbon::today('Africa/Cairo');

        $monthStart = $today->copy()->startOfMonth();
        $monthEnd = $today->copy()->endOfMonth();

        $todayBookingIncome = (float) DB::table('bookings')
            ->where('doctor_id', $doctorId)
            ->where('status', self::BOOKING_DONE)
            ->whereDate('appointment_date', $today->toDateString())
            ->sum('paid');

        $monthBookingIncome = (float) DB::table('bookings')
            ->where('doctor_id', $doctorId)
            ->where('status', self::BOOKING_DONE)
            ->whereDate('appointment_date', '>=', $monthStart->toDateString())
            ->whereDate('appointment_date', '<=', $monthEnd->toDateString())
            ->sum('paid');

        $todayPaymentIncome = (float) DB::table('payments')
            ->where('doctor_id', $doctorId)
            ->where('type', Payment::INCOME)
            ->whereDate('paid_at', $today->toDateString())
            ->sum('amount');

        $monthPaymentIncome = (float) DB::table('payments')
            ->where('doctor_id', $doctorId)
            ->where('type', Payment::INCOME)
            ->whereDate('paid_at', '>=', $monthStart->toDateString())
            ->whereDate('paid_at', '<=', $monthEnd->toDateString())
            ->sum('amount');

        return [
            'today' => $todayBookingIncome + $todayPaymentIncome,
            'month' => $monthBookingIncome + $monthPaymentIncome,
        ];
    }
}
