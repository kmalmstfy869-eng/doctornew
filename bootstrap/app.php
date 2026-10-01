<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use App\Http\Middleware\admin;
use App\Http\Middleware\DoctorBookingOrAssistant;
use App\Http\Middleware\DoctorClinicSystemOrAssistant;
use App\Http\Middleware\DoctorMiddleware;
use App\Http\Middleware\EnsureAssistantIsActive;
use App\Http\Middleware\LoadDoctor;
use App\Http\Middleware\Redirect_Assistant;
use App\Http\Middleware\RedirectAdmin;
use App\Http\Middleware\RedirectDoctor;
use App\Http\Middleware\RequireVerifiedEmail;
use App\Http\Middleware\SubscriptionMiddleware;
use App\Models\DoctorAssistant;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->alias([

            'is_admin' => admin::class,
            'redirect_admin'=>RedirectAdmin::class,
            'redirect_doctor'=>RedirectDoctor::class,
            'doctor'=>DoctorMiddleware::class,
            'load_doctor'=>LoadDoctor::class,
            'subscription'=>SubscriptionMiddleware::class,
            'assistant'=>DoctorAssistant::class,
            'redirect_assistant'=>Redirect_Assistant::class,
            'doctorbookingorassistant'=>DoctorBookingOrAssistant::class,
            'doctorclinicsystemorassistant'=>DoctorClinicSystemOrAssistant::class,
            'assistant_isactive'=>EnsureAssistantIsActive::class,
            'loginverified'=>RequireVerifiedEmail::class,

        ]);

})

    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) =>
                $request->is('api/*') || $request->expectsJson(),
        );

    })

    ->create();
