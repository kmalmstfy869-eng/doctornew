<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ChangeEmailController extends Controller
{
    public function __invoke(Request $request, int $id, string $hash): RedirectResponse
    {
        $user = User::findOrFail($id);

        if (
            ! $user->hasValidPendingEmail()
            || ! hash_equals(sha1($user->pending_email), $hash)
        ) {
            return $this->redirectAfter($request)
                ->with('error', 'رابط التأكيد غير صالح أو انتهت صلاحيته، يرجى طلب تغيير البريد مرة أخرى.');
        }

        if (User::where('email', $user->pending_email)->where('id', '!=', $user->id)->exists()) {
            $user->clearPendingEmail();

            return $this->redirectAfter($request)
                ->with('error', 'هذا البريد مستخدم بالفعل.');
        }

        $user->confirmPendingEmail();

        return $this->redirectAfter($request)
            ->with('success', 'تم تأكيد البريد الإلكتروني الجديد وتحديثه بنجاح.');
    }

    private function redirectAfter(Request $request): RedirectResponse
    {
        $current = $request->user();

        if (! $current) {
            return redirect()->route('login');
        }

        $route = match ($current->role) {
            'doctor' => 'doctor.profile_doctor',
            'assistant' => 'clinic.dashboard',
            'admin' => 'admin.profile_admin',
            default => 'profile',
        };

        return redirect()->route($route);
    }
}
