<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class DoctorJoinRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class . ',email',
                function ($attribute, $value, $fail) {
                    if (User::where('pending_email', $value)->exists()) {
                      $fail('البريد الإلكتروني غير متاح للاستخدام حاليًا.');
                    }
                },
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],

            'specialty_id' => [
                'required',
                'exists:specialties,id',
            ],

            'area_id' => [
                'required',
                'exists:areas,id',
            ],

            'phone' => [
                'required',
                'regex:/^01[0125][0-9]{8}$/',
            ],

            'whatsapp' => [
                'nullable',
                'regex:/^01[0125][0-9]{8}$/',
            ],

            'experience' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],

            'bio' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'consultation_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'clinic_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'location' => [
                'required',
                'string',
                'max:1000',
            ],

            'working_hours' => [
                'required',
                'string',
                'max:1000',
            ],

            'terms' => [
                'required',
                'accepted',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.string' => 'البريد الإلكتروني يجب أن يكون نصًا.',
            'email.lowercase' => 'البريد الإلكتروني يجب أن يكون بأحرف صغيرة.',
            'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
            'email.max' => 'البريد الإلكتروني لا يمكن أن يزيد عن 255 حرفًا.',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',

            'password.required' => 'كلمة المرور مطلوبة.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
            'password.max' => 'كلمة المرور طويلة جدًا.',
            'password.mixed' => 'كلمة المرور يجب أن تحتوي على حرف كبير وحرف صغير على الأقل.',
            'password.letters' => 'كلمة المرور يجب أن تحتوي على حرف واحد على الأقل.',
            'password.numbers' => 'كلمة المرور يجب أن تحتوي على رقم واحد على الأقل.',
            'password.symbols' => 'كلمة المرور يجب أن تحتوي على رمز واحد على الأقل.',
            'password.uncompromised' => 'كلمة المرور التي أدخلتها ظهرت في تسريبات بيانات سابقة، يرجى اختيار كلمة مرور أخرى.',

            // Name
            'name.required' => 'من فضلك أدخل اسم الدكتور.',
            'name.string' => 'اسم الدكتور يجب أن يكون نصًا صحيحًا.',
            'name.max' => 'اسم الدكتور يجب ألا يتجاوز 255 حرفًا.',

            // Specialty
            'specialty_id.required' => 'من فضلك اختر التخصص الطبي.',
            'specialty_id.exists' => 'التخصص المختار غير موجود.',

            // Area
            'area_id.required' => 'من فضلك اختر المنطقة.',
            'area_id.exists' => 'المنطقة المختارة غير موجودة.',

            // Phone
            'phone.required' => 'من فضلك أدخل رقم الهاتف.',
            'phone.regex' => 'رقم الهاتف يجب أن يكون رقمًا مصريًا صحيحًا مكونًا من 11 رقمًا.',

            // WhatsApp
            'whatsapp.regex' => 'رقم الواتساب يجب أن يكون رقمًا مصريًا صحيحًا مكونًا من 11 رقمًا.',

            // Experience
            'experience.integer' => 'سنوات الخبرة يجب أن تكون رقمًا صحيحًا.',
            'experience.min' => 'سنوات الخبرة لا يمكن أن تكون أقل من صفر.',
            'experience.max' => 'سنوات الخبرة لا يمكن أن تتجاوز 100 سنة.',

            // Bio
            'bio.string' => 'النبذة يجب أن تكون نصًا صحيحًا.',
            'bio.max' => 'النبذة يجب ألا تتجاوز 2000 حرف.',

            // Consultation Price
            'consultation_price.required' => 'من فضلك أدخل سعر الكشف.',
            'consultation_price.numeric' => 'سعر الكشف يجب أن يكون رقمًا صحيحًا.',
            'consultation_price.min' => 'سعر الكشف لا يمكن أن يكون أقل من صفر.',

            // Clinic Name
            'clinic_name.string' => 'اسم العيادة يجب أن يكون نصًا صحيحًا.',
            'clinic_name.max' => 'اسم العيادة يجب ألا يتجاوز 255 حرفًا.',

            // Location
            'location.required' => 'من فضلك أدخل موقع العيادة.',
            'location.string' => 'عنوان العيادة يجب أن يكون نصًا صحيحًا.',
            'location.max' => 'عنوان العيادة يجب ألا يتجاوز 1000 حرف.',

            // Working Hours
            'working_hours.required' => 'من فضلك أدخل مواعيد العمل.',
            'working_hours.string' => 'مواعيد العمل يجب أن تكون نصًا صحيحًا.',
            'working_hours.max' => 'مواعيد العمل يجب ألا تتجاوز 1000 حرف.',

            'terms.required' => 'يجب الموافقة على شروط الاستخدام وسياسة الخصوصية.',
            'terms.accepted' => 'يجب الموافقة على شروط الاستخدام وسياسة الخصوصية.',
        ];
    }
}

