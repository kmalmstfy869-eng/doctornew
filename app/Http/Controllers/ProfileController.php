<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Notifications\EmailChangeRequested;
use App\Notifications\VerifyNewEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;


class ProfileController extends Controller
{


    /**
     * Update the user's profile information.
     */
public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();
    $user->name = $request->validated('name');

    $newEmail = $request->validated('email');
    $emailChanged = $newEmail !== $user->email;

    if (! $emailChanged) {
        $user->save();

        return back()->with('success', 'تم تعديل الاسم.');
    }

    $user->save();
    $user->requestEmailChange($newEmail);

    try {
        Notification::route('mail', $newEmail)->notify(new VerifyNewEmail($user));
    } catch (\Throwable $e) {
        report($e);
        $user->clearPendingEmail();


        return back()
            ->with('error', 'يوجد مشكلة مؤقتة أثناء إرسال رابط التأكيد. إذا استمرت، يرجى إخبارنا لحلها.');

    }

    rescue(fn () => $user->notify(new EmailChangeRequested($newEmail)));

    return back()->with('success', 'تم إرسال رابط تأكيد إلى بريدك الجديد، وسيتغير بريدك بعد الضغط عليه.');
}
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ], [
            'password.required' => 'من فضلك أدخل كلمة المرور.',
            'password.current_password' => 'كلمة المرور غير صحيحة.',
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with("success","تم حذف حسابك نهائيا من الموقع");
    }}
