<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Patient;
use App\Support\PhoneNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $doctor = $user->clinicDoctor();

        $isClinicSystem = $doctor->hasFeature('clinic_system');

        $today = Carbon::today()->toDateString();
        $yesterday = Carbon::yesterday()->toDateString();

        $hasYesterdayOpenPatients = $doctor->bookings()
            ->whereDate('appointment_date', $yesterday)
            ->where(function ($query) {
                $query
                    ->where(function ($query) {
                        $query
                            ->where('status', 'confirmed')
                            ->whereNotNull('arrived_at');
                    })
                    ->orWhere('status', 'in_progress');
            })
            ->exists();

        $bookingDates = [$today];

        if ($hasYesterdayOpenPatients) {
            $bookingDates[] = $yesterday;
        }

        $todayBookings = $doctor->bookings()
            ->whereIn('appointment_date', $bookingDates)
            ->get();

        $queuePatients = $this->sortQueue(
            $todayBookings
                ->where('status', 'confirmed')
                ->whereNotNull('arrived_at')
        )->values();

        $queuePatients->transform(function (Booking $booking) {
            $booking->arrival_status = $this->getOnlineArrivalStatus($booking);

            return $booking;
        });

        $currentExam = $todayBookings
            ->where('status', 'in_progress')
            ->sortBy(function (Booking $booking) {
                return $booking->started_at
                    ? $booking->started_at->timestamp
                    : PHP_INT_MAX;
            })
            ->take(5)
            ->values();

        $queueCount = $queuePatients->count();

        $examCount = $todayBookings
            ->where('status', 'in_progress')
            ->count();

        $doneCount = $todayBookings
            ->where('status', 'completed')
            ->count();

        $total = $todayBookings->count();

        $bookings = $this->buildFilteredBookingsQuery($request, $doctor, $bookingDates)
            ->orderByDesc('appointment_date')
            ->orderByDesc('start_time')
            ->paginate(20)
            ->withQueryString();

        return view(
            'doctor.clinic.booking.index',
            compact(
                'bookings',
                'queuePatients',
                'currentExam',
                'queueCount',
                'examCount',
                'doneCount',
                'total',
                'isClinicSystem'
            )
        );
    }

    public function searchPatients(Request $request)
    {
        $user = Auth::user();
        $doctor = $user->clinicDoctor();

        $search = trim(
            (string) $request->get('search', '')
        );

        $patients = $doctor->patients()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->limit(20)
            ->get([
                'id',
                'name',
                'phone',
            ]);

        return response()->json([
            'patients' => $patients,
        ]);
    }

    public function store(StoreBookingRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $doctor = $user->clinicDoctor();

        try {
            return DB::transaction(function () use ($request, $doctor, $user) {
                $validated = $request->validated();

                $patient = null;

                if (!empty($validated['patient_id'])) {
                    $patient = $doctor->patients()->findOrFail($validated['patient_id']);

                    $patientName  = $patient->name;
                    $patientPhone = PhoneNumber::normalize($patient->phone);
                } else {
                    $patientName  = trim($validated['new_patient_name'] ?? '');
                    $patientPhone = PhoneNumber::normalize($validated['patient_phone'] ?? null);

                    // ملف المريض بيتعمل بس لو فيه رقم + نظام العيادة شغال
                    if ($patientPhone && $user->can('use-clinic-system')) {
                        $patient = Patient::firstOrCreate(
                            ['doctor_id' => $doctor->id, 'phone' => $patientPhone],
                            ['name' => $patientName]
                        );

                        // لو المريض موجود نسيب اسمه القديم، ولو جديد هو نفس الاسم المكتوب
                        $patientName = $patient->name;
                    }
                }

                // منع تكرار نفس الرقم/المريض في نفس اليوم
                if ($patient || $patientPhone) {
                    $exists = $doctor->bookings()
                        ->whereDate('appointment_date', $validated['appointment_date'])
                        ->whereNotIn('status', ['cancelled', 'no_show'])
                        ->where(function ($q) use ($patient, $patientPhone) {
                            if ($patient) {
                                $q->where('patient_id', $patient->id);
                            }

                            if ($patientPhone) {
                                $q->orWhere('patient_phone', $patientPhone);
                            }
                        })
                        ->lockForUpdate()
                        ->exists();

                    if ($exists) {
                        return back()
                            ->withErrors([
                                'appointment_date' => 'يوجد حجز بنفس رقم الهاتف في هذا اليوم.',
                            ])
                            ->withInput();
                    }
                }

                Booking::create([
                    'doctor_id'        => $doctor->id,
                    'patient_id'       => $patient?->id,
                    'patient_name'     => $patientName,
                    'patient_phone'    => $patientPhone,
                    'booking_type'     => 'clinic',
                    'appointment_date' => $validated['appointment_date'],
                    'start_time'       => null,
                    'status'           => 'confirmed',
                    'price'            => (float) ($validated['price'] ?? 0),
                    'paid'             => (float) ($validated['paid'] ?? 0),
                    'service'          => $validated['service'] ?? 'كشف',
                    'arrived_at'       => now(),
                ]);

                return back()->with('success', 'تم إنشاء الحجز بنجاح.');
            });
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->with('error', 'حدثت مشكلة أثناء إنشاء الحجز. برجاء التواصل مع الإدارة للمساعدة فورًا إذا استمرت المشكلة.')
                ->withInput();
        }
    }

    public function arrive(Booking $booking)
    {
        $this->authorizeBooking($booking);
        $user = Auth::user();
        $doctor = $user->clinicDoctor();

        if (
            in_array(
                $booking->status,
                [
                    'completed',
                    'cancelled',
                    'no_show',
                    'in_progress',
                ]
            )
        ) {
            return back()->with(
                'error',
                'لا يمكن تسجيل وصول هذا الحجز.'
            );
        }

        if ($booking->arrived_at) {
            return back()->with(
                'error',
                'المريض مسجل وصوله بالفعل.'
            );
        }

        DB::transaction(function () use ($booking, $doctor, $user) {
            if (
                $booking->booking_type === 'online' &&
                !$booking->patient_id &&
                !empty($booking->patient_phone) &&
                $user->can('use-clinic-system')
            ) {
                $phone = PhoneNumber::normalize($booking->patient_phone);

                $patient = Patient::firstOrCreate(
                    ['doctor_id' => $doctor->id, 'phone' => $phone],
                    ['name' => $booking->patient_name]
                );

                $booking->update([
                    'patient_id'    => $patient->id,
                    'patient_phone' => $phone,
                ]);
            }

            $booking->update([
                'arrived_at' => now(),
                'status' => 'confirmed',
            ]);
        });

        return back()->with(
            'success',
            'تم تسجيل وصول المريض وإضافته للطابور.'
        );
    }

    public function call(Booking $booking)
    {
        $this->authorizeBooking($booking);

        if (
            $booking->status !== 'confirmed' ||
            !$booking->arrived_at
        ) {
            return back()->with(
                'error',
                'لا يمكن استدعاء المريض حاليًا، لأن المريض لم يتم تسجيل وصوله أو أن الحجز ليس في طابور الانتظار.'
            );
        }

        $booking->update([
            'called_at' => now(),
        ]);

        return back()->with(
            'success',
            'تم استدعاء المريض.'
        );
    }

    public function start(Booking $booking)
    {
        $this->authorizeBooking($booking);

        if (
            $booking->status !== 'confirmed' ||
            !$booking->arrived_at
        ) {
            return back()->with(
                'error',
                'لا يمكن بدء الكشف، يجب أن يكون الحجز في طابور الانتظار وأن يتم تسجيل وصول المريض أولاً.'
            );
        }

        DB::transaction(function () use ($booking) {
            $booking->update([
                'status' => 'in_progress',
                'started_at' => now(),
                'called_at' => $booking->called_at ?: now(),
            ]);
        });

        return back()->with(
            'success',
            'بدأ الكشف.'
        );
    }

    public function finish(Booking $booking)
    {
        $this->authorizeBooking($booking);

        if ($booking->status !== 'in_progress') {
            return back()->with(
                'error',
                'هذا الحجز ليس داخل الكشف.'
            );
        }

        $booking->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return back()->with(
            'success',
            'تم إنهاء الكشف.'
        );
    }

    public function noShow(Booking $booking)
    {
        $this->authorizeBooking($booking);

        if ($booking->status !== 'pending') {
            return back()->with(
                'error',
                'لا يمكن تسجيل عدم الحضور، لأن المريض حضر بالفعل.'
            );
        }

        $booking->update([
            'status' => 'no_show',
        ]);

        return back()->with(
            'success',
            'تم تسجيل المريض كغير حاضر.'
        );
    }

    public function cancel(Booking $booking)
    {
        $this->authorizeBooking($booking);

        if (
            in_array(
                $booking->status,
                [
                    'completed',
                    'cancelled',
                    'in_progress',
                    'no_show',
                ]
            )
        ) {
            return back()->with(
                'error',
                'لا يمكن إلغاء الحجز، لأن المريض حضر بالفعل أو تم التعامل مع الحجز.'
            );
        }

        DB::transaction(function () use ($booking) {
            $booking->update([
                'status' => 'cancelled',
            ]);
        });

        return back()->with(
            'success',
            'تم إلغاء الحجز.'
        );
    }

    public function updateService(
        Request $request,
        Booking $booking
    ) {
        $this->authorizeBooking($booking);

        if (
            in_array(
                $booking->status,
                [
                    'in_progress',
                    'completed',
                ]
            )
        ) {
            return back()
                ->withErrors(
                    [
                        'service' =>
                            'لا يمكن تعديل الخدمة بعد بدء الكشف.',
                    ],
                    'service'
                )
                ->withInput();
        }

        $validated = $request->validateWithBag(
            'service',
            [
                'service' => [
                    'nullable',
                    'string',
                    'max:100',
                ],
            ],
            [
                'service.string' =>
                    'الخدمة يجب أن تكون نصًا صحيحًا.',

                'service.max' =>
                    'اسم الخدمة طويل جدًا.',
            ]
        );

        $booking->update([
            'service' => $validated['service'] ?: null,
        ]);

        return back()->with(
            'success',
            'تم تحديث الخدمة بنجاح.'
        );
    }

    public function payment(
        Request $request,
        Booking $booking
    ) {
        $this->authorizeBooking($booking);

        $validator = Validator::make($request->all(), [
            'price' => ['required', 'numeric', 'min:0'],
            'paid'  => ['required', 'numeric', 'min:0', 'lte:price'],
        ], [
            'price.required' => 'سعر الكشف مطلوب.',
            'price.numeric'  => 'سعر الكشف يجب أن يكون رقمًا.',
            'price.min'      => 'سعر الكشف لا يمكن أن يكون أقل من صفر.',
            'paid.required'  => 'المبلغ المدفوع مطلوب.',
            'paid.numeric'   => 'المبلغ المدفوع يجب أن يكون رقمًا.',
            'paid.min'       => 'المبلغ المدفوع لا يمكن أن يكون أقل من صفر.',
            'paid.lte'       => 'المبلغ المدفوع لا يمكن أن يكون أكبر من سعر الكشف.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'payment')
                ->withInput(array_merge(
                    $request->all(),
                    ['_payment_booking_id' => $booking->id]
                ));
        }

        $booking->update($validator->validated());

        return back()->with('success', 'تم تحديث بيانات الدفع.');
    }

    private function authorizeBooking(
        Booking $booking
    ): void {
        $user = Auth::user();
        $doctor = $user->clinicDoctor();

        abort_unless(
            (int) $booking->doctor_id === (int) $doctor->id,
            403
        );
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
                    ->sort(function (
                        Booking $a,
                        Booking $b
                    ) {
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

                        return strcmp(
                            $aTime,
                            $bTime
                        );
                    })
                    ->values();

                $normalQueue = $dayBookings
                    ->reject(function (Booking $booking) {
                        return $this->isOnlinePriority($booking);
                    })
                    ->sort(function (
                        Booking $a,
                        Booking $b
                    ) {
                        return $a->arrived_at->timestamp
                            <=> $b->arrived_at->timestamp;
                    })
                    ->values();

                return $priorityOnline
                    ->concat($normalQueue);
            })
            ->values();
    }

    private function isOnlinePriority(
        Booking $booking
    ): bool {
        if (
            $booking->booking_type !== 'online' ||
            !$booking->start_time ||
            !$booking->arrived_at
        ) {
            return false;
        }

        $appointmentTime = Carbon::parse(
            Carbon::parse(
                $booking->appointment_date
            )->toDateString()
            . ' '
            . $booking->start_time
        );

        $arrivalTime = Carbon::parse(
            $booking->arrived_at
        );

        $now = now();

        $earlyLimit = $appointmentTime
            ->copy()
            ->subMinutes(30);

        $lateLimit = $appointmentTime
            ->copy()
            ->addMinutes(30);

        if ($arrivalTime->lt($earlyLimit)) {
            return $now->greaterThanOrEqualTo(
                $earlyLimit
            );
        }

        return $arrivalTime->between(
            $earlyLimit,
            $lateLimit
        );
    }

    private function getOnlineArrivalStatus(
        Booking $booking
    ): ?string {
        if (
            $booking->booking_type !== 'online' ||
            !$booking->start_time ||
            !$booking->arrived_at
        ) {
            return null;
        }

        $appointmentDate = Carbon::parse(
            $booking->appointment_date
        )->toDateString();

        $appointmentTime = Carbon::parse(
            $appointmentDate
            . ' '
            . $booking->start_time
        );

        $arrivalTime = Carbon::parse(
            $booking->arrived_at
        );

        $now = now();

        $earlyLimit = $appointmentTime
            ->copy()
            ->subMinutes(30);

        $lateLimit = $appointmentTime
            ->copy()
            ->addMinutes(30);

        if ($arrivalTime->lt($earlyLimit)) {
            return $now->greaterThanOrEqualTo($earlyLimit)
                ? 'جاء موعده'
                : 'حضر قبل موعده';
        }

        if ($arrivalTime->lt($appointmentTime)) {
            return 'حضر في موعده';
        }

        if ($arrivalTime->lte($lateLimit)) {
            return 'جاء موعده';
        }

        return 'تأخر عن موعده';
    }

    /*
    |--------------------------------------------------------------------------
    | بناء استعلام فلاتر جدول الحجوزات (مستخدم في index() و queueData())
    | with('patient:id,phone') لتفادي N+1 في عرض رقم الهاتف
    |--------------------------------------------------------------------------
    */

    private function buildFilteredBookingsQuery(
        Request $request,
        $doctor,
        array $bookingDates
    ) {
        $query = $doctor->bookings()->with('patient:id,phone');

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('patient_name', 'like', "%{$search}%")
                    ->orWhere('patient_phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('source')) {
            $query->where('booking_type', $request->source);
        }

        return $query->whereIn('appointment_date', $bookingDates);
    }

    public function queueData(Request $request)
    {
        $user = Auth::user();
        $doctor = $user->clinicDoctor();

        $isClinicSystem = $doctor->hasFeature('clinic_system');

        $today = Carbon::today()->toDateString();
        $yesterday = Carbon::yesterday()->toDateString();

        $hasYesterdayOpenPatients = $doctor->bookings()
            ->whereDate(
                'appointment_date',
                $yesterday
            )
            ->where(function ($query) {
                $query
                    ->where(function ($query) {
                        $query
                            ->where('status', 'confirmed')
                            ->whereNotNull('arrived_at');
                    })
                    ->orWhere(
                        'status',
                        'in_progress'
                    );
            })
            ->exists();

        $bookingDates = [$today];

        if ($hasYesterdayOpenPatients) {
            $bookingDates[] = $yesterday;
        }

        $todayBookings = $doctor->bookings()
            ->whereIn(
                'appointment_date',
                $bookingDates
            )
            ->get([
                'id',
                'patient_name',
                'booking_type',
                'start_time',
                'arrived_at',
                'started_at',
                'appointment_date',
                'status',
            ]);

        $queuePatients = $this->sortQueue(
            $todayBookings
                ->where('status', 'confirmed')
                ->whereNotNull('arrived_at')
        )->values();

        $queuePatients->transform(
            function (Booking $booking) {
                $booking->arrival_status =
                    $this->getOnlineArrivalStatus(
                        $booking
                    );

                return $booking;
            }
        );

        $currentExam = $todayBookings
            ->where('status', 'in_progress')
            ->sortBy(function (Booking $booking) {
                return $booking->started_at
                    ? $booking->started_at->timestamp
                    : PHP_INT_MAX;
            })
            ->take(5)
            ->values();

        $examCount = $todayBookings
            ->where('status', 'in_progress')
            ->count();

        $doneCount = $todayBookings
            ->where('status', 'completed')
            ->count();

        $total = $todayBookings->count();

        $bookings = $this->buildFilteredBookingsQuery($request, $doctor, $bookingDates)
            ->orderByDesc('appointment_date')
            ->orderByDesc('start_time')
            ->paginate(20)
            ->withQueryString();

        $bookingsTableHtml = view(
            'doctor.clinic.booking.partials.table-body',
            [
                'bookings' => $bookings,
                'isClinicSystem' => $isClinicSystem,
            ]
        )->render();

        $bookingsMobileHtml = view(
            'doctor.clinic.booking.partials.mobile-cards',
            [
                'bookings' => $bookings,
                'isClinicSystem' => $isClinicSystem,
            ]
        )->render();

        $bookingsPaginationHtml = view(
            'doctor.clinic.booking.partials.pagination',
            [
                'bookings' => $bookings,
            ]
        )->render();

        return response()->json([
            'queuePatients' => $queuePatients,
            'currentExam' => $currentExam,
            'queueCount' => $queuePatients->count(),
            'examCount' => $examCount,
            'doneCount' => $doneCount,
            'total' => $total,
            'bookingsTableHtml' => $bookingsTableHtml,
            'bookingsMobileHtml' => $bookingsMobileHtml,
            'bookingsPaginationHtml' => $bookingsPaginationHtml,
            'bookingsTotal' => $bookings->total(),
        ]);
    }

    public function destroy(Booking $booking)
    {
        $this->authorizeBooking($booking);

        if (in_array($booking->status, ['completed', 'in_progress'], true)) {
            return back()->with(
                'error',
                'لا يمكن حذف حجز تم الكشف عليه أو الكشف جاري عليه.'
            );
        }

        $booking->delete();

        return back()->with('success', 'تم حذف الحجز.');
    }
}
