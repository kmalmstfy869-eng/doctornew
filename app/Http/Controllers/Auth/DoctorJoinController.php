<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorJoinRequest;
use App\Models\Area;
use App\Models\Doctor;
use App\Models\Specialties;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
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
            DB::beginTransaction();

            $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'doctor',
        ]);

            $userId = $user->id;

            $doctor = Doctor::create([
                'working_hours' => $validated['working_hours'],
                'address' => $validated['location'],
                'clinic_name' => $validated['clinic_name'] ?? null,
                'consultation_price' => $validated['consultation_price'],
                'bio' => $validated['bio'] ?? null,
                'experience' => $validated['experience'],
                'whatsapp' => $validated['whatsapp'] ?? null,
                'phone' => $validated['phone'],
                'area_id' => $validated['area_id'],
                'specialty_id' => $validated['specialty_id'],
                'user_id' => $userId,
                'status' => "pending",
            ]);


                $startDate = now();
                $doctorId=$doctor->id;

            Subscription::create([
                'doctor_id' => $doctorId,
                'plan_id' => "1",
                'start_date' => $startDate,
                'end_date' => $startDate->copy()->addYears(10),
                "price"=>0,
                ]);


            DB::commit();

            return redirect()
                ->route('doctor_join')
                ->with(
                    'success',
                    'تم إرسال طلب الانضمام بنجاح، وسيتم مراجعته من الإدارة وإخبارك.'
                );

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    ' حدث خطأ أثناء إرسال طلب الانضمام، حاول مرة أخرى او تواصل معنا للاضافه اسرع'
                );
        }
    }
}

