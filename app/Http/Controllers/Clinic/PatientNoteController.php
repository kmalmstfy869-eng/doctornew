<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\PatientNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PatientNoteController extends Controller
{
    /**
     * إنشاء ملاحظة للمريض
     */
    public function store(Request $request, Patient $patient)
    {
        $doctor = Auth::user()->doctor;

    
        if (! $doctor->patients()->whereKey($patient->id)->exists()) {
            return back()->with('error', 'هذا المريض لا ينتمي إلى حسابك.');
        }

        $validated = $request->validate(
            [
                'note' => [
                    'required',
                    'string',
                    'max:5000',
                ],
            ],
            [
                'note.required' => 'من فضلك اكتب الملاحظة.',
                'note.string'   => 'الملاحظة يجب أن تكون نصًا صحيحًا.',
                'note.max'      => 'الملاحظة لا يمكن أن تتجاوز 5000 حرف.',
            ]
        );

        try {

            PatientNote::create([
                'patient_id' => $patient->id,
                'doctor_id'  => $doctor->id,
                'note'       => $validated['note'],
            ]);

            return back()->with('success', 'تم إضافة الملاحظة بنجاح.');

        } catch (\Throwable $e) {

            return back()->with('error', 'حدث خطأ أثناء إضافة الملاحظة.');
        }
    }

    /**
     * حذف ملاحظة
     */
    public function destroy(PatientNote $patientNote)
    {
        $doctor = Auth::user()->doctor;

        // التأكد أن الملاحظة تخص الدكتور الحالي
        if ($patientNote->doctor_id !== $doctor->id) {
            return back()->with('error', 'لا يمكنك حذف هذه الملاحظة.');
        }

        try {

            DB::transaction(function () use ($patientNote) {
                $patientNote->delete();
            });

            return back()->with('success', 'تم حذف الملاحظة بنجاح.');

        } catch (\Throwable $e) {

            return back()->with('error', 'حدث خطأ أثناء حذف الملاحظة.');
        }
    }
}