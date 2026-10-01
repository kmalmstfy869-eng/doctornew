<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string $feature
    ): Response {

        $doctor = $request->user()?->doctor;

        if (!$doctor) {
            abort(403);
        }

        if (!$doctor->hasFeature($feature)) {
            return redirect()
                ->route('doctor.dashboard')
                ->with('error', 'الميزة غير متاحة في باقتك الحالية.');
        }

        return $next($request);
    }
}

