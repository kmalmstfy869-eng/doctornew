<?php

use App\Models\BlockedSlot;
use App\Models\ClinicMessage;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $cutoff = now('Africa/Cairo')->subDay()->format('Y-m-d');

    BlockedSlot::query()
        ->whereDate('date', '<', $cutoff)
        ->delete();
})->dailyAt('02:00')->timezone('Africa/Cairo');

Schedule::call(function () {
    User::expiredPendingEmail()->update([
        'pending_email' => null,
        'pending_email_requested_at' => null,
    ]);
})->everyFiveMinutes()
    ->name('cleanup-expired-pending-emails')
    ->withoutOverlapping();

/*
|--------------------------------------------------------------------------
| تنظيف رسائل العيادة (طبيب <-> مساعد)
|--------------------------------------------------------------------------
| بيمسح أي رسالة عدى عليها أكتر من يوم (active / resolved / deleted).
*/
Schedule::call(function () {
    ClinicMessage::query()
        ->where('created_at', '<', now()->subDay())
        ->delete();
})->dailyAt('03:00')
    ->timezone('Africa/Cairo')
    ->name('cleanup-old-clinic-messages')
    ->withoutOverlapping();


/*
|--------------------------------------------------------------------------
| النسخ الاحتياطي اليومي لملفات المرضى
|--------------------------------------------------------------------------
*/
// تشغيل النسخ الاحتياطي اليومي للملفات الجديدة أو المعدلة فقط.
Schedule::command('patient-files:backup')
    ->dailyAt('04:00')
    ->timezone('Africa/Cairo')
    ->name('backup-patient-files')
    ->withoutOverlapping();
// مزامنة يومية لعمود المساحة المتبقية.
Schedule::command('patient-files:sync-storage')->dailyAt('03:30')->timezone('Africa/Cairo')->name('sync-patient-files-storage');
