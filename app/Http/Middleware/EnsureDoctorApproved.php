<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDoctorApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->doctor?->status !== 'approved') {
            return redirect()->route('doctor.dashboard')
                ->with('error', 'هذه الصفحة تتاح بعد قبول حسابك.');
        }

        return $next($request);
    }
}
