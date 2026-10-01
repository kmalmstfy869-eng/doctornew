<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoadDoctor
{
    use AuthorizesRequests;

    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $doctor = $user->doctor()
            ->with([
                'subscription.plan',
                'subscription',
                'specialty',

            ])
            ->firstOrFail();

        $notificationsheader = $doctor->notifications()
            ->where('is_read',false)
            ->count();

        $this->authorize('access', $doctor);

        view()->share('doctor', $doctor);
        view()->share('doctor_name', $user->name ?? 'الطبيب');
        view()->share('notificationsheader', $notificationsheader ?? '0');

        return $next($request);
    }
}
