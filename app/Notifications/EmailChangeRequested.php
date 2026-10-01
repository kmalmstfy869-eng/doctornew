<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailChangeRequested extends Notification
{
    public function __construct(public string $newEmail) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('مرحباً،')
            ->salutation('مع تحياتنا، ' . config('app.name'))
            ->subject('طلب تغيير البريد الإلكتروني')
            ->line('تم طلب تغيير بريد حسابك إلى: ' . $this->newEmail)
            ->line('لن يتغير البريد إلا بعد تأكيده من البريد الجديد.')
            ->line('إذا لم تكن أنت، غيّر كلمة المرور فوراً.');
    }
}
