<?php

namespace App\Http\Requests\Doctor;

use App\Models\Patient;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StorePrescriptionRequest extends FormRequest
{
    /**
     * error bag مخصص:
     * يمنع أخطاء الروشتة من الاختلاط مع أخطاء الزيارة.
     */
    protected $errorBag = 'prescription';

    protected ?Patient $resolvedPatient = null;

    private const MED_KEYS = [
        'name',
        'dose',
        'frequency',
        'duration',
        'timing',
        'notes',
    ];

    public function authorize(): bool
    {
        return $this->user()?->doctor !== null;
    }

    protected function prepareForValidation(): void
    {
        /*
        |--------------------------------------------------------------------------
        | تحديد نوع المريض
        |--------------------------------------------------------------------------
        */

        $mode = $this->input('_patient_mode');

        if (! in_array($mode, ['registered', 'external'], true)) {
            $mode = 'registered';
        }

        /*
        |--------------------------------------------------------------------------
        | تنظيف patient_id
        |--------------------------------------------------------------------------
        */

        $patientId = $this->input('patient_id');

        if ($patientId === '') {
            $patientId = null;
        }

        /*
        |--------------------------------------------------------------------------
        | منع اختلاط بيانات التبويبين
        |--------------------------------------------------------------------------
        */

        if ($mode === 'external') {
            $patientId = null;
        }

        /*
        |--------------------------------------------------------------------------
        | تنظيف النصوص
        |--------------------------------------------------------------------------
        */

        $data = [
            '_patient_mode' => $mode,
            'patient_id' => $patientId,
        ];

        foreach (
            [
                'patient_name',
                'patient_phone',
                'notes',
            ] as $field
        ) {
            if (
                $this->has($field) &&
                is_string($this->input($field))
            ) {
                $value = trim($this->input($field));

                $data[$field] =
                    $value === ''
                        ? null
                        : $value;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | لو المريض مسجل، لا نحتاج بيانات المريض الخارجي
        |--------------------------------------------------------------------------
        */

        if ($mode === 'registered') {
            $data['patient_name'] = null;
            $data['patient_phone'] = null;
        }

        /*
        |--------------------------------------------------------------------------
        | تنظيف الأدوية
        |--------------------------------------------------------------------------
        */

        $medications = collect(
            $this->input('medications', [])
        )
            ->filter(
                fn ($row) => is_array($row)
            )
            ->map(function (array $row) {

                $clean = [];

                foreach (self::MED_KEYS as $key) {

                    $value = $row[$key] ?? null;

                    $clean[$key] =
                        is_string($value)
                            ? (
                                trim($value) === ''
                                    ? null
                                    : trim($value)
                            )
                            : null;
                }

                return $clean;
            })
            ->filter(
                fn (array $row) =>
                    collect($row)->contains(
                        fn ($value) =>
                            $value !== null
                    )
            )
            ->values()
            ->all();

        $data['medications'] = $medications;

        $this->merge($data);
    }

    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | نوع المريض
            |--------------------------------------------------------------------------
            */

            '_patient_mode' => [
                'required',
                'in:registered,external',
            ],

            /*
            |--------------------------------------------------------------------------
            | بيانات المريض المسجل
            |--------------------------------------------------------------------------
            */

            'patient_id' => [
                'nullable',
                'integer',
                'required_if:_patient_mode,registered',
            ],

            /*
            |--------------------------------------------------------------------------
            | بيانات الشخص غير المسجل
            |--------------------------------------------------------------------------
            */

            'patient_name' => [
                'nullable',
                'string',
                'max:150',
                'required_if:_patient_mode,external',
            ],

            'patient_phone' => [
                'nullable',
                'regex:/^01[0125][0-9]{8}$/',
            ],


            'next_visit_date'=>[
                'nullable',
                'date',
                'after_or_equal:today',
            ],
            /*
            |--------------------------------------------------------------------------
            | الأدوية
            |--------------------------------------------------------------------------
            */

            'medications' => [
                'required',
                'array',
                'min:1',
                'max:30',
            ],

            'medications.*.name' => [
                'required',
                'string',
                'max:150',
            ],

            'medications.*.dose' => [
                'nullable',
                'string',
                'max:100',
            ],

            'medications.*.frequency' => [
                'nullable',
                'string',
                'max:100',
            ],

            'medications.*.duration' => [
                'nullable',
                'string',
                'max:100',
            ],

            'medications.*.timing' => [
                'nullable',
                'string',
                'max:100',
            ],

            'medications.*.notes' => [
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | ملاحظات الطبيب
            |--------------------------------------------------------------------------
            */

            'notes' => [
                'nullable',
                'string',
                'max:3000',
            ],
        ];
    }

    /**
     * التأكد أن المريض المسجل تابع للدكتور الحالي.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {

                /*
                |------------------------------------------------------------------
                | التحقق من المريض المسجل فقط
                |------------------------------------------------------------------
                */

                if (
                    $this->input('_patient_mode') !== 'registered'
                ) {
                    return;
                }

                $id = $this->input('patient_id');

                if (
                    blank($id) ||
                    $validator->errors()->has('patient_id')
                ) {
                    return;
                }

                $patient = $this
                    ->user()
                    ->doctor
                    ->patients()
                    ->whereKey($id)
                    ->first();

                if (! $patient) {

                    $validator->errors()->add(
                        'patient_id',
                        'المريض المختار غير موجود ضمن مرضاك.'
                    );

                    return;
                }

                $this->resolvedPatient = $patient;
            },
        ];
    }

    public function patient(): ?Patient
    {
        return $this->resolvedPatient;
    }

    /**
     * البيانات الجاهزة للحفظ.
     */
    public function payload(): array
    {
        $data = $this->validated();

        $patient = $this->patient();

        return [
        'prescription_date' => now('Africa/Cairo'),

            'patient_id' =>
                $patient?->id,

            'patient_name' =>
                $patient
                    ? $patient->name
                    : ($data['patient_name'] ?? null),

            'patient_phone' =>
                $patient
                    ? $patient->phone
                    : ($data['patient_phone'] ?? null),

            'notes' =>
                $data['notes'] ?? null,

            'next_visit_date'=> $data['next_visit_date'] ?? null,

            'medications' =>
                collect($data['medications'])
                    ->map(
                        fn (array $row) => [

                            'name' =>
                                $row['name'],

                            'dose' =>
                                $row['dose'] ?? null,

                            'frequency' =>
                                $row['frequency'] ?? null,

                            'duration' =>
                                $row['duration'] ?? null,

                            'timing' =>
                                $row['timing'] ?? null,

                            'notes' =>
                                $row['notes'] ?? null,
                        ]
                    )
                    ->values()
                    ->all(),
        ];
    }

    public function attributes(): array
    {
        return [

            '_patient_mode' =>
                'نوع المريض',

            'patient_id' =>
                'المريض',

            'patient_name' =>
                'اسم المريض',

            'patient_phone' =>
                'رقم الهاتف',

            'medications' =>
                'الأدوية',

            'medications.*.name' =>
                'اسم العلاج',

            'medications.*.dose' =>
                'الجرعة',

            'medications.*.frequency' =>
                'عدد مرات الاستخدام',

            'medications.*.duration' =>
                'المدة',

            'medications.*.timing' =>
                'التوقيت',

            'medications.*.notes' =>
                'ملاحظات العلاج',

            'notes' =>
                'ملاحظات الطبيب',
        ];
    }

    public function messages(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | نوع المريض
            |--------------------------------------------------------------------------
            */

            '_patient_mode.required' =>
                'نوع المريض مطلوب.',

            '_patient_mode.in' =>
                'نوع المريض غير صحيح.',

            /*
            |--------------------------------------------------------------------------
            | بيانات المريض المسجل
            |--------------------------------------------------------------------------
            */

            'patient_id.required_if' =>
                'اختار مريضًا مسجلًا.',

            'patient_id.integer' =>
                'بيانات المريض المختارة غير صحيحة.',

            /*
            |--------------------------------------------------------------------------
            | بيانات الشخص غير المسجل
            |--------------------------------------------------------------------------
            */

            'patient_name.required_if' =>
                'اسم المريض مطلوب.',

            'patient_name.string' =>
                'اسم المريض يجب أن يكون نصًا.',

            'patient_name.max' =>
                'اسم المريض لا يمكن أن يتجاوز 150 حرفًا.',

            'next_visit_date.date' =>
                'تاريخ موعد الاعادة غير صحيح.',

            'next_visit_date.after_or_equal' =>
                'موعد الاعادة يجب أن يكون اليوم أو تاريخًا مستقبليًا.',
            /*
            |--------------------------------------------------------------------------
            | رقم الهاتف المصري
            |--------------------------------------------------------------------------
            */

            'patient_phone.regex' =>
                'رقم الهاتف يجب أن يكون رقم هاتف مصري صحيح.',

            /*
            |--------------------------------------------------------------------------
            | الأدوية
            |--------------------------------------------------------------------------
            */

            'medications.required' =>
                'أضف علاجًا واحدًا على الأقل.',

            'medications.array' =>
                'بيانات الأدوية غير صحيحة.',

            'medications.min' =>
                'أضف علاجًا واحدًا على الأقل.',

            'medications.max' =>
                'لا يمكن إضافة أكثر من 30 علاجًا.',

            /*
            |--------------------------------------------------------------------------
            | اسم العلاج
            |--------------------------------------------------------------------------
            */

            'medications.*.name.required' =>
                'اسم العلاج مطلوب.',

            'medications.*.name.string' =>
                'اسم العلاج يجب أن يكون نصًا.',

            'medications.*.name.max' =>
                'اسم العلاج لا يمكن أن يتجاوز 150 حرفًا.',

            /*
            |--------------------------------------------------------------------------
            | الجرعة
            |--------------------------------------------------------------------------
            */

            'medications.*.dose.string' =>
                'الجرعة يجب أن تكون نصًا.',

            'medications.*.dose.max' =>
                'الجرعة لا يمكن أن تتجاوز 100 حرف.',

            /*
            |--------------------------------------------------------------------------
            | عدد مرات الاستخدام
            |--------------------------------------------------------------------------
            */

            'medications.*.frequency.string' =>
                'عدد مرات الاستخدام يجب أن يكون نصًا.',

            'medications.*.frequency.max' =>
                'عدد مرات الاستخدام لا يمكن أن يتجاوز 100 حرف.',

            /*
            |--------------------------------------------------------------------------
            | المدة
            |--------------------------------------------------------------------------
            */

            'medications.*.duration.string' =>
                'المدة يجب أن تكون نصًا.',

            'medications.*.duration.max' =>
                'المدة لا يمكن أن تتجاوز 100 حرف.',

            /*
            |--------------------------------------------------------------------------
            | التوقيت
            |--------------------------------------------------------------------------
            */

            'medications.*.timing.string' =>
                'التوقيت يجب أن يكون نصًا.',

            'medications.*.timing.max' =>
                'التوقيت لا يمكن أن يتجاوز 100 حرف.',

            /*
            |--------------------------------------------------------------------------
            | ملاحظات العلاج
            |--------------------------------------------------------------------------
            */

            'medications.*.notes.string' =>
                'ملاحظات العلاج يجب أن تكون نصًا.',

            'medications.*.notes.max' =>
                'ملاحظات العلاج لا يمكن أن تتجاوز 255 حرفًا.',

            /*
            |--------------------------------------------------------------------------
            | ملاحظات الطبيب
            |--------------------------------------------------------------------------
            */

            'notes.string' =>
                'ملاحظات الطبيب يجب أن تكون نصًا.',

            'notes.max' =>
                'ملاحظات الطبيب لا يمكن أن تتجاوز 3000 حرف.',
        ];
    }
}
