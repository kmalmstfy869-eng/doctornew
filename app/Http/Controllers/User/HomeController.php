<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Doctor;
use App\Models\SiteVisitStat;
use App\Models\Specialties;
use App\Services\SiteVisitTracker;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request, SiteVisitTracker $tracker)
    {
        $tracker->record(SiteVisitStat::HOME, $request);

        $specialties = Specialties::orderBy('sort_order')->take(8)->get();

        $areas = Area::select('id', 'name')->get();

        $doctors = Doctor::with([
            'user',
            'area',
            'specialty',
            'rating',
            'subscription.plan',
        ])
            ->active()
            ->doctors()
            ->orderByPlan()
            ->take(3)
            ->get();

        return view(
            'home.index',
            compact('specialties', 'doctors', 'areas')
        );
    }

    public function profileuser(Request $request): View
    {
        $user = $request->user();

        $jobs = $user->jobs()
            ->latest()
            ->get();

        return view('home.profile.profile', [
            'user' => $user,
            'jobs' => $jobs,
            'link' => 'home',
            'favorites' => null,
        ]);
    }
}
