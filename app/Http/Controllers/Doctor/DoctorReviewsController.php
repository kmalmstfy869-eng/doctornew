<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class DoctorReviewsController extends Controller
{


    public function index(Request $request)
    {
        /** @var \App\Models\Doctor $doctor */
        $doctor = View::shared('doctor');

        $doctor->loadMissing('rating');

        $search = $request->input('search');

        $reviews = $doctor->rating()
            ->with('user')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('comment', 'like', "%{$search}%");
                });
            })
            ->where('status', 'approved')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'doctor.dashboard.ratings.index',
            compact(
                'reviews',
                'search',
            )
        );
    }
}
