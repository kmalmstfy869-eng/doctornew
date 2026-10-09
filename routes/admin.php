<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDoctorCreateController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\ExtraStorageController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\JobsController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PatientRestoreController;
use App\Http\Controllers\Admin\PatientStorageController;
use App\Http\Controllers\Admin\PendingDoctorController;
use App\Http\Controllers\Admin\RatingsController;
use App\Http\Controllers\Admin\RejectedDoctorsController;
use App\Http\Controllers\Admin\SiteStatsController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Admin\subscribedDoctorController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\UnsubscribedDoctorController;
use App\Http\Controllers\Admin\userController;
use App\Http\Controllers\User\ContactMessageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'is_admin', 'redirect_doctor', 'redirect_assistant'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('stats', [SiteStatsController::class, 'index'])->name('stats');

        /*
        |--------------------------------------------------------------------------
        | 1) الرئيسية والإعدادات
        |--------------------------------------------------------------------------
        */
        Route::get('/', [AdminDashboardController::class, 'index']);
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [AdminDashboardController::class, 'profileadmin'])->name('profile_admin');

        /*
        |--------------------------------------------------------------------------
        | 2) الأطباء (الترتيب هنا زي ما كان بالظبط)
        |--------------------------------------------------------------------------
        */
        Route::resource('unsubscribed_doctors', UnsubscribedDoctorController::class);
        Route::resource('subscribed_doctors', subscribedDoctorController::class);
        Route::resource('pending_doctors', PendingDoctorController::class);
        Route::resource('rejected_doctors', RejectedDoctorsController::class);
        Route::resource('doctor', DoctorController::class);

        Route::post('/doctors/{doctor}/subscribe', [DoctorController::class, 'subscribe'])->name('doctor.subscribe');
        Route::post('/doctors/{doctor}/cancelSubscription', [DoctorController::class, 'cancelSubscription'])->name('doctor.cancelSubscription');
        Route::post('/doctors/{doctor}/deleteImage', [DoctorController::class, 'deleteImage'])->name('doctor.deleteImage');

        Route::post('/doctor_pending/{doctor}/approve', [PendingDoctorController::class, 'approveForListing'])->name('doctor_pending.approve');
        Route::post('/doctor_pending/{doctor}/reject-listing', [PendingDoctorController::class, 'rejectForListing'])->name('doctor_pending.reject');
        Route::post('/doctors_pending/approve_all', [PendingDoctorController::class, 'approve_all'])->name('doctors_pending.approve_all');

        Route::post('/rejected_doctor/{doctor}/restore', [RejectedDoctorsController::class, 'restore'])->name('rejected_doctor.restore');

        Route::get('/doctor/create', [AdminDoctorCreateController::class, 'index'])->name('doctor.create');
        Route::post('/doctor', [AdminDoctorCreateController::class, 'store'])->name('doctor.store');

        /*
        |--------------------------------------------------------------------------
        | 3) الاشتراكات والمالية
        |--------------------------------------------------------------------------
        */
        Route::prefix('subscriptions')->name('subscriptions.')->group(function () {
            Route::get('/', [SubscriptionController::class, 'index'])->name('index');
            Route::get('/doctors', [SubscriptionController::class, 'searchDoctors'])->name('doctors');
            Route::post('/', [SubscriptionController::class, 'store'])->name('store');
            Route::post('/{subscription}/change', [SubscriptionController::class, 'change'])->whereNumber('subscription')->name('change');
            Route::post('/{subscription}/renew', [SubscriptionController::class, 'renew'])->whereNumber('subscription')->name('renew');
        });

        Route::prefix('finance')->name('finance.')->group(function () {
            Route::get('/', [FinanceController::class, 'index'])->name('index');
            Route::post('/', [FinanceController::class, 'store'])->name('store');
            Route::delete('/{entry}', [FinanceController::class, 'destroy'])->whereNumber('entry')->name('destroy');
        });

        /*
        |--------------------------------------------------------------------------
        | 4) ملفات المرضى والتخزين
        |--------------------------------------------------------------------------
        */
        Route::prefix('storage')->name('storage.')->group(function () {
            Route::get('/', [PatientStorageController::class, 'overview'])->name('overview');
            Route::get('/files', [PatientStorageController::class, 'files'])->name('files');

            Route::get('/runs', [PatientStorageController::class, 'runs'])->name('runs');
            Route::post('/runs', [PatientStorageController::class, 'runNow'])->middleware('throttle:3,1')->name('runs.run');

            // مساحات الأطباء: عرض ومتابعة فقط (التعديل بقى من اشتراكات المساحة)
            Route::get('/quotas', [PatientStorageController::class, 'quotas'])->name('quotas');

            // اشتراكات المساحة الإضافية
            Route::prefix('extra')->name('extra.')->group(function () {
                Route::get('/', [ExtraStorageController::class, 'index'])->name('index');
                Route::get('/doctors', [ExtraStorageController::class, 'searchDoctors'])->name('doctors');
                Route::post('/', [ExtraStorageController::class, 'store'])->name('store');
                Route::post('/{extra}/change', [ExtraStorageController::class, 'change'])->whereNumber('extra')->name('change');
                Route::post('/{extra}/renew', [ExtraStorageController::class, 'renew'])->whereNumber('extra')->name('renew');
            });

            Route::get('/restore', [PatientRestoreController::class, 'index'])->name('restore');
            Route::post('/restore/preview', [PatientRestoreController::class, 'preview'])->middleware('throttle:6,1')->name('restore.preview');
            Route::post('/restore/all', [PatientRestoreController::class, 'restoreAll'])->middleware('throttle:3,1')->name('restore.all');
            Route::post('/restore/{backup}', [PatientRestoreController::class, 'restoreOne'])->whereNumber('backup')->middleware('throttle:20,1')->name('restore.one');
        });

        /*
        |--------------------------------------------------------------------------
        | 5) المحتوى: التخصصات والمناطق والوظائف
        |--------------------------------------------------------------------------
        */
        Route::resource('specialties', SpecialtyController::class);
        Route::resource('areas', AreaController::class);

        Route::resource('jobs', JobsController::class)->only(['index', 'show', 'destroy']);
        Route::patch('/jobs/{job}/approve', [JobsController::class, 'approve'])->name('jobs.approve');
        Route::patch('/jobs/{job}/reject', [JobsController::class, 'reject'])->name('jobs.reject');

        /*
        |--------------------------------------------------------------------------
        | 6) المستخدمون والتواصل
        |--------------------------------------------------------------------------
        */
        Route::get('/users', [userController::class, 'index'])->name('users');
        Route::get('/user/jobs/{user}', [userController::class, 'jobs'])->name('user.jobs');
        Route::delete('/users/{user}', [userController::class, 'destroy'])->name('users.destroy');

        Route::get('/notifications', [NotificationController::class, 'create'])->name('notifications');
        Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');

        Route::get('/contact', [ContactMessageController::class, 'messages'])->name('contact');
        Route::delete('/contact/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact.destroy');

        Route::resource('ratings', RatingsController::class)
            ->only(['index', 'edit', 'update', 'destroy']);
    });

// برا الجروبات
Route::get('/ratings', fn () => redirect()->route('admin.ratings.index'));
