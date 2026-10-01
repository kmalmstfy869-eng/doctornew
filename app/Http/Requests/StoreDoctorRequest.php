<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | بيانات المستخدم والطبيب
            |--------------------------------------------------------------------------
            */

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email',

                function ($attribute, $value, $fail) {
                    if (User::where('pending_email', $value)->exists()) {
                        $fail('البريد الإلكتروني غير متاح للاستخدام حاليًا.');
                    }
                },
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
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
                'string',
                'regex:/^01[0125][0-9]{8}$/',
            ],

            'whatsapp' => [
                'required',
                'string',
                'regex:/^01[0125][0-9]{8}$/',
            ],

            'experience' => [
                'required',
                'integer',
                'min:0',
            ],

            'consultation_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'bio' => [
                'required',
                'string',
            ],

            /*
            |--------------------------------------------------------------------------
            | بيانات العيادة
            |--------------------------------------------------------------------------
            */

            'clinic_name' => [
                'required',
                'string',
                'max:255',
            ],

            'address' => [
                'required',
                'string',
                'max:255',
            ],

            'working_hours' => [
                'required',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | صورة الطبيب
            |--------------------------------------------------------------------------
            */

            'doctor_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:5120',
            ],

            /*
            |--------------------------------------------------------------------------
            | بيانات الاشتراك
            |--------------------------------------------------------------------------
            */

            'plan_id' => [
                'nullable',
                'exists:plans,id',
            ],

            'start_date' => [
                'required_with:plan_id',
                'nullable',
                'date',
            ],

            'price' => [
                'required_with:plan_id',
                'nullable',
                'numeric',
                'min:0',
            ],

            /*
            |--------------------------------------------------------------------------
            | البيانات الإضافية
            |--------------------------------------------------------------------------
            */

            'services' => [
                'nullable',
                'string',
            ],

            'google_maps_url' => [
                'nullable',
                'url',
                'max:1000',
            ],

            /*
            |--------------------------------------------------------------------------
            | صور العيادة
            |--------------------------------------------------------------------------
            */

            'clinic_images' => [
                'nullable',
                'array',
                'max:3',
            ],

            'clinic_images.*' => [
                'image',
                'mimes:jpg,jpeg,png',
                'max:5120',
            ],
        ];
    }

    public function messages(): array
    {
        return [

            'name.required' =>
                'اسم الطبيب مطلوب.',

            'name.string' =>
                'اسم الطبيب يجب أن يكون نصًا.',

            'name.max' =>
                'اسم الطبيب لا يمكن أن يتجاوز 255 حرفًا.',


            'email.required' =>
                'البريد الإلكتروني مطلوب.',

            'email.email' =>
                'البريد الإلكتروني غير صحيح.',

            'email.unique' =>
                'البريد الإلكتروني مستخدم بالفعل.',


            'password.required' =>
                'كلمة المرور مطلوبة.',

            'password.string' =>
                'كلمة المرور يجب أن تكون نصًا.',

            'password.min' =>
                'كلمة المرور يجب ألا تقل عن 8 أحرف.',

            'password.confirmed' =>
                'تأكيد كلمة المرور غير متطابق.',


            'specialty_id.required' =>
                'يجب اختيار تخصص الطبيب.',

            'specialty_id.exists' =>
                'التخصص المختار غير موجود.',


            'area_id.required' =>
                'يجب اختيار المحافظة.',

            'area_id.exists' =>
                'المحافظة المختارة غير موجودة.',


            'phone.required' =>
                'رقم الهاتف مطلوب.',

            'phone.regex' =>
                'رقم الهاتف يجب أن يكون رقم هاتف مصري صحيح مكونًا من 11 رقمًا ويبدأ بـ 010 أو 011 أو 012 أو 015.',


            'whatsapp.required' =>
                'رقم الواتساب مطلوب.',

            'whatsapp.regex' =>
                'رقم الواتساب يجب أن يكون رقم واتساب مصري صحيح مكونًا من 11 رقمًا ويبدأ بـ 010 أو 011 أو 012 أو 015.',


            'experience.integer' =>
                'سنوات الخبرة يجب أن تكون رقمًا صحيحًا.',

            'experience.required' =>
                'سنوات الخبرة مطلوبة.',

            'experience.min' =>
                'سنوات الخبرة لا يمكن أن تكون أقل من صفر.',


            'consultation_price.numeric' =>
                'سعر الكشف يجب أن يكون رقمًا.',

            'consultation_price.required' =>
                'سعر الكشف مطلوب.',

            'consultation_price.min' =>
                'سعر الكشف لا يمكن أن يكون أقل من صفر.',


            'bio.required' =>
                'نبذة الطبيب مطلوبة.',

            'bio.string' =>
                'نبذة الطبيب يجب أن تكون نصًا.',


            'clinic_name.required' =>
                'اسم العيادة مطلوب.',

            'clinic_name.max' =>
                'اسم العيادة لا يمكن أن يتجاوز 255 حرفًا.',


            'address.required' =>
                'عنوان العيادة مطلوب.',

            'address.max' =>
                'عنوان العيادة لا يمكن أن يتجاوز 255 حرفًا.',


            'working_hours.required' =>
                'مواعيد العمل مطلوبة.',

            'working_hours.max' =>
                'مواعيد العمل لا يمكن أن تتجاوز 255 حرفًا.',


            'doctor_image.image' =>
                'ملف صورة الطبيب يجب أن يكون صورة.',

            'doctor_image.mimes' =>
                'صورة الطبيب يجب أن تكون JPG أو JPEG أو PNG.',

            'doctor_image.max' =>
                'حجم صورة الطبيب يجب ألا يتجاوز 5 ميجابايت.',


            'plan_id.exists' =>
                'الباقة المختارة غير موجودة.',


            'start_date.required_with' =>
                'تاريخ بداية الاشتراك مطلوب عند اختيار باقة.',

            'start_date.date' =>
                'تاريخ بداية الاشتراك غير صحيح.',


            'price.required_with' =>
                'سعر الاشتراك مطلوب عند اختيار باقة.',

            'price.numeric' =>
                'سعر الاشتراك يجب أن يكون رقمًا.',

            'price.min' =>
                'سعر الاشتراك لا يمكن أن يكون أقل من صفر.',


            'services.string' =>
                'خدمات الطبيب يجب أن تكون نصًا.',


            'google_maps_url.url' =>
                'رابط Google Maps غير صحيح.',

            'google_maps_url.max' =>
                'رابط Google Maps طويل جدًا.',


            'clinic_images.array' =>
                'صور العيادة يجب أن تكون ملفات صور.',

            'clinic_images.max' =>
                'يمكنك إضافة 3 صور للعيادة كحد أقصى.',

            'clinic_images.*.image' =>
                'كل ملف من صور العيادة يجب أن يكون صورة.',

            'clinic_images.*.mimes' =>
                'صور العيادة يجب أن تكون JPG أو JPEG أو PNG.',

            'clinic_images.*.max' =>
                'حجم كل صورة للعيادة يجب ألا يتجاوز 5 ميجابايت.',
        ];
    }
}
