<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Services\NotificationService;
class PendingDoctorController extends Controller
{
    public function index()
    {
        $pendingDoctorsToday = Doctor::doctors()
            ->notactive()
            ->whereDate('created_at', today())
            ->count();

        $pendingDoctor = Doctor::with([
            'specialty',
            'area',
            'user',
        ])
            ->latest()
            ->doctors()
            ->notactive()
            ->paginate(4);

        return view(
            "admin.doctors.doctors_pending",
            compact(
                "pendingDoctor",
                "pendingDoctorsToday"
            )
        );
    }

    public function approveForListing(Doctor $doctor)
    {
        $doctor->status = "approved";
        $doctor->save();

    app(NotificationService::class)->send(
        $doctor,
        'profile',
        'تم قبول حسابك',
        'تم قبول حسابك بنجاح، ويمكنك الآن الدخول إلى لوحة التحكم.',
        route('doctor.dashboard')
    );
        return redirect()
            ->back()
            ->with('success', 'تم إضافة الدكتور بنجاح.');
    }

    public function rejectForListing(Doctor $doctor)
    {
        $doctor->status = 'rejected';
        $doctor->save();

        return redirect()
            ->back()
            ->with('success', 'تم رفض طلب ظهور الدكتور في الموقع.');
    }

    public function approve_all()
    {
        Doctor::where("status","pending")->update(["status"=>"approved"]);

        return redirect()
            ->back()
            ->with('success', 'تم قبول ظهور كل الدكاتره في الموقع بنجاح');
    }


}

