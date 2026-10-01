<?php

use App\Http\Controllers\Admin\JobsController;
use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDoctorCreateController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\PendingDoctorController;
use App\Http\Controllers\Admin\subscribedDoctorController;
use App\Http\Controllers\Admin\UnsubscribedDoctorController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\RejectedDoctorsController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Admin\RatingsController;
use App\Http\Controllers\Admin\userController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\User\ContactMessageController;

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'is_admin', 'redirect_doctor','redirect_assistant'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get(
            '/profile',
            [AdminDashboardController::class, 'profileadmin']
        )->name('profile_admin');


        Route::get(
            '/',
            [AdminDashboardController::class, 'index']
        );


        Route::get(
            '/dashboard',
            [AdminDashboardController::class, 'index']
        )->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Jobs
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'jobs',
            JobsController::class
        )->only([
            'index',
            'show',
            'destroy'
        ]);


        Route::PATCH(
            '/jobs/{job}/approve',
            [JobsController::class, 'approve']
        )->name('jobs.approve');


        Route::PATCH(
            '/jobs/{job}/reject',
            [JobsController::class, 'reject']
        )->name('jobs.reject');


        /*
        |--------------------------------------------------------------------------
        | Doctors
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'unsubscribed_doctors',
            UnsubscribedDoctorController::class
        );


        Route::resource(
            'subscribed_doctors',
            subscribedDoctorController::class
        );


        Route::resource(
            'pending_doctors',
            PendingDoctorController::class
        );


        Route::resource(
            'rejected_doctors',
            RejectedDoctorsController::class
        );


        Route::resource(
            'doctor',
            DoctorController::class
        );


        Route::resource(
            'specialties',
            SpecialtyController::class
        );


        Route::resource(
            'areas',
            AreaController::class
        );


        /*
        |--------------------------------------------------------------------------
        | Doctor Subscription
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/doctors/{doctor}/subscribe',
            [DoctorController::class, 'subscribe']
        )->name('doctor.subscribe');


        Route::post(
            '/doctors/{doctor}/cancelSubscription',
            [DoctorController::class, 'cancelSubscription']
        )->name('doctor.cancelSubscription');


        Route::post(
            '/doctors/{doctor}/deleteImage',
            [DoctorController::class, 'deleteImage']
        )->name('doctor.deleteImage');


        /*
        |--------------------------------------------------------------------------
        | Pending Doctors
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/doctor_pending/{doctor}/approve',
            [PendingDoctorController::class, 'approveForListing']
        )->name('doctor_pending.approve');


        Route::post(
            '/doctor_pending/{doctor}/reject-listing',
            [PendingDoctorController::class, 'rejectForListing']
        )->name('doctor_pending.reject');


        Route::post(
            '/doctors_pending/approve_all',
            [PendingDoctorController::class, 'approve_all']
        )->name('doctors_pending.approve_all');


        /*
        |--------------------------------------------------------------------------
        | Rejected Doctors
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/rejected_doctor/{doctor}/restore',
            [RejectedDoctorsController::class, 'restore']
        )->name('rejected_doctor.restore');


        /*
        |--------------------------------------------------------------------------
        | Doctor Create
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/doctor/create',
            [AdminDoctorCreateController::class, 'index']
        )->name('doctor.create');


        Route::post(
            '/doctor',
            [AdminDoctorCreateController::class, 'store']
        )->name('doctor.store');


        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/users',
            [userController::class, 'index']
        )->name('users');


        Route::get(
            '/user/jobs/{user}',
            [userController::class, 'jobs']
        )->name('user.jobs');


        Route::delete(
            '/users/{user}',
            [userController::class, 'destroy']
        )->name('users.destroy');


        /*
        |--------------------------------------------------------------------------
        | Notifications
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/notifications',
            [NotificationController::class, 'create']
        )->name('notifications');


        Route::post(
            '/notifications',
            [NotificationController::class, 'store']
        )->name('notifications.store');

        Route::get('/contact', [ContactMessageController::class, 'messages'])
            ->name('contact');

        Route::delete('/contact/{contactMessage}', [ContactMessageController::class, 'destroy'])
            ->name('contact.destroy');

    });


/*
|--------------------------------------------------------------------------
| Ratings
|--------------------------------------------------------------------------
*/

Route::resource(
    'ratings',
    RatingsController::class
)->middleware(['redirect_assistant','redirect_doctor']);
