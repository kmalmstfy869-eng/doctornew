<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class VerifyNewEmail extends Notification
{
    public function __construct(public User $user) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = URL::temporarySignedRoute(
            'email.change.verify',
            now()->addMinutes(60),
            [
                'id' => $this->user->id,
                'hash' => sha1($this->user->pending_email),
            ]
        );

        return (new MailMessage)
            ->greeting('مرحباً،')
            ->salutation('مع تحياتنا، ' . config('app.name'))
            ->subject('تأكيد البريد الإلكتروني الجديد')
            ->line('اضغط على الزر لتأكيد أن هذا البريد هو بريدك الجديد.')
            ->action('تأكيد البريد الجديد', $url)
            ->line('إذا لم تطلب هذا التغيير، تجاهل الرسالة.');
    }
}
