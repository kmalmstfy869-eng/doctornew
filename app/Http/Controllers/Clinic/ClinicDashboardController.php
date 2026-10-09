<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Doctor;
use App\Services\Clinic\AppointmentSlotService;
use App\Services\Clinic\ClinicFinanceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClinicDashboardController extends Controller
{
    protected string $timezone = 'Africa/Cairo';

    public function __construct(
        protected AppointmentSlotService $slotService,
        protected ClinicFinanceService $finance
    ) {}

    public function index()
    {
        $user = Auth::user();
        $doctor = $user->clinicDoctor();

        $isClinicSystem = $doctor->hasFeature('clinic_system');
        $isAssistant = (bool) $user->doctorAssistant;

        $stats = $this->computeStats($doctor);

        $slots = $this->slotsData($doctor);
        $slotsStats = $slots['stats'];
        $scheduleSlots = $slots['slots'];

        $dashboardQueue = $this->buildDashboardQueue($doctor);

        $recentBookings = $doctor->bookings()->latest()->take(6)->get();

        $income = ['today' => 0, 'month' => 0];
        $revenueChart = [];
        $bookingsChart = $this->finance->bookingsSplitLastSevenDays($doctor->id);

        if ($isClinicSystem && ! $isAssistant) {
            $income = [
                'today' => $this->finance->today($doctor->id)['income'],
                'month' => $this->finance->month($doctor->id)['income'],
            ];
            $revenueChart = $this->finance->revenueLastSevenDays($doctor->id);
        }

        return view(
            'doctor.clinic.index',
            array_merge(
                compact(
                    'doctor',
                    'income',
                    'revenueChart',
                    'bookingsChart',
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

    public function queueData(Request $request)
    {
        $doctor = Auth::user()->clinicDoctor();

        $stats = $this->computeStats($doctor);
        $slots = $this->slotsData($doctor);

        $scheduleSlots = $slots['slots'];
        $dashboardQueue = $this->buildDashboardQueue($doctor);
        $recentBookings = $doctor->bookings()->latest()->take(6)->get();

        return response()->json(array_merge($stats, [
            'slotsAvailable' => $slots['stats']['available'],
            'slotsBlocked' => $slots['stats']['blocked'],
            'scheduleHtml' => view('doctor.clinic.dashboard.partials.schedule-list', compact('scheduleSlots'))->render(),
            'queueHtml' => view('doctor.clinic.dashboard.partials.queue-list', compact('dashboardQueue'))->render(),
            'recentBookingsHtml' => view('doctor.clinic.dashboard.partials.recent-bookings', compact('recentBookings'))->render(),
        ]));
    }

    /* ===================================================================== */

    private function slotsData(Doctor $doctor): array
    {
        $today = Carbon::today($this->timezone)->format('Y-m-d');
        $todaySlots = collect($this->slotService->getDoctorSlots($doctor, $today));

        return [
            'stats' => [
                'available' => $todaySlots->where('status', 'available')->count(),
                'blocked' => $todaySlots->where('status', 'blocked')->count(),
            ],
            'slots' => $todaySlots->take(12)->values(),
        ];
    }

    private function computeStats(Doctor $doctor): array
    {
        $base = fn () => $doctor->bookings()
            ->whereDate('appointment_date', Carbon::today($this->timezone)->toDateString());

        return [
            'TotalBooking' => $base()->count(),
            'TotalBookingOnline' => $base()->where('booking_type', 'online')->count(),
            'TotalBookingClinic' => $base()
                ->where(fn ($q) => $q->where('booking_type', '!=', 'online')->orWhereNull('booking_type'))
                ->count(),
            'waitingPatients' => $base()->whereIn('status', ['pending', 'confirmed'])->count(),
            'completedPatients' => $base()->where('status', 'completed')->count(),
            'cancelledPatients' => $base()->whereIn('status', ['cancelled', 'no_show'])->count(),
        ];
    }

    private function buildDashboardQueue(Doctor $doctor)
    {
        $today = Carbon::today($this->timezone)->toDateString();

        $currentExam = $doctor->bookings()
            ->whereDate('appointment_date', $today)
            ->where('status', 'in_progress')
            ->get()
            ->sortBy(fn (Booking $b) => $b->started_at ? $b->started_at->timestamp : PHP_INT_MAX)
            ->values();

        $queuePatients = $this->sortQueue(
            $doctor->bookings()
                ->whereDate('appointment_date', $today)
                ->where('status', 'confirmed')
                ->whereNotNull('arrived_at')
                ->get()
        )->values();

        return $currentExam->concat($queuePatients)->take(6)->values();
    }

    private function sortQueue($bookings)
    {
        return $bookings
            ->groupBy(fn (Booking $b) => Carbon::parse($b->appointment_date)->toDateString())
            ->sortKeys()
            ->flatMap(function ($dayBookings) {
                $priorityOnline = $dayBookings
                    ->filter(fn (Booking $b) => $this->isOnlinePriority($b))
                    ->sort(function (Booking $a, Booking $b) {
                        $aTime = $a->start_time ? (string) $a->start_time : '99:99:99';
                        $bTime = $b->start_time ? (string) $b->start_time : '99:99:99';

                        if ($aTime === $bTime) {
                            return $a->arrived_at->timestamp <=> $b->arrived_at->timestamp;
                        }

                        return strcmp($aTime, $bTime);
                    })
                    ->values();

                $normalQueue = $dayBookings
                    ->reject(fn (Booking $b) => $this->isOnlinePriority($b))
                    ->sort(fn (Booking $a, Booking $b) => $a->arrived_at->timestamp <=> $b->arrived_at->timestamp)
                    ->values();

                return $priorityOnline->concat($normalQueue);
            })
            ->values();
    }

    private function isOnlinePriority(Booking $booking): bool
    {
        if ($booking->booking_type !== 'online' || ! $booking->start_time || ! $booking->arrived_at) {
            return false;
        }

        $appointmentTime = Carbon::parse(
            Carbon::parse($booking->appointment_date)->toDateString() . ' ' . $booking->start_time
        );

        $arrivalTime = Carbon::parse($booking->arrived_at);
        $earlyLimit = $appointmentTime->copy()->subMinutes(30);
        $lateLimit = $appointmentTime->copy()->addMinutes(30);

        if ($arrivalTime->lt($earlyLimit)) {
            return now()->greaterThanOrEqualTo($earlyLimit);
        }

        return $arrivalTime->between($earlyLimit, $lateLimit);
    }
}
