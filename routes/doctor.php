<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Doctor\PushSubscriptionController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\Doctor\DoctorProfileController;
use App\Http\Controllers\Doctor\DoctorReviewsController;
use App\Http\Controllers\Doctor\NotificationController;
use App\Http\Controllers\Doctor\SubscriptionController;
use App\Http\Controllers\Doctor\DoctorStatsController;

Route::middleware(['auth', 'verified', 'doctor', 'load_doctor','redirect_admin','redirect_assistant'])
    ->prefix('doctor')
    ->name('doctor.')
    ->group(function () {

        Route::get('/setting', [DoctorDashboardController::class, 'profiledoctor'])
            ->name('profile_doctor');

        Route::get('/dashboard', [DoctorDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/profile', [DoctorProfileController::class, 'show'])
            ->name('profile.show');

        Route::get('/profile/edit', [DoctorProfileController::class, 'edit'])
            ->name('profile.edit');


        Route::put('/profile', [DoctorProfileController::class, 'update'])
            ->name('profile.update');


        Route::get('/notifications', [NotificationController::class, 'index'])
            ->name('notifications.index');

        Route::get('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
            ->name('notifications.read');

        Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])
            ->name('notifications.destroy');

        Route::delete('/notifications', [NotificationController::class, 'destroyAll'])
            ->name('notifications.destroyAll');


        Route::get('/reviews', [DoctorReviewsController::class, 'index'])
            ->middleware(['subscription:subscription','doctor_approved'])
            ->name('reviews');


        /*
        |--------------------------------------------------------------------------
        | PUSH SUBSCRIPTIONS
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/push-subscription/status',
            [PushSubscriptionController::class, 'status']
        )->name('push-subscription.status');

        Route::post(
            '/push-subscription',
            [PushSubscriptionController::class, 'store']
        )->name('push-subscription.store');

        Route::post(
            '/push-subscription/disable',
            [PushSubscriptionController::class, 'disable']
        )->name('push-subscription.disable');

        Route::get('/clinic/help', function () {
            return view('doctor.dashboard.help.index');
        })->name('help');

        Route::get('/subscription', [SubscriptionController::class, 'index'])
                ->middleware('doctor_approved')
                ->name('subscription');

        Route::get('/stats', [DoctorStatsController::class, 'index'])
            ->middleware('doctor_approved')
            ->name('stats');
    });
