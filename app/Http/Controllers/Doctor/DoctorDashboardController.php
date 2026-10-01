<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\View as V;
use Illuminate\Http\Request;
use Illuminate\View\View ;
class DoctorDashboardController extends Controller
{


public function index()
{
    /** @var \App\Models\Doctor $doctor */
    $doctor = V::shared('doctor');

        if ($doctor) {
            $doctor->loadMissing([
                'area',
                'rating',
            ]);
        }




    $notifications = $doctor->notifications()
        ->latest()
        ->limit(4)
        ->get();



    return view('doctor.dashboard.index',compact('notifications'));
}



      public function profiledoctor(Request $request): View
    {

        $user = $request->user();

        return view('doctor.dashboard.profile.profile', [
            'user' => $user,
            "link"=>"doctor.dashboard",
            "flagnotifications"=>true,
        ]);
    }


}
