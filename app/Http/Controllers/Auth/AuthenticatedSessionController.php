<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Doctor;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

       /** @var \App\Models\User $user */
            $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'assistant' && $user?->doctorAssistant?->is_active == 1) {
            return redirect()->intended(route('clinic.dashboard'));
        }

        if ($user->role === 'assistant' && $user?->doctorAssistant?->is_active == 0) {
            Auth::logout();

            return redirect()->route('login')
                ->with('error', 'الدكتور أوقف حسابك');
        }

    if ($user->role === 'doctor') {

        $doctor = $user->doctor;

        if (! $doctor) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'لا يوجد حساب طبيب مرتبط بهذا الحساب.');
        }

        if ($doctor->status === 'rejected') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'تم رفض حسابك.');
        }

        if (! in_array($doctor->status, ['approved', 'pending'], true)) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'حالة حسابك غير معروفة، يرجى التواصل مع الإدارة.');
        }

        if (! $user->hasVerifiedEmail()) {
            rescue(fn () => $user->sendEmailVerificationNotification());
            return redirect()->route('verification.notice');
        }

        return redirect()->intended(route('doctor.dashboard', absolute: false));
    }

        return redirect()->intended(
            route('home', absolute: false)
        );
    }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with(
            'success',
            "تم تسجيل الخروج بنجاح. نتمنى رؤيتك مرة أخرى."
        );
    }
}
