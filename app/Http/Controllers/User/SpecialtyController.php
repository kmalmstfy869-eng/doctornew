<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Specialties;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q'));

        $Specialties = Specialties::orderBy('sort_order')
            ->when($q !== '', function ($query) use ($q) {
                $like = '%' . addcslashes($q, '%_\\') . '%';
                $query->where(function ($w) use ($like) {
                    $w->where('name', 'like', $like)
                      ->orWhere('title', 'like', $like);
                });
            })
            ->paginate(12)
            ->withQueryString();

    if ($request->ajax()) {
        return response()
            ->json([
                'html'  => view('home.specialty._grid', compact('Specialties'))->render(),
                'count' => $Specialties->total(),
            ])
            ->header('Vary', 'X-Requested-With')
            ->header('Cache-Control', 'no-store');
    }

        return view('home.specialty.specialty', compact('Specialties'));
    }

    public function show(string $slug)
    {
        $specialty = Specialties::where('slug', $slug)->firstOrFail();

        return redirect()->route('doctors.index', ['specialty' => $specialty->id]);
    }
}
