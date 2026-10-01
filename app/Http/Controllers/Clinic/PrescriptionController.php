<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StorePrescriptionRequest;
use App\Http\Requests\Doctor\UpdatePrescriptionRequest;
use App\Models\Doctor;
use App\Models\Prescription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PrescriptionController extends Controller
{
    public function index(Request $request): View
    {
        $doctor = $this->doctor();

        $search = trim((string) $request->query('search', ''));
        $like = '%' . addcslashes($search, '%_\\') . '%';

        $prescriptions = Prescription::query()
            ->forDoctor($doctor->id)
            ->with('patient:id,name,phone,birth_date')
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
            ->latest('created_at')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('doctor.clinic.prescriptions.index', [
            'prescriptions' => $prescriptions,
            'search' => $search,
            'doctor' => $doctor,
        ]);
    }

    public function store(StorePrescriptionRequest $request): RedirectResponse
    {
        $doctor = $this->doctor();

        Prescription::create(
            $request->payload() + [
                'doctor_id' => $doctor->id,
            ]
        );

        return back()->with('success', 'تم حفظ الروشتة بنجاح.');
    }

    public function update(
        UpdatePrescriptionRequest $request,
        Prescription $prescription
    ): RedirectResponse {
        $this->ensureOwner($prescription);

        $prescription->update(
            $request->payload()
        );

        return back()->with('success', 'تم تعديل الروشتة بنجاح.');
    }

    public function destroy(Prescription $prescription): RedirectResponse
    {
        $this->ensureOwner($prescription);

        $prescription->delete();

        return back()->with('success', 'تم حذف الروشتة.');
    }

    private function doctor(): Doctor
    {
        $doctor = Auth::user()?->doctor;

        abort_if($doctor === null, 403);

        return $doctor;
    }

    /**
     * روشتة دكتور آخر = 404
     * بدون كشف إنها موجودة أصلًا.
     */
    private function ensureOwner(Prescription $prescription): void
    {
        abort_unless(
            (int) $prescription->doctor_id === (int) $this->doctor()->id,
            404
        );
    }
}
