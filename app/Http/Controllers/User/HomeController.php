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
        $favoriteIds = $request->user()
            ? $request->user()->favoriteDoctors()->pluck('doctors.id')->all()
            : [];
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
            compact('specialties', 'doctors', 'areas','favoriteIds')
        );
    }

    public function profileuser(Request $request): View
    {
        $user = $request->user();

        $jobs = $user->jobs()
            ->latest()
            ->get();

        $favorites = $user->favoriteDoctors()
            ->with(['user', 'area', 'specialty', 'rating', 'subscription.plan'])
            ->active()
            ->doctors()
            ->latest('favorites.created_at')
            ->get();

        return view('home.profile.profile', [
            'user' => $user,
            'jobs' => $jobs,
            'link' => 'home',
            'favorites' => $favorites,
            'favoriteIds' => $favorites->pluck('id')->all(),
        ]);
    }
}
