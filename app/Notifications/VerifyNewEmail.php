<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HtmlString;

class VerifyNewEmail extends Notification
{
    public function __construct(public User $user) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        if (blank($this->user->pending_email)) {
            throw new \LogicException('VerifyNewEmail requires a pending_email.');
        }

        $ttl = User::PENDING_EMAIL_TTL_MINUTES;

        $url = URL::temporarySignedRoute(
            'email.change.verify',
            now()->addMinutes($ttl),
            [
                'id' => $this->user->id,
                'hash' => sha1($this->user->pending_email),
            ]
        );

        $emailPanel = new HtmlString(
            '<table class="panel" width="100%" cellpadding="0" cellspacing="0" role="presentation">' .
            '<tr><td class="panel-content">' .
            '<table width="100%" cellpadding="0" cellspacing="0" role="presentation">' .
            '<tr><td class="panel-item" align="center" style="text-align: center;">' .
            '<span dir="ltr" style="font-size: 16px; font-weight: bold; color: #1769d1; font-family: Tahoma, Arial, sans-serif;">' .
            e($this->user->pending_email) .
            '</span>' .
            '</td></tr></table>' .
            '</td></tr></table>'
        );

        return (new MailMessage)
            ->subject('تأكيد البريد الإلكتروني الجديد')
            ->greeting('مرحباً بك،')
            ->line('لقد تلقينا طلباً لتعيين هذا العنوان كبريد إلكتروني جديد لحسابك في ' . config('app.name') . ':')
            ->line($emailPanel)
            ->line('لتأكيد هذا العنوان وتفعيله، يُرجى الضغط على الزر أدناه:')
            ->action('تأكيد البريد الجديد', $url)
            ->line("يرجى العلم أن هذا الرابط صالح لمدة {$ttl} دقيقة فقط.")
            ->line('إذا لم تكن قد طلبت هذا التغيير، يمكنك تجاهل هذه الرسالة بأمان دون أي إجراء.')
            ->salutation('مع تحياتنا، فريق ' . config('app.name'));
    }
}
