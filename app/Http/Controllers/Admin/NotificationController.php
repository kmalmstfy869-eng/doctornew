<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SendDoctorNotificationRequest;
use App\Models\Doctor;
use App\Services\NotificationService;

class NotificationController extends Controller
{

    public function create()
    {
        return view('admin.notifications.create');
    }



    public function store(SendDoctorNotificationRequest $request)
    {
        $doctor = Doctor::findOrFail(
            $request->doctor_id
        );



        $url = match ($request->page) {

            'notifications' =>
                route('doctor.notifications.index'),

            'reviews' =>
                route('doctor.reviews'),

            'subscription' =>
                route('doctor.reviews'),

            'profile' =>
                route('doctor.profile.edit'),

            'dashboard' =>
                route('doctor.dashboard'),

        };



        app(NotificationService::class)->send(
            $doctor,
            'admin',
            $request->title,
            $request->message,
            $url
        );


        return redirect()
            ->route('admin.notifications')
            ->with(
                'success',
                'تم إرسال الإشعار للطبيب بنجاح.'
            );
    }
}
