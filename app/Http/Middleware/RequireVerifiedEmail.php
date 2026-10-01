<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RequireVerifiedEmail
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (
            $user instanceof MustVerifyEmail
            && $user->role === 'user'
            && ! $user->hasVerifiedEmail()
            && ! $request->routeIs('verification.*', 'logout', 'email.change.verify')
        ) {
            if ($request->expectsJson()) {
                abort(403, 'يجب تأكيد البريد الإلكتروني أولاً.');
            }

            $redirect = redirect()->route('verification.notice');

            if (Cache::add('verification-link-sent:' . $user->id, true, now()->addMinutes(5))) {
                rescue(fn () => $user->sendEmailVerificationNotification());

                $redirect->with('status', 'verification-link-sent');
            }

            return $redirect;
        }

        return $next($request);
    }
}
