<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Doctor;
use App\Services\Clinic\AppointmentSlotService;
use App\Services\Clinic\BookingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class OnlineBookingController extends Controller
{
    public function __construct(
        protected AppointmentSlotService $appointmentSlotService,
        protected BookingService $bookingService
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | إنشاء حجز أونلاين
    |--------------------------------------------------------------------------
    */

    public function store(
        Doctor $doctor,
        Request $request,
    ) {
        /*
        |--------------------------------------------------------------------------
        | التأكد أن الطبيب مؤهل لاستقبال الحجوزات
        |--------------------------------------------------------------------------
        */

        if (!$doctor->hasFeature('booking')) {
                    return redirect()
            ->back()
            ->with(
                'error',
                'هذا الطبيب ليس له صلاحيه للحجوزات '
            );
        }

        /*
        |--------------------------------------------------------------------------
        | التحقق من بيانات الفورم
        |--------------------------------------------------------------------------
        */

        $validator = Validator::make(
            $request->all(),
            [
                'patient_name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'patient_phone' => [
                    'required',
                    'string',
                    'regex:/^01[0125][0-9]{8}$/',
                ],

                'appointment_date' => [
                    'required',
                    'date',
                ],

                'start_time' => [
                    'required',
                    'date_format:H:i',
                ],
            ],
            [
                'patient_name.required' =>
                    'اسم المريض مطلوب.',

                'patient_name.string' =>
                    'اسم المريض غير صحيح.',

                'patient_name.max' =>
                    'اسم المريض طويل جدًا.',

                'patient_phone.required' =>
                    'رقم الهاتف مطلوب.',

                'patient_phone.string' =>
                    'رقم الهاتف يجب أن يكون نصًا صحيحًا.',

                'patient_phone.regex' =>
                    'يجب إدخال رقم هاتف مصري صحيح.',

                'appointment_date.required' =>
                    'يجب تحديد تاريخ الحجز.',

                'appointment_date.date' =>
                    'تاريخ الحجز غير صحيح.',

                'start_time.required' =>
                    'يجب تحديد وقت بداية الحجز.',

                'start_time.date_format' =>
                    'وقت بداية الحجز غير صحيح.',
            ],
            [
                'patient_name' =>
                    'اسم المريض',

                'patient_phone' =>
                    'رقم الهاتف',

                'appointment_date' =>
                    'تاريخ الحجز',

                'start_time' =>
                    'وقت البداية',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | معالجة أخطاء التحقق
        |--------------------------------------------------------------------------
        */

        if ($validator->fails()) {
            $errors = $validator->errors();

            $fieldErrors = [];

            if ($errors->has('patient_name')) {
                $fieldErrors['patient_name'] =
                    $errors->get('patient_name');
            }

            if ($errors->has('patient_phone')) {
                $fieldErrors['patient_phone'] =
                    $errors->get('patient_phone');
            }

            $appointmentErrors = [];

            if ($errors->has('appointment_date')) {
                $appointmentErrors[] =
                    $errors->first('appointment_date');
            }

            if ($errors->has('start_time')) {
                $appointmentErrors[] =
                    $errors->first('start_time');
            }

            $redirect = redirect()
                ->back()
                ->withInput();

            if (!empty($fieldErrors)) {
                foreach ($fieldErrors as $field => $messages) {
                    $redirect = $redirect->withErrors([
                        $field => $messages,
                    ]);
                }
            }

            if (!empty($appointmentErrors)) {
                $redirect = $redirect->with(
                    'error',
                    $appointmentErrors[0]
                );
            }

            return $redirect;
        }

        $validated = $validator->validated();

        /*
        |--------------------------------------------------------------------------
        | التأكد أن الموعد ما زال متاحًا
        |--------------------------------------------------------------------------
        */

        $availableSlots = $this->appointmentSlotService
            ->getAvailableSlots(
                $doctor,
                $validated['appointment_date']
            );

        $slot = collect($availableSlots)
            ->first(function ($slot) use ($validated) {
                return $slot['start_time'] ===
                    $validated['start_time'];
            });

        /*
        |--------------------------------------------------------------------------
        | الموعد غير موجود في جدول الطبيب
        |--------------------------------------------------------------------------
        */

        if (!$slot) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'هذا الموعد غير متاح حاليًا، يرجى اختيار موعد آخر.'
                )
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | الموعد انتهى
        |--------------------------------------------------------------------------
        */

        if (!empty($slot['is_expired'])) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'عذرًا، وقت هذا الموعد قد انتهى بالفعل، يرجى اختيار موعد آخر.'
                )
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | الموعد محجوز
        |--------------------------------------------------------------------------
        */

        if (!empty($slot['is_booked'])) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'هذا الموعد تم حجزه بالفعل، يرجى اختيار موعد آخر.'
                )
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | منع نفس رقم الهاتف من حجز أكثر من موعد في نفس اليوم
        |--------------------------------------------------------------------------
        */

        $sameDayBooking = Booking::query()
            ->where('doctor_id', $doctor->id)
            ->where(
                'patient_phone',
                $validated['patient_phone']
            )
            ->where(
                'booking_type',
                'online'
            )
            ->whereIn('status', [
                'pending',
                'confirmed',
                'in_progress',
            ])
            ->whereDate(
                'appointment_date',
                $validated['appointment_date']
            )
            ->exists();

        if ($sameDayBooking) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'لا يمكنك حجز أكثر من موعد واحد في نفس اليوم بنفس رقم الهاتف.'
                )
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | التأكد من عدم تجاوز عدد الحجوزات النشطة
        |--------------------------------------------------------------------------
        |
        | المريض الواحد يمكنه إنشاء حجزين نشطين كحد أقصى
        | مع نفس الطبيب.
        |
        */

        $today = Carbon::today('Africa/Cairo')->toDateString();

        $existingBookings = Booking::query()
            ->where('doctor_id', $doctor->id)
            ->where(
                'patient_phone',
                $validated['patient_phone']
            )
            ->where(
                'booking_type',
                'online'
            )
            ->whereIn('status', [
                'pending',
                'confirmed',
                'in_progress',
            ])
            ->whereDate(
                'appointment_date',
                '>=',
                $today
            )
            ->count();

        if ($existingBookings >= 2) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'لا يمكنك إنشاء أكثر من حجزين نشطين مع هذا الطبيب.'
                )
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | إنشاء الحجز
        |--------------------------------------------------------------------------
        */

        try {
            $this->bookingService->createBooking(
                $doctor,
                [
                    'patient_id' => null,

                    'patient_name' =>
                        $validated['patient_name'],

                    'patient_phone' =>
                        $validated['patient_phone'],

                    'booking_type' =>
                        'online',


                    'appointment_date' =>
                        $validated['appointment_date'],

                    'start_time' =>
                        $validated['start_time'],

                    'status' =>
                        'pending',
                ]
            );
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    $e->validator->errors()->first()
                )
                ->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | نجاح الحجز
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->back()
            ->with(
                'success',
                'تم إرسال الحجز بنجاح. برجاء الحضور إلى العيادة قبل موعدك بوقت كافٍ.'
            );
    }
}
