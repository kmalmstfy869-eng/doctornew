<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SendDoctorNotificationRequest extends FormRequest
{
    /**
     * السماح بالطلب
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
        return [

            'doctor_id' => [
                'required',
                'integer',
                'exists:doctors,id',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'message' => [
                'required',
                'string',
            ],

            'page' => [
                'required',
                Rule::in([
                    'notifications',
                    'reviews',
                    'subscription',
                    'profile',
                    'dashboard',
                ]),
            ],

        ];
    }

    /**
     * رسائل التحقق بالعربي
     */
    public function messages(): array
    {
        return [

            'doctor_id.required' =>
                'من فضلك أدخل رقم الطبيب.',

            'doctor_id.integer' =>
                'رقم الطبيب يجب أن يكون رقمًا صحيحًا.',

            'doctor_id.exists' =>
                'الطبيب بهذا الرقم غير موجود.',


            'title.required' =>
                'من فضلك أدخل عنوان الإشعار.',

            'title.string' =>
                'عنوان الإشعار يجب أن يكون نصًا.',

            'title.max' =>
                'عنوان الإشعار يجب ألا يتجاوز 255 حرفًا.',


            'message.required' =>
                'من فضلك أدخل نص الإشعار.',

            'message.string' =>
                'نص الإشعار يجب أن يكون نصًا.',


            'page.required' =>
                'من فضلك اختر الصفحة التي سيفتحها الإشعار.',

            'page.in' =>
                'الصفحة المختارة غير صحيحة.',
        ];
    }

    /**
     * أسماء الحقول بالعربي
     */
    public function attributes(): array
    {
        return [

            'doctor_id' => 'رقم الطبيب',

            'title' => 'عنوان الإشعار',

            'message' => 'نص الإشعار',

            'page' => 'الصفحة',

        ];
    }
}
