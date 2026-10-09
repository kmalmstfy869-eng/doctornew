<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorJoinRequest;
use App\Models\Area;
use App\Models\Doctor;
use App\Models\Specialties;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorJoinController extends Controller
{
    public function create()
    {
        $areas = Area::orderBy('name')->get();

        $specialties = Specialties::orderBy('name')->get();

        return view('auth.doctor_register', compact(
            'areas',
            'specialties'
        ));
    }

    public function store(DoctorJoinRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = DB::transaction(function () use ($validated) {

                $user = User::create([
                    'name'     => $validated['name'],
                    'email'    => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role'     => 'doctor',
                ]);

                $doctor = Doctor::create([
                    'user_id'            => $user->id,
                    'working_hours'      => $validated['working_hours'],
                    'address'            => $validated['location'],
                    'clinic_name'        => $validated['clinic_name'] ?? null,
                    'consultation_price' => $validated['consultation_price'],
                    'bio'                => $validated['bio'] ?? null,
                    'experience'         => $validated['experience'],
                    'whatsapp'           => $validated['whatsapp'] ?? null,
                    'phone'              => $validated['phone'],
                    'area_id'            => $validated['area_id'],
                    'specialty_id'       => $validated['specialty_id'],
                    'status'             => 'pending',
                ]);

                $startDate = now();

                Subscription::create([
                    'doctor_id'  => $doctor->id,
                    'plan_id'    => 1,
                    'start_date' => $startDate,
                    'end_date'   => $startDate->copy()->addYears(10),
                    'price'      => 0,
                ]);

                return $user;
            });

        } catch (\Throwable $e) {

            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'حصل خطأ أثناء إرسال طلب الانضمام، حاول تاني أو تواصل معانا وهنساعدك بسرعة.'
                );
        }

        // إرسال إيميل التأكيد (لو فشل مايبوظش التسجيل)
        rescue(fn () => $user->sendEmailVerificationNotification());

        // تسجيل دخول تلقائي
        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('verification.notice')
            ->with(
                'success',
                'أهلاً بيك 🎉 بعتنالك لينك تأكيد على إيميلك، أكد حسابك وبعدها هنراجع طلبك ونبلغك أول ما يتقبل.'
            );
    }
}
