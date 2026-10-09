<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class DoctorBookingOrAssistant
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        /** @var User $user */
        $user = Auth::user();

        if (! $user->can('use-booking-feature')) {
            return redirect()->back()->with(
                'error',
                'هذه الميزة غير متاحة ضمن اشتراك العيادة الحالي، أو ليس لديك صلاحية للوصول إليها.'
            );
        }

        return $next($request);
    }
}
