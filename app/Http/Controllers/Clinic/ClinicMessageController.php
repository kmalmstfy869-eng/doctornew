<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ClinicMessage;
use App\Models\Doctor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClinicMessageController extends Controller
{
    private const POLL_LIMIT = 30;
    private const ACTIVE_IDS_LIMIT = 200;

    /*
    |--------------------------------------------------------------------------
    | Polling: الرسائل الجديدة + قائمة الـ ids الشغالة (عشان نشيل اللي اتحل)
    |--------------------------------------------------------------------------
    */
    public function index(Request $request): JsonResponse
    {
        [$doctor, $role] = $this->context();

        $afterId = max(0, (int) $request->query('after_id', 0));

        $base = ClinicMessage::query()
            ->where('doctor_id', $doctor->id)
            ->where('recipient_role', $role)
            ->active();

        $messages = (clone $base)
            ->where('id', '>', $afterId)
            ->orderBy('id')
            ->limit(self::POLL_LIMIT)
            ->get()
            ->map(fn (ClinicMessage $m) => $this->payload($m))
            ->values();

        $activeIds = (clone $base)
            ->orderBy('id')
            ->limit(self::ACTIVE_IDS_LIMIT)
            ->pluck('id')
            ->values();

        return response()->json([
            'role' => $role,
            'now' => now()->toIso8601String(),
            'messages' => $messages,
            'active_ids' => $activeIds,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | الدكتور يستدعي مريض -> رسالة للمساعد
    |--------------------------------------------------------------------------
    */
    public function callPatient(Booking $booking): JsonResponse
    {
        return $this->createFromBooking(
            $booking,
            ClinicMessage::ROLE_DOCTOR,
            ClinicMessage::TYPE_DOCTOR_CALL,
            ClinicMessage::ROLE_ASSISTANT,
            'الطبيب يريد المريض الآن، يرجى التوجه به إلى الطبيب.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | المساعد يبلّغ إن المريض مش موجود -> رسالة للدكتور
    |--------------------------------------------------------------------------
    */
    public function patientMissing(Booking $booking): JsonResponse
    {
        return $this->createFromBooking(
            $booking,
            ClinicMessage::ROLE_ASSISTANT,
            ClinicMessage::TYPE_PATIENT_MISSING,
            ClinicMessage::ROLE_DOCTOR,
            'المريض غير موجود في العيادة حاليًا. يرجى العلم قبل استدعائه.'
        );
    }

    public function resolve(ClinicMessage $message): JsonResponse
    {
        $this->authorizeMessage($message);

        return $this->closeMessage($message, ClinicMessage::STATUS_RESOLVED);
    }

    public function destroy(ClinicMessage $message): JsonResponse
    {
        $this->authorizeMessage($message);

        return $this->closeMessage($message, ClinicMessage::STATUS_DELETED);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function createFromBooking(
        Booking $booking,
        string $requiredRole,
        string $type,
        string $recipientRole,
        string $text
    ): JsonResponse {
        [$doctor, $role] = $this->context();

        // الزرار بتاع الدكتور للدكتور بس، وبتاع المساعد للمساعد بس
        abort_unless($role === $requiredRole, 403);

        // الحجز لازم يكون تابع لنفس الدكتور
        abort_unless((int) $booking->doctor_id === (int) $doctor->id, 403);

        $userId = Auth::id();

        $result = DB::transaction(function () use ($booking, $doctor, $type, $recipientRole, $text, $userId) {

            // قفل الحجز: لو ضغطتين في نفس اللحظة، التانية بتستنى الأولى
            $fresh = Booking::query()
                ->whereKey($booking->id)
                ->lockForUpdate()
                ->first();

            if (
                !$fresh ||
                (int) $fresh->doctor_id !== (int) $doctor->id ||
                $fresh->status !== 'confirmed' ||
                !$fresh->arrived_at
            ) {
                return null;
            }

            $existing = ClinicMessage::query()
                ->where('doctor_id', $doctor->id)
                ->where('booking_id', $fresh->id)
                ->where('type', $type)
                ->active()
                ->first();

            if ($existing) {
                return [$existing, true];
            }

            $message = ClinicMessage::create([
                'doctor_id' => $doctor->id,
                'booking_id' => $fresh->id,
                'sender_user_id' => $userId,
                'recipient_role' => $recipientRole,
                'type' => $type,
                'status' => ClinicMessage::STATUS_ACTIVE,
                'patient_name' => $fresh->patient_name ?: 'مريض بدون اسم',
                'message' => $text,
            ]);

            // نفس اللي كان بيعمله زرار الاستدعاء القديم
            if ($type === ClinicMessage::TYPE_DOCTOR_CALL) {
                $fresh->update(['called_at' => now()]);
            }

            return [$message, false];
        });

        if (!$result) {
            return response()->json([
                'ok' => false,
                'message' => 'المريض لم يعد في طابور الانتظار.',
            ], 422);
        }

        [$message, $duplicate] = $result;

        return response()->json([
            'ok' => true,
            'duplicate' => $duplicate,
            'message' => $this->payload($message),
        ]);
    }

    private function closeMessage(ClinicMessage $message, string $status): JsonResponse
    {
        // update ذري: لو اتحلت قبل كده مش هيحصل حاجة (idempotent)
        ClinicMessage::query()
            ->whereKey($message->id)
            ->where('status', ClinicMessage::STATUS_ACTIVE)
            ->update([
                'status' => $status,
                'resolved_by_user_id' => Auth::id(),
                'resolved_at' => now(),
                'updated_at' => now(),
            ]);

        return response()->json(['ok' => true]);
    }

    /**
     * [الدكتور، الدور] — أو 403.
     * الرسائل متاحة بس لدكتور باشتراك Clinic System ومساعديه الفعّالين.
     */
    private function context(): array
    {
        $user = Auth::user();
        $doctor = $user?->clinicDoctor();

        abort_unless($doctor instanceof Doctor, 403);
        abort_unless($doctor->hasFeature('clinic_system'), 403);

        $role = ClinicMessage::roleFor($user, $doctor);

        abort_unless($role !== null, 403);

        return [$doctor, $role];
    }

    /**
     * الرسالة تخص الدكتور ده + موجهة لدوري أنا. مفيش اعتماد على booking_id.
     */
    private function authorizeMessage(ClinicMessage $message): void
    {
        [$doctor, $role] = $this->context();

        abort_unless(
            (int) $message->doctor_id === (int) $doctor->id &&
            $message->recipient_role === $role,
            403
        );
    }

    private function payload(ClinicMessage $m): array
    {
        return [
            'id' => $m->id,
            'type' => $m->type,
            'booking_id' => $m->booking_id,
            'patient_name' => $m->patient_name,
            'message' => $m->message,
            'sender_label' => $m->recipient_role === ClinicMessage::ROLE_ASSISTANT ? 'الطبيب' : 'المساعد',
            'created_at' => $m->created_at?->toIso8601String(),
        ];
    }
}