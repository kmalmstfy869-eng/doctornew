<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Services\Clinic\AppointmentSlotService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with([
            'user',
            'area',
            'specialty',
            'rating',
            'subscription.plan',
        ])
            ->orderByPlan()
            ->active()
            ->doctors()
            ->paginate(9);

        return view(
            'home.doctors.doctors',
            compact('doctors')
        );
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Doctor $doctor)
    {
        $doctor->load([
            'user',
            'area',
            'specialty',
            'subscription.plan',
        ]);


        /*
        |--------------------------------------------------------------------------
        | مواعيد الحجز الأونلاين
        |--------------------------------------------------------------------------
        */

        $bookingDays = collect();

        if ($doctor->hasFeature('booking')) {

            $slotService = app(AppointmentSlotService::class);

            $today = Carbon::today();

            /*
            |--------------------------------------------------------------------------
            | عرض الـ 7 أيام القادمة
            |--------------------------------------------------------------------------
            */

            for ($i = 0; $i < 7; $i++) {

                $date = $today->copy()->addDays($i);

                $slots = $slotService->getAvailableSlots(
                    $doctor,
                    $date->format('Y-m-d')
                );

                if (!empty($slots)) {

                    $bookingDays->push([
                        'date' =>
                            $date->format('Y-m-d'),

                        'day_name' =>
                            $date->locale('ar')
                                ->translatedFormat('l'),

                        'formatted_date' =>
                            $date->locale('ar')
                                ->translatedFormat('d F'),

                        'slots' =>
                            $slots,

                        'slots_count' =>
                            count($slots),
                    ]);
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | أطباء مشابهون
        |--------------------------------------------------------------------------
        */

        $similar_doctors = Doctor::with([
            'user',
            'area',
            'specialty',
            'rating',
            'subscription.plan',
        ])
            ->active()
            ->doctors()
            ->orderByPlan()
            ->where(
                'doctors.specialty_id',
                $doctor->specialty_id
            )
            ->where(
                'doctors.id',
                '!=',
                $doctor->id
            )
            ->limit(3)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | التقييمات
        |--------------------------------------------------------------------------
        */

        $ratings = $doctor->rating()
            ->with('user')
            ->where('status', 'approved')
            ->latest()
            ->paginate(3);


        /*
        |--------------------------------------------------------------------------
        | Doctor Details
        |--------------------------------------------------------------------------
        */

        return view(
            'home.doctors.doctor_details',
            compact(
                'doctor',
                'similar_doctors',
                'ratings',
                'bookingDays'
            )
        );
    }
}
