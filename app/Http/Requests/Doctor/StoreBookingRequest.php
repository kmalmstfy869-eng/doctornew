<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
           $user = Auth::user();
        $doctor =$user->clinicDoctor();

        $isClinicSystem = $doctor?->hasFeature('clinic_system') ?? false;

        return [
            'appointment_date' => [
                'required',
                'date',
            ],

            /*
            |--------------------------------------------------------------------------
            | المريض الموجود
            |--------------------------------------------------------------------------
            */
            'patient_id' => [
                $isClinicSystem ? 'nullable' : 'prohibited',
                'integer',

                Rule::exists('patients', 'id')
                    ->where(function ($query) use ($doctor) {
                        $query->where(
                            'doctor_id',
                            $doctor?->id
                        );
                    }),
            ],

            /*
            |--------------------------------------------------------------------------
            | اسم المريض الجديد
            |--------------------------------------------------------------------------
            */
            'new_patient_name' => [
                $isClinicSystem && $this->filled('patient_id')
                    ? 'nullable'
                    : 'required',

                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | هاتف المريض
            |--------------------------------------------------------------------------
            */
            'patient_phone' => [
                'nullable',
                'regex:/^01[0125][0-9]{8}$/',
            ],

            /*
            |--------------------------------------------------------------------------
            | السعر
            |--------------------------------------------------------------------------
            */
            'price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            /*
            |--------------------------------------------------------------------------
            | المدفوع
            |--------------------------------------------------------------------------
            */
            'paid' => [
                'nullable',
                'numeric',
                'min:0',
                'lte:price',
            ],

            /*
            |--------------------------------------------------------------------------
            | الخدمة
            |--------------------------------------------------------------------------
            */
            'service' => [
                'required',
                'string',
                'max:100',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'appointment_date.required' =>
                'تاريخ الحجز مطلوب.',

            'appointment_date.date' =>
                'تاريخ الحجز غير صحيح.',

            'patient_id.prohibited' =>
                ' لا يمكن اختيار مريض موجود ليس متاح في هذا الاشتراك.',

            'patient_id.integer' =>
                'بيانات المريض غير صحيحة.',

            'patient_id.exists' =>
                'المريض المحدد غير موجود أو لا ينتمي إلى حسابك.',

            'new_patient_name.required' =>
                'اسم المريض مطلوب.',

            'new_patient_name.string' =>
                'اسم المريض يجب أن يكون نصًا.',

            'new_patient_name.max' =>
                'اسم المريض يجب ألا يتجاوز 255 حرفًا.',

            'patient_phone.regex' =>
                'رقم الهاتف يجب أن يكون رقمًا مصريًا صحيحًا مكونًا من 11 رقمًا.',

            'price.numeric' =>
                'السعر يجب أن يكون رقمًا.',

            'price.min' =>
                'السعر لا يمكن أن يكون أقل من صفر.',

            'paid.numeric' =>
                'المبلغ المدفوع يجب أن يكون رقمًا.',

            'paid.min' =>
                'المبلغ المدفوع لا يمكن أن يكون أقل من صفر.',

            'paid.lte' =>
                'المبلغ المدفوع لا يمكن أن يكون أكبر من السعر المطلوب.',

            'service.required' =>
                'الخدمة مطلوبة.',

            'service.string' =>
                'الخدمة يجب أن تكون نصًا.',

            'service.max' =>
                'اسم الخدمة يجب ألا يتجاوز 100 حرف.',
        ];
    }

    public function attributes(): array
    {
        return [
            'appointment_date' => 'تاريخ الحجز',
            'patient_id' => 'المريض',
            'new_patient_name' => 'اسم المريض',
            'patient_phone' => 'رقم الهاتف',
            'price' => 'السعر',
            'paid' => 'المبلغ المدفوع',
            'service' => 'الخدمة',
        ];
    }
}
