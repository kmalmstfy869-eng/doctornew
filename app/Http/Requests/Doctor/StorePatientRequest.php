<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StorePatientRequest extends FormRequest
{
    protected $errorBag = 'createPatient';

    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * قواعد التحقق من البيانات (Validation Rules)
     */
    public function rules(): array
    {
        $doctorId = $this->user()->clinicDoctor()->id;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^01[0125][0-9]{8}$/',
                Rule::unique('patients', 'phone')
                    ->where('doctor_id', $doctorId),
            ],
            'birth_date' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],
            'gender' => [
                'nullable',
                'in:male,female',
            ],
            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * رسائل الخطأ المخصصة باللغة العربية
     */
    public function messages(): array
    {
        return [
            'name.required'              => 'يرجى إدخال اسم المريض.',
            'name.string'                => 'اسم المريض يجب أن يكون نصًا صحيحًا.',
            'name.max'                   => 'اسم المريض يجب ألا يتجاوز 255 حرفًا.',
            'phone.required'             => 'برجاء ادخال رقم الهاتف',
            'phone.regex'                => 'رقم الهاتف يجب أن يكون رقمًا مصريًا صحيحًا مكونًا من 11 رقمًا.',
            'phone.unique'               => 'رقم الهاتف هذا مسجل بالفعل.',
            'birth_date.date'            => 'تاريخ الميلاد غير صحيح.',
            'birth_date.before_or_equal' => 'تاريخ الميلاد لا يمكن أن يكون في المستقبل.',
            'gender.in'                  => 'القيم المتاحة للجنس هي ذكر أو أنثى فقط.',
            'address.string'             => 'العنوان يجب أن يكون نصًا صحيحًا.',
            'address.max'                => 'العنوان يجب ألا يتجاوز 1000 حرف.',
        ];
    }

    /**
     * أسماء الحقول باللغة العربية لاستخدامها في التنبيهات
     */
    public function attributes(): array
    {
        return [
            'name'       => 'اسم المريض',
            'phone'      => 'رقم الهاتف',
            'birth_date' => 'تاريخ الميلاد',
            'gender'     => 'الجنس',
            'address'    => 'العنوان',
        ];
    }
}