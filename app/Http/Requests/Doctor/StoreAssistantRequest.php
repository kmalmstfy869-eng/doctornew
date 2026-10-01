<?php

namespace App\Http\Requests\Doctor;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAssistantRequest extends FormRequest
{
    protected $errorBag = 'assistantAdd';

    public function authorize(): bool
    {
        return ! (bool) Auth::user()?->doctorAssistant;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',

                function ($attribute, $value, $fail) {
                    if (User::where('pending_email', $value)->exists()) {
                        $fail('البريد الإلكتروني غير متاح للاستخدام حاليًا.');
                    }
                },
            ],

            'phone' => ['required', 'string', 'regex:/^01[0125][0-9]{8}$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'الاسم الكامل',
            'email' => 'البريد الإلكتروني',
            'phone' => 'رقم الهاتف',
            'password' => 'كلمة المرور',
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

            'password.required' => 'من فضلك اكتب :attribute.',
            'password.string' => ':attribute غير صالحة.',
            'password.min' => ':attribute يجب ألا تقل عن 8 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير مطابق لكلمة المرور.',
        ];
    }

    public function withValidator(ValidatorContract $validator): void
    {
        $validator->after(function (ValidatorContract $validator) {

            $doctor = Auth::user()?->clinicDoctor();

            if ($doctor && $doctor->assistants()->count() >= 5) {
                $validator->errors()->add(
                    'name',
                    'وصلت للحد الأقصى المسموح به وهو 5 مساعدين، لا يمكن إضافة مساعد جديد.'
                );
            }
        });
    }
}
