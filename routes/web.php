<?php

use App\Http\Controllers\Admin\RatingsController;
use App\Http\Controllers\Clinic\BookingController;
use App\Models\Specialties;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\SpecialtyController;
use App\Http\Controllers\User\DoctorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\JobsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clinic\OnlineBookingController;
use App\Http\Controllers\User\ContactMessageController;
use App\Http\Controllers\User\FavoriteController;

/*
|--------------------------------------------------------------------------
| Profile (بدون loginverified عمدًا: غير المتأكد يقدر يصحح بريده من هنا)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [HomeController::class, 'profileuser'])
        ->name('profile')
        ->middleware(['redirect_admin', 'redirect_assistant']);

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update')
        ->middleware(['redirect_assistant', 'throttle:email-change']);

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy')
        ->middleware('redirect_assistant');
});



    Route::get('/jobs/create', [JobsController::class, 'create'])
        ->name('jobs.create');

    Route::post('/jobs', [JobsController::class, 'store'])
        ->name('job.store')
        ->middleware(['throttle:jobs','auth']);
/*


|--------------------------------------------------------------------------
| Public pages
| loginverified: المسجل دخول وغير المتأكد يتحول لصفحة التأكيد،
| والزائر غير المسجل يتصفح عادي.
|--------------------------------------------------------------------------
*/
Route::middleware([
    'loginverified',
    'redirect_admin',
    'redirect_doctor',
    'redirect_assistant',
])->group(function () {

    Route::post('/doctors/{doctor}/favorite', [FavoriteController::class, 'toggle'])
        ->name('favorites.toggle');

    Route::get('/', [HomeController::class, 'index'])
        ->name('home');

    Route::get('/about-me', function () {
        return view('home.info.about');
    })->name('about');

    Route::resource('specialties', SpecialtyController::class);

    Route::resource('doctors', DoctorController::class);

    Route::resource('jobs', JobsController::class)->except(['create', 'store']);

    Route::post(
        '/doctors/{doctor}/book',
        [OnlineBookingController::class, 'store']
    )->name('onlinebooking.store')->middleware('throttle:book');

    Route::get(
        '/contact',
        [ContactMessageController::class, 'index']
    )->name('contact.index');

    Route::post(
        '/contact',
        [ContactMessageController::class, 'store']
    )->name('contact.store')->middleware('throttle:book');

    Route::get('/faq', function () {
        return view('home.info.faq');
    })->name('faq');

    Route::post('ratings', [RatingsController::class, 'store'])->name('ratings.store');
});


require __DIR__.'/admin.php';
require __DIR__.'/doctor.php';
require __DIR__.'/auth.php';
require __DIR__.'/clinic.php';
