<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Specialties;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index()
    {
        $specialties = Specialties::orderBy('sort_order')->take(8)->get();

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
            compact('specialties', 'doctors')
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
            "link"=>"home",
"favorites"=>null
        ]);
    }
}
