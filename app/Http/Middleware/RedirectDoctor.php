<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectDoctor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (
            Auth::check() &&
            Auth::user()->role === 'doctor' &&
            Auth::user()->doctor
        ) {
            return redirect()->route('doctor.dashboard');
        }

        return $next($request);
    }
}
