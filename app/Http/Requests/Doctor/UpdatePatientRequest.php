<?php

namespace App\Http\Requests\Doctor;

use App\Models\Patient;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
{
    /**
     * هل المستخدم مخول لإجراء هذا الطلب؟
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * قواعد التحقق من البيانات
     */
    public function rules(): array
    {
        $patient = $this->route('patient');

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
                Rule::unique('patients', 'phone')->ignore(
                    $patient instanceof Patient ? $patient->id : null
                ),
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

            'notes' => [
                'nullable',
                'string',
                'max:2000',
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

    'phone.required'                     => 'برجاء ادخال رقم الهاتف',
            'phone.regex'                => 'رقم الهاتف يجب أن يكون رقمًا مصريًا صحيحًا مكونًا من 11 رقمًا.',
            'phone.unique'               => 'رقم الهاتف هذا مسجل بالفعل.',

            'birth_date.date'            => 'تاريخ الميلاد غير صحيح.',
            'birth_date.before_or_equal' => 'تاريخ الميلاد لا يمكن أن يكون في المستقبل.',

            'gender.in'                  => 'القيم المتاحة للجنس هي ذكر أو أنثى فقط.',

            'address.string'             => 'العنوان يجب أن يكون نصًا صحيحًا.',
            'address.max'                => 'العنوان يجب ألا يتجاوز 1000 حرف.',

            'notes.string'               => 'الملاحظات يجب أن تكون نصًا صحيحًا.',
            'notes.max'                  => 'الملاحظات يجب ألا تتجاوز 2000 حرف.',
        ];
    }

    /**
     * أسماء الحقول باللغة العربية
     */
    public function attributes(): array
    {
        return [
            'name'       => 'اسم المريض',
            'phone'      => 'رقم الهاتف',
            'birth_date' => 'تاريخ الميلاد',
            'gender'     => 'الجنس',
            'address'    => 'العنوان',
            'notes'      => 'الملاحظات',
        ];
    }
}

