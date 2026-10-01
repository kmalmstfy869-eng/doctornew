<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialties;
use App\Models\Doctor;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Specialties = Specialties::orderBy('sort_order')->paginate(12);

        return view(
            "home.specialty.specialty",
            compact("Specialties")
        );
    }


    /**
     * Display the specified resource.
     */
        public function show(string $slug)
        {
            $specialty = Specialties::where('slug', $slug)->firstOrFail();

            $doctors = $specialty->doctors()
                ->with([
                    'user',
                    'area',
                    'specialty',
                    'rating',
                ])
                ->active()
                ->doctors()
                ->orderByPlan()
                ->paginate(9);

            $name = $specialty->name;

            return view(
                'home.doctors.doctors',
                compact('doctors', 'name')
            );
        }



}
