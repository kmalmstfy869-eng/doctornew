<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        // return Auth::check();

        return true;
    }

    public function rules(): array
    {
        return [

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'company_name' => [
                'required',
                'string',
                'max:255',
            ],

            'category' => [
                'required',
                'string',
                'max:255',
            ],

            'qualification' => [
                'required',
                'string',
                'max:255',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'job_type' => [
                'required',
                'in:دوام كامل,دوام جزئي,العمل عن بعد',
            ],

            'experience' => [
                'required',
                'in:أقل من سنة,من سنة إلى 3 سنوات,من 3 إلى 5 سنوات,أكثر من 5 سنوات',
            ],

            'salary_min' => [
                'nullable',
                'numeric',
                'min:0',
                'max:4294967295',
            ],

            'salary_max' => [
                'nullable',
                'numeric',
                'min:0',
                'max:4294967295',
                'gte:salary_min',
            ],

            'description' => [
                'required',
                'string',
                'min:20',
            ],

            'vacancies' => [
                'required',
                'integer',
                'min:1',
            ],

            'working_hours' => [
                'nullable',
                'string',
                'max:255',
            ],

            'working_days' => [
                'nullable',
                'string',
                'max:255',
            ],

            'application_deadline' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'phone' => [
                'required',
                'regex:/^01[0125][0-9]{8}$/',
            ],

            'whatsapp' => [
                'required',
                'regex:/^01[0125][0-9]{8}$/',
            ],

        ];
    }


    public function messages(): array
    {
        return [

            'title.required' =>
                'من فضلك اكتب اسم الوظيفة.',

            'title.max' =>
                'اسم الوظيفة يجب ألا يتجاوز 255 حرفًا.',


            'company_name.required' =>
                'من فضلك اكتب اسم الشركة.',

            'company_name.max' =>
                'اسم الشركة يجب ألا يتجاوز 255 حرفًا.',


            'category.required' =>
                'من فضلك اختر تصنيف الوظيفة.',


            'qualification.required' =>
                'من فضلك اكتب المؤهل المطلوب.',


            'location.string' =>
                'موقع الوظيفة يجب أن يكون نصًا صحيحًا.',

            'location.max' =>
                'موقع الوظيفة يجب ألا يتجاوز 255 حرفًا.',


            'job_type.required' =>
                'من فضلك اختر نوع الدوام.',

            'job_type.in' =>
                'نوع الدوام المختار غير صحيح.',


            'experience.required' =>
                'من فضلك اختر مستوى الخبرة.',

            'experience.in' =>
                'مستوى الخبرة المختار غير صحيح.',


            'salary_min.numeric' =>
                'الحد الأدنى للراتب يجب أن يكون رقمًا.',

            'salary_min.min' =>
                'الحد الأدنى للراتب لا يمكن أن يكون أقل من صفر.',

            'salary_min.max' =>
                'الحد الأدنى للراتب كبير جدًا.',


            'salary_max.numeric' =>
                'الحد الأقصى للراتب يجب أن يكون رقمًا.',

            'salary_max.min' =>
                'الحد الأقصى للراتب لا يمكن أن يكون أقل من صفر.',

            'salary_max.max' =>
                'الحد الأقصى للراتب كبير جدًا.',

            'salary_max.gte' =>
                'الحد الأقصى للراتب يجب أن يكون أكبر من أو يساوي الحد الأدنى.',


            'description.required' =>
                'من فضلك اكتب وصف الوظيفة.',

            'description.min' =>
                'وصف الوظيفة يجب أن يكون 20 حرفًا على الأقل.',


            'vacancies.required' =>
                'من فضلك اكتب عدد الوظائف المطلوبة.',

            'vacancies.integer' =>
                'عدد الوظائف يجب أن يكون رقمًا صحيحًا.',

            'vacancies.min' =>
                'يجب أن يكون عدد الوظائف المطلوبة وظيفة واحدة على الأقل.',


            'working_hours.max' =>
                'ساعات العمل طويلة جدًا.',


            'working_days.max' =>
                'أيام العمل طويلة جدًا.',

            'application_deadline.required' =>
                'من فضلك اختر آخر موعد للتقديم.',

            'application_deadline.date' =>
                'تاريخ آخر موعد للتقديم غير صحيح.',

            'application_deadline.after_or_equal' =>
                'آخر موعد للتقديم يجب أن يكون اليوم أو تاريخًا لاحقًا.',


            'phone.required' =>
                'من فضلك اكتب رقم الهاتف.',

            'phone.regex' =>
                'من فضلك اكتب رقم هاتف مصري صحيح.',


            'whatsapp.required' =>
                'من فضلك اكتب رقم الواتساب.',

            'whatsapp.regex' =>
                'من فضلك اكتب رقم واتساب مصري صحيح.',

        ];
    }
}

