<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Doctor;
use App\Models\SiteVisitStat;
use App\Models\Specialties;
use App\Services\Clinic\AppointmentSlotService;
use App\Services\SiteVisitTracker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q'));

        $doctors = Doctor::with(['user', 'area', 'specialty', 'rating', 'subscription.plan'])
            ->orderByPlan()
            ->active()
            ->doctors()
            ->when($q !== '', function ($query) use ($q) {
                $like = '%' . addcslashes($q, '%_\\') . '%';
                $query->where(function ($w) use ($like) {
                    $w->whereHas('user', fn ($u) => $u->where('name', 'like', $like))
                      ->orWhereHas('specialty', fn ($s) => $s->where('name', 'like', $like));
                });
            })
            ->when(
                is_numeric($request->query('area')),
                fn ($query) => $query->where('doctors.area_id', $request->query('area'))
            )
            ->when(
                is_numeric($request->query('specialty')),
                fn ($query) => $query->where('doctors.specialty_id', $request->query('specialty'))
            )
            ->when(
                $request->query('sort') === 'price',
                fn ($query) => $query->reorder()->orderBy('doctors.consultation_price', 'asc')
            )
            ->paginate(9)
            ->withQueryString();

        if ($request->ajax()) {
            return response()
                ->json([
                    'html'  => view('home.doctors._grid', compact('doctors'))->render(),
                    'count' => $doctors->total(),
                ])
                ->header('Vary', 'X-Requested-With')
                ->header('Cache-Control', 'no-store');
        }

        $areas = Area::select('id', 'name')->get();
        $specialties = Specialties::orderBy('sort_order')->get();

        return view('home.doctors.doctors', compact('doctors', 'areas', 'specialties'));
    }

    public function show(Request $request, Doctor $doctor, SiteVisitTracker $tracker)
    {

        $doctor->loadMissing('user');

        if ($doctor->status !== 'approved' || $doctor->user?->role !== 'doctor') {
            return redirect()
                ->route('doctors.index')
                ->with('error', 'هذا الدكتور حسابه مقفول مؤقتًا');
        }

        $doctor->load([
            'area',
            'specialty',
            'subscription.plan',
        ]);


        $tracker->record(SiteVisitStat::DOCTOR_PROFILE, $request, $doctor->id);

        $mapSrc = null;

        if (filled($doctor->google_maps_url)) {
            $mapSrc = str_contains($doctor->google_maps_url, '/maps/embed')
                ? $doctor->google_maps_url
                : 'https://maps.google.com/maps?q=' . urlencode((string) $doctor->address) . '&output=embed';
        }

        $doctorImageExists = $doctor->hasFeature('subscription')
            && filled($doctor->doctor_image)
            && Storage::disk('public')->exists($doctor->doctor_image);

        $existingClinicImages = collect($doctor->clinic_images ?? [])
            ->filter(fn ($image) => filled($image) && Storage::disk('public')->exists($image))
            ->values();

        $bookingDays = collect();

        if ($doctor->hasFeature('booking')) {
            $slotService = app(AppointmentSlotService::class);
            $today = Carbon::today();

            for ($i = 0; $i < 7; $i++) {
                $date = $today->copy()->addDays($i);

                $slots = $slotService->getAvailableSlots(
                    $doctor,
                    $date->format('Y-m-d')
                );

                if (! empty($slots)) {
                    $bookingDays->push([
                        'date' => $date->format('Y-m-d'),
                        'day_name' => $date->locale('ar')->translatedFormat('l'),
                        'formatted_date' => $date->locale('ar')->translatedFormat('d F'),
                        'slots' => $slots,
                        'slots_count' => count($slots),
                    ]);
                }
            }
        }

        $similar_doctors = Doctor::with([
            'user',
            'area',
            'specialty',
            'rating',
            'subscription.plan',
        ])
            ->active()
            ->doctors()
            ->orderByPlan()
            ->where('doctors.specialty_id', $doctor->specialty_id)
            ->where('doctors.id', '!=', $doctor->id)
            ->limit(3)
            ->get();

        $ratings = $doctor->rating()
            ->with('user')
            ->where('status', 'approved')
            ->latest()
            ->paginate(3);

        return view(
            'home.doctors.doctor_details',
            compact('doctor', 'similar_doctors', 'ratings', 'bookingDays', 'mapSrc', 'doctorImageExists', 'existingClinicImages')
        );
    }
}
