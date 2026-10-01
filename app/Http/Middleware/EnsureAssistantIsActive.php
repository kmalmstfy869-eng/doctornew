<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAssistantIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // لو المستخدم مساعد فقط، نتأكد أن حسابه نشط
        if ($user->doctorAssistant && ! $user->doctorAssistant->is_active) {

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with('error', 'تم إيقاف حسابك من قِبل الطبيب.');
        }

        // طبيب أو أي مستخدم ليس مساعدًا → يكمل عادي
        return $next($request);
    }
}
