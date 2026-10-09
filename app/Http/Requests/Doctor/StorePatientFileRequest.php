<?php

namespace App\Http\Requests\Doctor;

use App\Models\PatientFile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePatientFileRequest extends FormRequest
{
    // أخطاء الرفع في bag مستقل عشان ما تتخلطش مع أي مودال تاني في الصفحة.
    protected $errorBag = 'patient_file';

    public function authorize(): bool
    {
        return $this->user()?->can('create', PatientFile::class) ?? false;
    }

    public function rules(): array
    {

        $maxKb = (int) config('clinic.patient_files_max_file_mb', 25) * 1024;

        $rules = [
            'file' => [
                'required',
                'file',
                'max:' . $maxKb,
                'mimes:pdf,jpg,jpeg,png,webp',
                'mimetypes:application/pdf,image/jpeg,image/png,image/webp',
            ],
        ];

        // من صفحة كل الملفات المريض بييجي في الفورم، ولازم يكون تابع للدكتور ده.
        // من صفحة المريض هو محدد من الـ route.
        if (! $this->route('patient')) {
            $doctorId = $this->user()->clinicDoctor()->id;

            $rules['patient_id'] = [
                'required',
                'integer',
                Rule::exists('patients', 'id')->where('doctor_id', $doctorId),
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        $max = (int) config('clinic.patient_files_max_file_mb', 25);

        return [
            'file.required' => "لم يصل الملف للسيرفر. تأكد أن حجمه لا يزيد عن {$max} ميجا.",
            'file.uploaded' => "فشل رفع الملف. تأكد أن حجمه لا يزيد عن {$max} ميجا وحاول مرة أخرى.",
            'file.file' => 'الملف المرفوع غير صالح.',
            'file.max' => "حجم الملف أكبر من {$max} ميجا.",
            'file.mimes' => 'نوع الملف غير مسموح. المسموح: PDF, JPG, JPEG, PNG, WEBP.',
            'file.mimetypes' => 'نوع الملف غير مسموح. المسموح: PDF, JPG, JPEG, PNG, WEBP.',
            'patient_id.required' => 'اختر المريض أولًا.',
            'patient_id.exists' => 'المريض المختار غير موجود في حسابك.',
        ];
    }
}
