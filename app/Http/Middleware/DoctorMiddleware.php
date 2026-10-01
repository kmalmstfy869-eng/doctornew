<?php

namespace App\Http\Middleware;

use App\Models\Doctor;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class DoctorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role !== 'doctor' || ! $user->doctor) {
            abort(403);
        }

        if (!Doctor::active()->where('id', $user->doctor->id)->exists()) {
            Auth::logout();

            return redirect()->route('login')
                ->with('error', 'لم يتم قبول حسابك بعد.');
        }

        return $next($request);
    }
}
