<?php

namespace App\Http\Requests\Doctor;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateAssistantRequest extends FormRequest
{
    /**
     * فقط الطبيب نفسه (مش مساعد) يقدر يعدل بيانات مساعد.
     */
    public function authorize(): bool
    {
        return ! (bool) Auth::user()?->doctorAssistant;
    }

    public function rules(): array
    {
        $assistant = $this->route('assistant');

        $userId = $assistant?->user_id;

        return [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $userId,

                function ($attribute, $value, $fail) use ($userId) {
                    if (
                        User::where('pending_email', $value)
                            ->where('id', '!=', $userId)
                            ->exists()
                    ) {
                        $fail('البريد الإلكتروني غير متاح للاستخدام حاليًا.');
                    }
                },
            ],

            'phone' => ['required', 'string', 'regex:/^01[0125][0-9]{8}$/'],
            'status' => ['required', 'in:active,inactive'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'الاسم',
            'email' => 'البريد الإلكتروني',
            'phone' => 'رقم الهاتف',
            'status' => 'حالة الحساب',
            'password' => 'كلمة المرور الجديدة',
            'password_confirmation' => 'تأكيد كلمة المرور',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'من فضلك اكتب :attribute.',
            'name.string' => ':attribute غير صالح.',
            'name.max' => ':attribute طويل جدًا، الحد الأقصى 255 حرفًا.',

            'email.required' => 'من فضلك اكتب :attribute.',
            'email.email' => ':attribute غير صحيح.',
            'email.max' => ':attribute طويل جدًا.',
            'email.unique' => ':attribute مستخدم من قبل، جرّب بريدًا آخر.',

            'phone.required' => 'من فضلك اكتب :attribute.',
            'phone.string' => ':attribute غير صالح.',
            'phone.regex' => ':attribute غير صحيح، من فضلك اكتب رقم هاتف مصري صحيح.',

            'status.required' => 'من فضلك اختر :attribute.',
            'status.in' => ':attribute غير صحيحة.',

            'password.string' => ':attribute غير صالحة.',
            'password.min' => ':attribute يجب ألا تقل عن 8 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير مطابق لكلمة المرور.',
        ];
    }
}
