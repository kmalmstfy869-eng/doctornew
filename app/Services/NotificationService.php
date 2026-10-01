<?php

namespace App\Services;

use App\Models\Doctor;
use App\Notifications\DoctorWebPushNotification;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function send(
        Doctor $doctor,
        string $type,
        string $title,
        string $message,
        string $url
    ): void {

        $notification = $doctor->notifications()->create([
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'url' => $url,
            'is_read' => false,
        ]);

        try {

            $user = $doctor->user;

            if (!$user) {
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | لا يوجد أي جهاز Active
            |--------------------------------------------------------------------------
            */

            if (
                !$user->pushSubscriptions()
                    ->where('is_active', true)
                    ->exists()
            ) {
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | الإرسال
            |--------------------------------------------------------------------------
            */

            $user->notify(
                new DoctorWebPushNotification(
                    $title,
                    $message,
                    $url
                )
            );

        } catch (\Throwable $e) {

            Log::error(
                'Doctor push notification failed',
                [
                    'doctor_id' => $doctor->id,
                    'notification_id' => $notification->id,
                    'error' => $e->getMessage(),
                ]
            );
        }
    }
}
