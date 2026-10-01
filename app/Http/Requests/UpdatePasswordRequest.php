<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * السماح للمستخدم بإرسال الطلب.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * قواعد التحقق.
     */
    public function rules(): array
    {
        return [

            'current_password' => [
                'required',
                'current_password',
            ],

            'password' => [
                'required',
                'string',
                'confirmed',
                Password::defaults(),
            ],

        ];
    }

    /**
     * الرسائل بالعربي.
     */
    public function messages(): array
    {
        return [

            // كلمة المرور الحالية

            'current_password.required' =>
                'من فضلك أدخل كلمة المرور الحالية.',

            'current_password.current_password' =>
                'كلمة المرور الحالية غير صحيحة.',


            // كلمة المرور الجديدة

            'password.required' =>
                'من فضلك أدخل كلمة المرور الجديدة.',

            'password.string' =>
                'كلمة المرور يجب أن تكون نصًا.',

            'password.confirmed' =>
                'تأكيد كلمة المرور غير متطابق.',


            // قواعد Password::defaults()

            'password.min' =>
                'كلمة المرور يجب ألا تقل عن :min أحرف.',

            'password.mixed' =>
                'كلمة المرور يجب أن تحتوي على حروف كبيرة وصغيرة.',

            'password.letters' =>
                'كلمة المرور يجب أن تحتوي على حروف.',

            'password.numbers' =>
                'كلمة المرور يجب أن تحتوي على رقم واحد على الأقل.',

            'password.symbols' =>
                'كلمة المرور يجب أن تحتوي على رمز واحد على الأقل.',

            'password.uncompromised' =>
                'كلمة المرور التي أدخلتها ظهرت في تسريبات بيانات سابقة، من فضلك اختر كلمة مرور أخرى.',

        ];

        }
        protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
        {
            throw new \Illuminate\Validation\ValidationException(
                $validator,
                redirect()
                    ->route('profile')
                    ->withErrors($validator)
                    ->withInput()
                    ->withFragment('update-password')
            );
        }
}

