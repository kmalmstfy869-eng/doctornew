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
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role !== 'doctor' || ! $user->doctor) {
            abort(403);
        }

        $status = $user->doctor->status;

        if (! in_array($status, ['approved', 'pending'], true)) {
            Auth::logout();

            return redirect()->route('login')
                ->with('error', $status === 'rejected' ? 'تم رفض حسابك.' : 'حالة حسابك غير معروفة.');
        }


        return $next($request);
    }
}
