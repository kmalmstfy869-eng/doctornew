<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreAssistantRequest;
use App\Http\Requests\Doctor\UpdateAssistantRequest;
use App\Models\DoctorAssistant;
use App\Models\User;
use App\Notifications\EmailChangeRequested;
use App\Notifications\VerifyNewEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class DoctorAssistantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $doctor = $user->clinicDoctor();

        $assistants = $doctor->assistants()
            ->with('user')
            ->latest()
            ->get();

        $active_assistants = $doctor->assistants()->where('is_active', true)->count();

        return view('doctor.clinic.assistants.index', compact('assistants', 'active_assistants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssistantRequest $request)
    {
        $doctor = Auth::user()->clinicDoctor();

        if ($doctor->assistants()->count() >= 5) {
            return back()
                ->withInput()
                ->withErrors([
                    'name' => 'وصلت للحد الأقصى المسموح به وهو 5 مساعدين، لا يمكن إضافة مساعد جديد.',
                ], 'assistantAdd');
        }

        $user = DB::transaction(function () use ($request, $doctor) {

            $user = User::create([
                'name' => $request->validated('name'),
                'email' => $request->validated('email'),
                'password' => Hash::make($request->validated('password')),
                'role' => 'assistant',
            ]);

            $doctor->assistants()->create([
                'user_id' => $user->id,
                'phone' => $request->validated('phone'),
                'is_active' => true,
            ]);

            return $user;
        });

        rescue(fn () => $user->sendEmailVerificationNotification());

        return redirect()
            ->route('clinic.assistants.index')
            ->with('success', 'تم إضافة المساعد بنجاح، وتم إرسال رابط تأكيد البريد إليه.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssistantRequest $request, DoctorAssistant $assistant)
    {
        $doctor = Auth::user()->clinicDoctor();

        abort_unless($assistant->doctor_id === $doctor->id, 403);

        $user = $assistant->user;

        $newEmail = mb_strtolower(trim((string) $request->validated('email')));
        $emailChanged = $newEmail !== mb_strtolower($user->email);

        if ($emailChanged && $this->emailIsTaken($newEmail, $user->id)) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'البريد الإلكتروني مستخدم بالفعل.']);
        }

        DB::transaction(function () use ($request, $assistant, $user) {

            $user->name = $request->validated('name');

            if ($request->filled('password')) {
                $user->password = Hash::make($request->validated('password'));
            }

            $user->save();

            $assistant->update([
                'phone' => $request->validated('phone'),
                'is_active' => $request->validated('status') === 'active',
            ]);
        });

        if (! $emailChanged) {
            return redirect()
                ->route('clinic.assistants.index')
                ->with('success', 'تم تعديل بيانات المساعد بنجاح.');
        }

        $user->requestEmailChange($newEmail);

        try {
            Notification::route('mail', $newEmail)->notify(new VerifyNewEmail($user));
        } catch (\Throwable $e) {
            report($e);
            $user->clearPendingEmail();

            return redirect()
                ->route('clinic.assistants.index')
                ->with('error', ' تعذر إرسال رابط التأكيد إلى البريد الجديد، ولم يتم تغيير البريد. حاول مرة أخرى او اخبرنا.');
        }

        rescue(fn () => $user->notify(new EmailChangeRequested($newEmail)));

        return redirect()
            ->route('clinic.assistants.index')
            ->with(
                'success',
                "تم تعديل بيانات المساعد. لم يتغير بريده الحالي بعد؛ أرسلنا رابط تأكيد إلى {$newEmail}، وسيتغير بريده بعد أن يفتح الرسالة ويضغط على الرابط."
            );
    }

    /**
     * تفعيل / تعطيل سريع لحساب المساعد من غير فتح فورم التعديل.
     */
    public function toggleStatus(DoctorAssistant $assistant)
    {
        $doctor = Auth::user()->clinicDoctor();

        abort_unless($assistant->doctor_id === $doctor->id, 403);

        $assistant->update([
            'is_active' => ! $assistant->is_active,
        ]);

        return back()->with(
            'success',
            $assistant->is_active ? 'تم تفعيل حساب المساعد بنجاح.' : 'تم تعطيل حساب المساعد بنجاح.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DoctorAssistant $assistant)
    {
        $doctor = Auth::user()->clinicDoctor();

        abort_unless($assistant->doctor_id === $doctor->id, 403);

        DB::transaction(function () use ($assistant) {

            $userId = $assistant->user_id;

            $assistant->delete();

            User::where('id', $userId)->delete();
        });

        return redirect()
            ->route('clinic.assistants.index')
            ->with('success', 'تم حذف المساعد بنجاح.');
    }

    /**
     * البريد مستخدم كـ email عند يوزر آخر، أو محجوز كطلب تغيير ساري.
     */
    private function emailIsTaken(string $email, int $ignoreUserId): bool
    {
        return User::where('id', '!=', $ignoreUserId)
            ->where(function ($query) use ($email) {
                $query->where('email', $email)
                    ->orWhere(function ($query) use ($email) {
                        $query->where('pending_email', $email)
                            ->where(
                                'pending_email_requested_at',
                                '>',
                                now()->subMinutes(User::PENDING_EMAIL_TTL_MINUTES)
                            );
                    });
            })
            ->exists();
    }
}
