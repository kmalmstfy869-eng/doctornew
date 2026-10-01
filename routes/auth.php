<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ChangeEmailController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\DoctorJoinController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\User\JobsController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'guest',
    'redirect_admin',
    'redirect_doctor',
    'redirect_assistant',
])->group(function () {

    Route::get('/join_as_doctor', [DoctorJoinController::class, 'create'])
        ->name('doctor_join');

    Route::post('/join_as_doctor', [DoctorJoinController::class, 'store'])
        ->name('doctor_join.store')
        ->middleware('throttle:book');

    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});


/*
|--------------------------------------------------------------------------
| Change Email Confirmation
|--------------------------------------------------------------------------
| برا مجموعة auth: الرابط موقّع ومرتبط بالإيميل الجديد، فيشتغل
| حتى لو الفاتح حساب تاني أو مش مسجل دخول.
*/

Route::get('email/change/{id}/{hash}', ChangeEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('email.change.verify');


/*
|--------------------------------------------------------------------------
| Email Verification
|--------------------------------------------------------------------------
| ممنوع 'verified' وممنوع redirect_* هنا (كل الأدوار لازم توصل لصفحة التأكيد)
*/

Route::middleware(['auth'])->group(function () {

    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post(
        'email/verification-notification',
        [EmailVerificationNotificationController::class, 'store']
    )
        ->middleware('throttle:verification-email')
        ->name('verification.send');
});


/*
|--------------------------------------------------------------------------
| Password & Account Security
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'redirect_admin',
    'redirect_doctor',
    'redirect_assistant',
])->group(function () {

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])
        ->name('password.update');
});


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');
