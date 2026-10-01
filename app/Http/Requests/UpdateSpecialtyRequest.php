<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSpecialtyRequest extends FormRequest
{
    /**
     * تحديد صلاحية تنفيذ الطلب
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * قواعد التحقق
     */
    public function rules(): array
    {
        $specialty = $this->route('specialty');

        return [

            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('specialties', 'name')
                    ->ignore($specialty->id),
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'logo' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('specialties', 'slug')
                    ->ignore($specialty->id),
            ],

            'sort_order' => [
                'required',
                'integer',
                'min:0',
            ],

        ];
    }

    /**
     * رسائل التحقق
     */
    public function messages(): array
    {
        return [

            'name.required' => 'اسم التخصص مطلوب.',
            'name.string' => 'اسم التخصص يجب أن يكون نصًا.',
            'name.max' => 'اسم التخصص لا يمكن أن يزيد عن 255 حرفًا.',
            'name.unique' => 'اسم التخصص موجود بالفعل.',

            'title.required' => 'عنوان التخصص مطلوب.',
            'title.string' => 'عنوان التخصص يجب أن يكون نصًا.',
            'title.max' => 'عنوان التخصص لا يمكن أن يزيد عن 255 حرفًا.',

            'logo.required' => 'شعار التخصص مطلوب.',
            'logo.string' => 'شعار التخصص يجب أن يكون نصًا.',
            'logo.max' => 'شعار التخصص لا يمكن أن يزيد عن 255 حرفًا.',

            'slug.required' => 'الرابط المختصر مطلوب.',
            'slug.string' => 'الرابط المختصر يجب أن يكون نصًا.',
            'slug.max' => 'الرابط المختصر لا يمكن أن يزيد عن 255 حرفًا.',
            'slug.unique' => 'الرابط المختصر مستخدم بالفعل.',

            'sort_order.required' => 'ترتيب الظهور مطلوب.',
            'sort_order.integer' => 'ترتيب الظهور يجب أن يكون رقمًا.',
            'sort_order.min' => 'ترتيب الظهور لا يمكن أن يكون أقل من صفر.',

        ];
    }
}
