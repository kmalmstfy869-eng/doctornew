<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\BlockedSlot;
use App\Services\Clinic\AppointmentSlotService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ClinicSlotsController extends Controller
{
    protected string $timezone = 'Africa/Cairo';

    public function __construct(
        protected AppointmentSlotService $slotService
    ) {}

    public function index(Request $request)
    {
        $user = Auth::user();
        $doctor = $user->clinicDoctor();

        $requestedDate = $request->query('date');

        $date = $requestedDate
            ? Carbon::parse($requestedDate, $this->timezone)->startOfDay()
            : Carbon::now($this->timezone)->startOfDay();

        $today = Carbon::now($this->timezone)->startOfDay();

        $isPastDate = $date->lt($today);

        $slots = $this->slotService->getDoctorSlots($doctor, $date->format('Y-m-d'));

        // نحدد أي سلوت "مغلق" وقته فعليًا عدى، عشان نمنع فتحه من الواجهة
        foreach ($slots as &$slot) {
            if ($slot['status'] === 'blocked') {
                $slotTime = Carbon::parse($date->format('Y-m-d').' '.$slot['start_time'], $this->timezone);
                $slot['blocked_time_passed'] = $slotTime->isPast();
            }
        }
        unset($slot);

        $stats = [
            'total' => count($slots),
            'available' => collect($slots)->where('status', 'available')->count(),
            'booked' => collect($slots)->where('status', 'booked')->count(),
            'blocked' => collect($slots)->where('status', 'blocked')->count(),
            'expired' => collect($slots)->where('status', 'expired')->count(),
        ];

        return view('doctor.clinic.slots.index', [
            'date' => $date,
            'slots' => $slots,
            'stats' => $stats,
            'prevDate' => $date->copy()->subDay()->format('Y-m-d'),
            'nextDate' => $date->copy()->addDay()->format('Y-m-d'),
            'todayDate' => $today->format('Y-m-d'),
            'isToday' => $date->isSameDay($today),
            'isPastDate' => $isPastDate,
        ]);
    }

    public function close(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'times' => ['required', 'array', 'min:1'],
            'times.*' => ['required', 'string'],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

            $user = Auth::user();
        $doctor = $user->clinicDoctor();

        foreach ($validated['times'] as $time) {
            BlockedSlot::updateOrCreate(
                [
                    'doctor_id' => $doctor->id,
                    'date' => $validated['date'],
                    'start_time' => $time,
                ],
                [
                    'reason' => $validated['reason'] ?: 'مغلق من الطبيب',
                ]
            );
        }

        return back()->with('success', 'تم إغلاق المواعيد المحددة بنجاح.');
    }
    public function open(Request $request, BlockedSlot $blockedSlot)
    {      $user = Auth::user();
        $doctor = $user->clinicDoctor();

        abort_if($blockedSlot->doctor_id !== $doctor->id, 403);

        $slotTime = Carbon::parse(
            Carbon::parse($blockedSlot->date)->format('Y-m-d').' '.$blockedSlot->start_time,
            $this->timezone
        );

        if ($slotTime->isPast()) {
            return back()->with('error', 'لا يمكن فتح هذا الموعد لأن وقته قد انتهى بالفعل.');
        }

        $blockedSlot->delete();

        return back()->with('success', 'تم فتح الموعد بنجاح.');
    }
}
