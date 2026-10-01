<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Doctor;
use Illuminate\Http\Request;


class UnsubscribedDoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with([
            'user',
            'area',
            'specialty',
            'subscription',
            'subscription.plan',
        ])
            ->active()
            ->doctors()
            ->notSubscribed()
            ->paginate(10);

            $expiredDoctors = Doctor::doctors()
                ->active()
                ->whereHas('subscription', function ($query) {

                    $query
                        ->whereHas('plan', function ($query) {
                            $query->where('slug', '!=', 'free');
                        })
                        ->where(function ($query) {

                            $query->where('start_date', '>', now())
                                ->orWhere('end_date', '<', now())
                                ->orWhere('status', 'expired');

                        });

                })
                ->count();

            $unsubscribedDoctors = Doctor::doctors()
                ->active()
                ->whereHas('subscription', function ($query) {

                    $query->whereHas('plan', function ($planQuery) {

                        $planQuery->where('slug', 'free');

                    });

                })
                ->count();

        return view(
            'admin.doctors.unsubscribed_doctors',
            compact(
                'doctors',
                'expiredDoctors',
                'unsubscribedDoctors'
            )
        );
    }





}
