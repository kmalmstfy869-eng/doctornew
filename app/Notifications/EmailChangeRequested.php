<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class EmailChangeRequested extends Notification
{
    public function __construct(public string $newEmail) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $emailPanel = new HtmlString(
            '<table class="panel panel-warning" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border-right: 4px solid #e89b20; border-left: none; margin: 20px 0; width: 100%;">' .
            '<tr><td class="panel-content" style="background-color: #fff4dc; border: 1px solid #f6e0b5; border-right: none; border-radius: 6px 0 0 6px; padding: 16px 20px;">' .
            '<table width="100%" cellpadding="0" cellspacing="0" role="presentation">' .
            '<tr><td class="panel-item" align="center" style="text-align: center; padding: 0;">' .
            '<span dir="ltr" style="font-size: 16px; font-weight: bold; color: #172a3d; font-family: Tahoma, Arial, sans-serif;">' .
            e($this->newEmail) .
            '</span>' .
            '</td></tr></table>' .
            '</td></tr></table>'
        );

        return (new MailMessage)
            ->subject('تنبيه أمني: طلب تغيير البريد الإلكتروني')
            ->greeting('مرحباً بك،')
            ->line('نود إعلامك بأنه تم تقديم طلب لتغيير البريد الإلكتروني المرتبط بحسابك في ' . config('app.name') . ' إلى:')
            ->line($emailPanel)
            ->line('يرجى الاطمئنان، لن يتم اعتماد البريد الجديد أو إجراء أي تعديل على حسابك إلا بعد تأكيده عبر الرابط المرسل إلى العنوان الجديد.')
            ->line('إذا كنت أنت من قام بهذا الطلب، فلا داعي لاتخاذ أي إجراء.')
            ->line('أما إذا لم تكن قد طلبت هذا التغيير، فنوصيك بتسجيل الدخول إلى حسابك وتغيير كلمة المرور فوراً لضمان حماية بياناتك.')
            ->salutation('مع تحياتنا، فريق أمان ' . config('app.name'));
    }
}
