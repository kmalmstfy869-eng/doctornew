<?php

namespace App\Http\Requests\Doctor;

use App\Models\Prescription;

class UpdatePrescriptionRequest extends StorePrescriptionRequest
{
    /**
     * نفس قواعد الإنشاء + التأكد إن الروشتة تخص الدكتور الحالي.
     */
    public function authorize(): bool
    {
        $doctor = $this->user()?->doctor;
        $prescription = $this->route('prescription');

        return $doctor !== null
            && $prescription instanceof Prescription
            && (int) $prescription->doctor_id === (int) $doctor->id;
    }
}
