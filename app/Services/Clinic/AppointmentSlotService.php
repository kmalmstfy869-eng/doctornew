<?php

namespace App\Services\Clinic;

use App\Models\BlockedSlot;
use App\Models\Booking;
use App\Models\ClinicSchedule;
use App\Models\Doctor;
use Carbon\Carbon;

class AppointmentSlotService
{
    /**
     * جلب مواعيد الطبيب في يوم معين (نسخة المريض)
     */
    public function getAvailableSlots(
        Doctor $doctor,
        string $date
    ): array {
        $timezone = 'Africa/Cairo';

        $dateObject = Carbon::parse(
            $date,
            $timezone
        )->startOfDay();

        $today = Carbon::now($timezone)->startOfDay();

        if ($dateObject->lt($today)) {
            return [];
        }

        $isToday = $dateObject->isSameDay($today);

        $dayOfWeek = $dateObject->dayOfWeek;

        $schedule = ClinicSchedule::query()
            ->where('doctor_id', $doctor->id)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->first();

        if (!$schedule) {
            return [];
        }

        if (
            !$schedule->start_time ||
            !$schedule->end_time ||
            !$schedule->slot_duration
        ) {
            return [];
        }

        $start = Carbon::parse(
            $dateObject->format('Y-m-d') . ' ' . $schedule->start_time,
            $timezone
        );

        $end = Carbon::parse(
            $dateObject->format('Y-m-d') . ' ' . $schedule->end_time,
            $timezone
        );

        $duration = (int) $schedule->slot_duration;

        $bookings = Booking::query()
            ->where('doctor_id', $doctor->id)
            ->whereDate(
                'appointment_date',
                $dateObject->format('Y-m-d')
            )
            ->where('booking_type', 'online')
            ->whereIn('status', [
                'pending',
                'confirmed',
                'in_progress',
            ])
            ->get([
                'start_time',
            ]);

        $blockedSlots = BlockedSlot::query()
            ->where('doctor_id', $doctor->id)
            ->whereDate('date', $dateObject->format('Y-m-d'))
            ->pluck('start_time')
            ->all();

        $now = Carbon::now($timezone);

        $slots = [];

        while (
            $start->copy()
                ->addMinutes($duration)
                ->lte($end)
        ) {
            $slotStart = $start->copy();

            $isBooked = $bookings->contains(
                function ($booking) use (
                    $slotStart,
                    $timezone
                ) {
                    return $slotStart->format('H:i') ===
                        Carbon::parse(
                            $booking->start_time,
                            $timezone
                        )->format('H:i');
                }
            );

            $isBlocked = in_array(
                $slotStart->format('H:i'),
                $blockedSlots,
                true
            );

            $slot = [
                'start_time' =>
                    $slotStart->format('H:i'),

                'is_booked' =>
                    $isBooked,

                'is_blocked' =>
                    $isBlocked,
            ];

            if (
                $isToday &&
                $slotStart->lte($now)
            ) {
                $slot['is_expired'] = true;
            }

            $slots[] = $slot;

            $start->addMinutes($duration);
        }

        return $slots;
    }

    /**
     * جلب مواعيد اليوم لصفحة إدارة الطبيب (متاح / محجوز / مغلق)
     */
    public function getDoctorSlots(Doctor $doctor, string $date): array
    {
        $timezone = 'Africa/Cairo';

        $dateObject = Carbon::parse($date, $timezone)->startOfDay();

        $today = Carbon::now($timezone)->startOfDay();

        if ($dateObject->lt($today)) {
            return [];
        }

        $isToday = $dateObject->isSameDay($today);

        $dayOfWeek = $dateObject->dayOfWeek;

        $schedule = ClinicSchedule::query()
            ->where('doctor_id', $doctor->id)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->first();

        if (
            !$schedule ||
            !$schedule->start_time ||
            !$schedule->end_time ||
            !$schedule->slot_duration
        ) {
            return [];
        }

        $start = Carbon::parse(
            $dateObject->format('Y-m-d') . ' ' . $schedule->start_time,
            $timezone
        );

        $end = Carbon::parse(
            $dateObject->format('Y-m-d') . ' ' . $schedule->end_time,
            $timezone
        );

        $duration = (int) $schedule->slot_duration;

        $bookings = Booking::query()
            ->where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', $dateObject->format('Y-m-d'))
            ->whereIn('status', ['pending', 'confirmed', 'in_progress'])
            ->get();

        $blockedSlots = BlockedSlot::query()
            ->where('doctor_id', $doctor->id)
            ->whereDate('date', $dateObject->format('Y-m-d'))
            ->get()
            ->keyBy('start_time');

        $now = Carbon::now($timezone);

        $slots = [];

        while ($start->copy()->addMinutes($duration)->lte($end)) {

            $slotStart = $start->copy();
            $slotEnd = $slotStart->copy()->addMinutes($duration);
            $key = $slotStart->format('H:i');

            $booking = $bookings->first(
                fn ($b) => Carbon::parse($b->start_time, $timezone)->format('H:i') === $key
            );

            $blocked = $blockedSlots->get($key);

            $isExpired = $isToday && $slotStart->lte($now);

            $status = 'available';
            $label = 'متاح للحجز الإلكتروني';
            $bookingId = null;

            if ($booking) {
                $status = 'booked';
                $patientName = $booking->patient_name
                    ?? $booking->patient?->name
                    ?? 'مريض';
            $label = 'بواسطة : ' . $patientName;
                $bookingId = $booking->id;
            } elseif ($blocked) {
                $status = 'blocked';
                $reason = $blocked->reason ?: 'استراحة';
                $label = 'السبب: ' . $reason;
            } elseif ($isExpired) {
                /*
                |----------------------------------------------------------------
                | لو الموعد "متاح" فعليًا بس وقته عدى، بنعتبره حالة مستقلة
                | مش "متاح" ومش "محجوز" ومش "مغلق يدويًا"
                |----------------------------------------------------------------
                */
                $status = 'expired';
                $label = 'تم إغلاقه تلقائيًا لانتهاء وقته';
            }

            $slots[] = [
                'start_time' => $key,
                'start_label' => $slotStart->format('h:i'),
                'start_period' => $slotStart->format('A') === 'AM' ? 'ص' : 'م',
                'end_label' => $slotEnd->format('h:i'),
                'end_period' => $slotEnd->format('A') === 'AM' ? 'ص' : 'م',
                'status' => $status,
                'label' => $label,
                'is_expired' => $isExpired,
                'booking_id' => $bookingId,
                'blocked_id' => $blocked?->id,
            ];

            $start->addMinutes($duration);
        }

        return $slots;
    }
    }
