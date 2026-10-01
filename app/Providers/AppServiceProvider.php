<?php

namespace App\Providers;

use App\Models\Area;
use App\Models\Rating;
use App\Models\Specialties;
use App\Observers\RatingObserver;
use Carbon\Carbon;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Rating::observe(RatingObserver::class);

        View::composer('home.doctors.doctors', function ($view) {

            $specialties = Specialties::select(
                'id',
                'name'
            )->get();

            $areas = Area::select(
                'id',
                'name'
            )->get();

            $view->with([
                'specialties' => $specialties,
                'areas' => $areas,
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | لغة Carbon
        |--------------------------------------------------------------------------
        */

        Carbon::setLocale('ar');

        /*
        |--------------------------------------------------------------------------
        | Rate Limiter - الحجوزات
        |--------------------------------------------------------------------------
        |
        | 5 محاولات خلال 15 دقيقة.
        |
        */

        RateLimiter::for('book', function (Request $request) {

            return Limit::perMinutes(
                15,
                4
            )->by(
                $request->user()->id ?? $request->ip()
            );
        });


        RateLimiter::for('jobs', function (Request $request) {

            return Limit::perMinutes(
                30,
                6
            )->by(
                $request->user()->id ?? $request->ip()
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Rate Limiter - إعادة إرسال رابط تأكيد الحساب
        |--------------------------------------------------------------------------
        |
        | مرة في الدقيقة، و5 مرات في الساعة.
        |
        */

        RateLimiter::for('verification-email', function (Request $request) {

            $key = $request->user()?->id ?: $request->ip();

            return [
                Limit::perMinute(1)->by('min:' . $key),
                Limit::perHour(5)->by('hour:' . $key),
            ];
        });

        /*
        |--------------------------------------------------------------------------
        | Rate Limiter - طلبات تغيير البريد الإلكتروني
        |--------------------------------------------------------------------------
        |
        | 5 طلبات في الساعة، ولا يُحسب الحفظ لو البريد لم يتغير.
        |
        */

        RateLimiter::for('email-change', function (Request $request) {

            $user = $request->user();

            if (
                $user
                && mb_strtolower(trim((string) $request->input('email'))) === mb_strtolower($user->email)
            ) {
                return Limit::none();
            }

            return Limit::perHour(5)->by($user?->id ?: $request->ip());
        });

        /*
        |--------------------------------------------------------------------------
        | Rate Limit Response
        |--------------------------------------------------------------------------
        */

        app('Illuminate\Contracts\Debug\ExceptionHandler')
            ->renderable(function (
                TooManyRequestsHttpException $e,
                Request $request
            ) {

                if (
                    $request->routeIs('onlinebooking.store') ||
                    $request->routeIs('job.store') ||
                    $request->routeIs('contact.store') ||
                    $request->routeIs('doctor_join.store')
                ) {

                    return redirect()
                        ->back()
                        ->withInput()
                        ->with(
                            'error',
                            'لقد تجاوزت عدد المحاولات المسموح بها. برجاء المحاولة بعد قليل.'
                        );
                }

                if ($request->routeIs('verification.send')) {

                    return redirect()
                        ->back()
                        ->with(
                            'error',
                            'لقد طلبت إرسال رابط التأكيد أكثر من مرة. برجاء الانتظار قليلًا ثم المحاولة مرة أخرى.'
                        );
                }

                if (
                    $request->routeIs('profile.update') ||
                    $request->routeIs('clinic.assistants.update')
                ) {

                    return redirect()
                        ->back()
                        ->withInput()
                        ->with(
                            'error',
                            'لقد تجاوزت عدد طلبات تغيير البريد الإلكتروني المسموح بها. برجاء المحاولة بعد ساعة.'
                        );
                }

                return null;
            });

        Gate::define('use-booking-feature', function ($user) {
            $doctor = $user->clinicDoctor();

            return $doctor
                && $doctor->status === 'approved'
                && $doctor->hasFeature('booking')
                && (! $user->doctorAssistant || $user->doctorAssistant->is_active);
        });

        Gate::define('use-clinic-system', function ($user) {
            $doctor = $user->clinicDoctor();

            return $doctor
                && $doctor->status === 'approved'
                && $doctor->hasFeature('clinic_system')
                && (! $user->doctorAssistant || $user->doctorAssistant->is_active);
        });
    }
}
