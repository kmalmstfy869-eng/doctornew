<?php

use App\Models\BlockedSlot;
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
