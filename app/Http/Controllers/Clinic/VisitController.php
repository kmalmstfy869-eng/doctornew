<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\VisitRequest;
use App\Models\Visit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VisitController extends Controller
{
    public function index(Request $request): View
    {
        $doctor = Auth::user()->doctor;

        $search = trim((string) $request->query('search', ''));

        $like = '%' . addcslashes($search, '%_\\') . '%';

        $visits = Visit::query()
            ->forDoctor($doctor->id)
            ->with('patient:id,name,phone')
            ->when($search !== '', function ($query) use ($like) {
                $query->where(function ($q) use ($like) {
                    $q->where('patient_name', 'like', $like)
                        ->orWhere('patient_phone', 'like', $like)
                        ->orWhereHas('patient', function ($p) use ($like) {
                            $p->where('name', 'like', $like)
                                ->orWhere('phone', 'like', $like);
                        });
                });
            })
            ->latest('visit_date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('doctor.clinic.visits.index', [
            'visits' => $visits,
            'search' => $search,
            'doctor' => $doctor,
        ]);
    }

    public function store(VisitRequest $request): RedirectResponse
    {
        $doctor = Auth::user()->doctor;

        Visit::create(
            $request->payload() + [
                'doctor_id' => $doctor->id,
            ]
        );

        return back()->with(
            'success',
            'تم حفظ الزيارة بنجاح.'
        );
    }

    public function update(
        VisitRequest $request,
        Visit $visit
    ): RedirectResponse {
        $doctor = Auth::user()->doctor;

        if ((int) $visit->doctor_id !== (int) $doctor->id) {
            return redirect()
                ->route('clinic.patients')
                ->with(
                    'error',
                    'غير مصرح لك بتعديل بيانات هذه الزيارة.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | تعديل بيانات الزيارة فقط
        |--------------------------------------------------------------------------
        |
        | ممنوع تغيير:
        | - المريض
        | - اسم المريض
        | - هاتف المريض
        | - موعد إنشاء الزيارة
        |
        */

        $visit->update(
            Arr::except(
                $request->payload(),
                [
                    'patient_id',
                    'patient_name',
                    'patient_phone',
                    'visit_date',
                ]
            )
        );

        return back()->with(
            'success',
            'تم تعديل الزيارة بنجاح.'
        );
    }

    public function destroy(Visit $visit): RedirectResponse
    {
        abort_unless(
            (int) $visit->doctor_id ===
                (int) Auth::user()->doctor->id,
            404
        );

        $visit->delete();

        return back()->with(
            'success',
            'تم حذف الزيارة.'
        );
    }
}



