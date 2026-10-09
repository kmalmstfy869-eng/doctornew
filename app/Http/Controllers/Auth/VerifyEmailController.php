<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return $this->redirectAfter($user)
                ->with('success', 'تم تأكيد بريدك الإلكتروني بالفعل.');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return $this->redirectAfter($user)
            ->with('success', 'تم تأكيد بريدك الإلكتروني بنجاح، أهلاً بك.');
    }

    private function redirectAfter(User $user): RedirectResponse
    {
        $route = match ($user->role) {
            'doctor' => 'doctor.dashboard',
            'assistant' => 'clinic.dashboard',
            'admin' => 'admin.profile_admin',
            default => 'home',
        };

        return redirect()->route($route);
    }
}
