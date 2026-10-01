<?php

namespace App\Services\Clinic;

use App\Models\Booking;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class BookingService
{
    /**
     * إنشاء حجز جديد
     */
    public function createBooking(
        Doctor $doctor,
        array $data
    ): Booking|RedirectResponse {

        return DB::transaction(function () use ($doctor, $data) {

            /*
            |--------------------------------------------------------------------------
            | التأكد أن الموعد غير محجوز
            |--------------------------------------------------------------------------
            |
            | الـ Controller بالفعل قام بعمل Validation
            | للـ start_time.
            |
            | هنا التحقق مختلف:
            | نتأكد أن نفس الموعد لم يتم حجزه بالفعل.
            |
            */

            if (!empty($data['start_time'])) {

                $exists = Booking::query()
                    ->where('doctor_id', $doctor->id)
                    ->whereDate(
                        'appointment_date',
                        $data['appointment_date']
                    )
                    ->where(
                        'start_time',
                        $data['start_time']
                    )
                    ->whereIn('status', [
                        'pending',
                        'confirmed',
                        'in_progress',
                    ])
                    ->exists();

                if ($exists) {

                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'start_time' =>
                            'هذا الموعد محجوز بالفعل.',
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | سعر الحجز
            |--------------------------------------------------------------------------
            */

            $price = $data['price']
                ?? $doctor->consultation_price;

            /*
            |--------------------------------------------------------------------------
            | إنشاء الحجز
            |--------------------------------------------------------------------------
            */

            try {

                return Booking::create([
                    'doctor_id' =>
                        $doctor->id,

                    'patient_id' =>
                        $data['patient_id'] ?? null,

                    'patient_name' =>
                        $data['patient_name'],

                    'patient_phone' =>
                        $data['patient_phone'] ?? null,

                    'booking_type' =>
                        $data['booking_type'],

                    'appointment_date' =>
                        $data['appointment_date'],

                    'start_time' =>
                        $data['start_time'] ?? null,

                    'arrived_at' =>
                        null,

                    'status' =>
                        $data['status'] ?? 'pending',

                    'price' =>
                        $price,
                ]);

            } catch (QueryException $e) {

                /*
                |--------------------------------------------------------------------------
                | تعارض الـ unique constraint
                |--------------------------------------------------------------------------
                */

                if ($e->getCode() === '23000') {

                    return redirect()
                        ->back()
                        ->with(
                            'error',
                            'هذا الموعد تم حجزه للتو، يرجى اختيار موعد آخر.'
                        )
                        ->withInput();
                }

                throw $e;
            }
        });
    }

    /**
     * تسجيل وصول المريض
     */
    public function markAsArrived(
        Booking $booking
    ): Booking {

        $booking->update([
            'arrived_at' =>
                Carbon::now(),
        ]);

        return $booking->fresh();
    }
}
