<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Rating;
use Illuminate\View\View;
class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalDoctors = Doctor::doctors()
            ->active()
            ->count();

        $totalDoctorsThisMonth = Doctor::doctors()
            ->active()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $pendingDoctor = Doctor::with([
            'specialty',
            'area',
        ])
            ->doctors()
            ->notactive()
            ->limit(4)
            ->get();

        $totalDoctorpending = Doctor::doctors()
            ->notactive()
            ->count();

        $subscribedDoctors = Doctor::doctors()
            ->active()
            ->subscribed()
            ->count();

        $subscribedDoctorsThisMonth = Doctor::doctors()
            ->active()
            ->subscribed()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();


        $latestRatings = Rating::with([
            'user',
            'doctor.user',
        ])
            ->where('status', 'approved')
            ->latest()
            ->take(3)
            ->get();


        $expiringDoctors = Doctor::with([
            'user',
            'specialty',
            'subscription',
        ])
            ->active()
            ->doctors()
            ->Subscribed()
            ->join('subscriptions', 'subscriptions.doctor_id', '=', 'doctors.id')
            ->orderBy('subscriptions.end_date', 'asc')
            ->select('doctors.*')
            ->selectRaw('ROUND(GREATEST(TIMESTAMPDIFF(HOUR, NOW(), subscriptions.end_date), 0) / 24, 1) as remaining_days')
            ->limit(4)
            ->get();

        $specialties = Doctor::query()
            ->doctors()
            ->active()
            ->selectRaw('specialty_id, COUNT(*) as total')
            ->groupBy('specialty_id')
            ->with('specialty:id,name')
            ->orderByDesc('total')
            ->take(4)
            ->get();

        $otherDoctors=max( 0, $totalDoctors -  ($specialties->sum("total")  ) );
        return view(
            'admin.index',
            compact(
                'totalDoctors',
                'subscribedDoctors',
                'subscribedDoctorsThisMonth',
                'totalDoctorsThisMonth',
                'pendingDoctor',
                'totalDoctorpending',
                'latestRatings',
                'expiringDoctors',
                'specialties',
                'otherDoctors',
            )
        );
    }

      public function profileadmin(Request $request): View
    {



        $user = $request->user();


        return view('admin.profile.profile', [
            'user' => $user,
            "link"=>"admin.dashboard",
        ]);
    }


}
