<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DoctorClinicSystemOrAssistant
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

    if (! Auth::user()->can('use-clinic-system')) {
        return redirect()->back()->with(
            'error',
            'هذه الميزة غير متاحة ضمن اشتراك العيادة الحالي، أو ليس لديك صلاحية للوصول إليها.'
        );
    }

        return $next($request);
    }
}
