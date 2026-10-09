<?php

namespace App\Http\Controllers\Admin;
use App\Models\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class subscribedDoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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
            ->Subscribed()
            ->join('subscriptions', 'subscriptions.doctor_id', '=', 'doctors.id')
            ->orderBy('subscriptions.end_date', 'asc')
            ->select('doctors.*')
            ->selectRaw('ROUND(GREATEST(TIMESTAMPDIFF(HOUR, NOW(), subscriptions.end_date), 0) / 24, 1) as remaining_days')
            ->search($request->input('search'))
            ->paginate(10)->withQueryString();


        $expiringSubscriptions = Doctor::Subscribed()
            ->whereHas('subscription', function ($query) {
                $query->whereBetween('end_date', [
                    now(),
                    now()->addDays(7)
                ]);
            })
            ->count();


        $activeSubscriptions = Doctor::Subscribed()
            ->whereHas('subscription', function ($query) {
                $query->where('end_date', '>', now()->addDays(7));
            })
            ->count();

        $now = now();


        return view(
            'admin.doctors.subscribed_doctors',
            compact(
                'doctors',
                'expiringSubscriptions',
                'activeSubscriptions',

            )
        );
    }

}
