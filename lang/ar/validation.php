<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the numeric, string, and array versions. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'accepted' => 'يجب قبول :attribute.',
    'accepted_if' => 'يجب قبول :attribute عندما تكون :other هي :value.',
    'active_url' => 'حقل :attribute يجب أن يكون رابطًا صالحًا.',
    'after' => 'حقل :attribute يجب أن يكون تاريخًا بعد :date.',
    'after_or_equal' => 'حقل :attribute يجب أن يكون تاريخًا بعد أو مساويًا لـ :date.',
    'alpha' => 'حقل :attribute يجب أن يحتوي على حروف فقط.',
    'alpha_dash' => 'حقل :attribute يجب أن يحتوي على حروف وأرقام وشرطات وشرطات سفلية فقط.',
    'alpha_num' => 'حقل :attribute يجب أن يحتوي على حروف وأرقام فقط.',
    'array' => 'حقل :attribute يجب أن يكون مصفوفة.',
    'ascii' => 'حقل :attribute يجب أن يحتوي على أحرف وأرقام ورموز ASCII فقط.',
    'before' => 'حقل :attribute يجب أن يكون تاريخًا قبل :date.',
    'before_or_equal' => 'حقل :attribute يجب أن يكون تاريخًا قبل أو مساويًا لـ :date.',
    'between' => [
        'array' => 'حقل :attribute يجب أن يحتوي على عدد عناصر بين :min و :max.',
        'file' => 'حجم ملف :attribute يجب أن يكون بين :min و :max كيلوبايت.',
        'numeric' => 'قيمة :attribute يجب أن تكون بين :min و :max.',
        'string' => 'عدد أحرف :attribute يجب أن يكون بين :min و :max.',
    ],
    'boolean' => 'حقل :attribute يجب أن يكون صحيحًا أو خاطئًا.',
    'can' => 'حقل :attribute يحتوي على قيمة غير مسموح بها.',
    'confirmed' => 'تأكيد :attribute غير متطابق.',
    'contains' => 'حقل :attribute لا يحتوي على القيمة المطلوبة.',
    'current_password' => 'كلمة المرور غير صحيحة.',
    'date' => 'حقل :attribute يجب أن يكون تاريخًا صحيحًا.',
    'date_equals' => 'حقل :attribute يجب أن يكون تاريخًا مساويًا لـ :date.',
    'date_format' => 'حقل :attribute لا يتطابق مع الصيغة :format.',
    'decimal' => 'حقل :attribute يجب أن يحتوي على عدد عشري يتكون من :decimal منازل عشرية.',
    'declined' => 'يجب رفض :attribute.',
    'declined_if' => 'يجب رفض :attribute عندما تكون :other هي :value.',
    'different' => 'حقل :attribute يجب أن يكون مختلفًا عن :other.',
    'digits' => 'حقل :attribute يجب أن يتكون من :digits أرقام.',
    'digits_between' => 'حقل :attribute يجب أن يحتوي على عدد أرقام بين :min و :max.',
    'dimensions' => 'أبعاد الصورة في :attribute غير صالحة.',
    'distinct' => 'حقل :attribute يحتوي على قيمة مكررة.',
    'doesnt_end_with' => 'حقل :attribute يجب ألا ينتهي بأحد القيم التالية: :values.',
    'doesnt_start_with' => 'حقل :attribute يجب ألا يبدأ بأحد القيم التالية: :values.',
    'email' => 'حقل :attribute يجب أن يكون بريدًا إلكترونيًا صحيحًا.',
    'ends_with' => 'حقل :attribute يجب أن ينتهي بأحد القيم التالية: :values.',
    'enum' => 'القيمة المحددة في :attribute غير صحيحة.',
    'exists' => ':attribute المحدد غير موجود.',
    'extensions' => 'حقل :attribute يجب أن يكون ملفًا من نوع: :values.',
    'file' => 'حقل :attribute يجب أن يكون ملفًا.',
    'filled' => 'حقل :attribute يجب ألا يكون فارغًا.',
    'gt' => [
        'array' => 'يجب أن يحتوي :attribute على أكثر من :value من العناصر.',
        'file' => 'حجم ملف :attribute يجب أن يكون أكبر من :value كيلوبايت.',
        'numeric' => 'قيمة :attribute يجب أن تكون أكبر من :value.',
        'string' => 'عدد أحرف :attribute يجب أن يكون أكبر من :value.',
    ],
    'gte' => [
        'array' => 'يجب أن يحتوي :attribute على :value من العناصر أو أكثر.',
        'file' => 'حجم ملف :attribute يجب أن يكون أكبر من أو يساوي :value كيلوبايت.',
        'numeric' => 'قيمة :attribute يجب أن تكون أكبر من أو تساوي :value.',
        'string' => 'عدد أحرف :attribute يجب أن يكون أكبر من أو يساوي :value.',
    ],
    'hex_color' => 'حقل :attribute يجب أن يكون لونًا سداسيًا صحيحًا.',
    'image' => 'حقل :attribute يجب أن يكون صورة.',
    'in' => 'القيمة المحددة في :attribute غير صحيحة.',
    'in_array' => 'قيمة :attribute غير موجودة في :other.',
    'integer' => 'حقل :attribute يجب أن يكون عددًا صحيحًا.',
    'ip' => 'حقل :attribute يجب أن يكون عنوان IP صحيحًا.',
    'ipv4' => 'حقل :attribute يجب أن يكون عنوان IPv4 صحيحًا.',
    'ipv6' => 'حقل :attribute يجب أن يكون عنوان IPv6 صحيحًا.',
    'json' => 'حقل :attribute يجب أن يكون نص JSON صحيحًا.',
    'lowercase' => 'حقل :attribute يجب أن يكون بأحرف صغيرة.',
    'lt' => [
        'array' => 'يجب أن يحتوي :attribute على أقل من :value من العناصر.',
        'file' => 'حجم ملف :attribute يجب أن يكون أقل من :value كيلوبايت.',
        'numeric' => 'قيمة :attribute يجب أن تكون أقل من :value.',
        'string' => 'عدد أحرف :attribute يجب أن يكون أقل من :value.',
    ],
    'lte' => [
        'array' => 'يجب ألا يحتوي :attribute على أكثر من :value من العناصر.',
        'file' => 'حجم ملف :attribute يجب ألا يزيد عن :value كيلوبايت.',
        'numeric' => 'قيمة :attribute يجب أن تكون أقل من أو تساوي :value.',
        'string' => 'عدد أحرف :attribute يجب أن يكون أقل من أو يساوي :value.',
    ],
    'mac_address' => 'حقل :attribute يجب أن يكون عنوان MAC صالحًا.',
    'max' => [
        'array' => 'حقل :attribute يجب ألا يحتوي على أكثر من :max من العناصر.',
        'file' => 'حجم ملف :attribute يجب ألا يزيد عن :max كيلوبايت.',
        'numeric' => 'قيمة :attribute يجب ألا تزيد عن :max.',
        'string' => 'عدد أحرف :attribute يجب ألا يزيد عن :max.',
    ],
    'max_digits' => 'حقل :attribute يجب ألا يحتوي على أكثر من :max أرقام.',
    'mimes' => 'حقل :attribute يجب أن يكون ملفًا من نوع: :values.',
    'mimetypes' => 'حقل :attribute يجب أن يكون ملفًا من الأنواع: :values.',
    'min' => [
        'array' => 'حقل :attribute يجب أن يحتوي على :min من العناصر على الأقل.',
        'file' => 'حجم ملف :attribute يجب ألا يقل عن :min كيلوبايت.',
        'numeric' => 'قيمة :attribute يجب ألا تقل عن :min.',
        'string' => 'عدد أحرف :attribute يجب ألا يقل عن :min.',
    ],
    'min_digits' => 'حقل :attribute يجب أن يحتوي على :min أرقام على الأقل.',
    'missing' => 'حقل :attribute يجب ألا يكون موجودًا.',
    'missing_if' => 'حقل :attribute يجب ألا يكون موجودًا عندما تكون :other هي :value.',
    'missing_unless' => 'حقل :attribute يجب ألا يكون موجودًا ما لم تكن :other هي :value.',
    'missing_with' => 'حقل :attribute يجب ألا يكون موجودًا عند وجود :values.',
    'missing_with_all' => 'حقل :attribute يجب ألا يكون موجودًا عند وجود جميع القيم: :values.',
    'multiple_of' => 'قيمة :attribute يجب أن تكون من مضاعفات :value.',
    'not_in' => 'القيمة المحددة في :attribute غير صحيحة.',
    'not_regex' => 'صيغة :attribute غير صحيحة.',
    'numeric' => 'حقل :attribute يجب أن يكون رقمًا.',
    'password' => 'كلمة المرور غير صحيحة.',
    'present' => 'حقل :attribute يجب أن يكون موجودًا.',
    'present_if' => 'حقل :attribute يجب أن يكون موجودًا عندما تكون :other هي :value.',
    'present_unless' => 'حقل :attribute يجب أن يكون موجودًا ما لم تكن :other هي :value.',
    'present_with' => 'حقل :attribute يجب أن يكون موجودًا عند وجود :values.',
    'present_with_all' => 'حقل :attribute يجب أن يكون موجودًا عند وجود جميع القيم: :values.',
    'prohibited' => 'حقل :attribute غير مسموح به.',
    'prohibited_if' => 'حقل :attribute غير مسموح به عندما تكون :other هي :value.',
    'prohibited_unless' => 'حقل :attribute غير مسموح به ما لم تكن :other ضمن :values.',
    'prohibits' => 'حقل :attribute يمنع وجود :other.',
    'regex' => 'صيغة :attribute غير صحيحة.',
    'required' => 'حقل :attribute مطلوب.',
    'required_array_keys' => 'حقل :attribute يجب أن يحتوي على المفاتيح: :values.',
    'required_if' => 'حقل :attribute مطلوب عندما تكون :other هي :value.',
    'required_if_accepted' => 'حقل :attribute مطلوب عندما تكون :other مقبولة.',
    'required_if_declined' => 'حقل :attribute مطلوب عندما تكون :other مرفوضة.',
    'required_unless' => 'حقل :attribute مطلوب ما لم تكن :other ضمن :values.',
    'required_with' => 'حقل :attribute مطلوب عند وجود :values.',
    'required_with_all' => 'حقل :attribute مطلوب عند وجود جميع القيم: :values.',
    'required_without' => 'حقل :attribute مطلوب عند عدم وجود :values.',
    'required_without_all' => 'حقل :attribute مطلوب عند عدم وجود جميع القيم: :values.',
    'same' => 'حقل :attribute يجب أن يطابق :other.',
    'size' => [
        'array' => 'حقل :attribute يجب أن يحتوي على :size من العناصر.',
        'file' => 'حجم ملف :attribute يجب أن يكون :size كيلوبايت.',
        'numeric' => 'قيمة :attribute يجب أن تكون :size.',
        'string' => 'حقل :attribute يجب أن يحتوي على :size أحرف.',
    ],
    'starts_with' => 'حقل :attribute يجب أن يبدأ بأحد القيم التالية: :values.',
    'string' => 'حقل :attribute يجب أن يكون نصًا.',
    'timezone' => 'حقل :attribute يجب أن يكون منطقة زمنية صحيحة.',
    'unique' => ':attribute مستخدم بالفعل.',
    'uploaded' => 'فشل رفع :attribute.',
    'uppercase' => 'حقل :attribute يجب أن يكون بأحرف كبيرة.',
    'url' => 'حقل :attribute يجب أن يكون رابطًا صحيحًا.',
    'ulid' => 'حقل :attribute يجب أن يكون ULID صالحًا.',
    'uuid' => 'حقل :attribute يجب أن يكون UUID صالحًا.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'custom' => [
        // أضف هنا رسائل مخصصة لأي حقل وقاعدة معينة عند الحاجة.
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | هنا أسماء الحقول التي ستظهر للمستخدم بدل أسماء الحقول البرمجية.
    |
    */

    'attributes' => [

        // بيانات الحساب
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',
        'current_password' => 'كلمة المرور الحالية',

        // بيانات الطبيب
        'doctor_name' => 'اسم الطبيب',
        'doctor_image' => 'صورة الطبيب',
        'specialty_id' => 'التخصص',
        'area_id' => 'المنطقة',
        'bio' => 'نبذة عن الطبيب',
        'services' => 'الخدمات',
        'clinic_images' => 'صور العيادة',
        'clinic_images.*' => 'صورة العيادة',

        // بيانات التواصل
        'phone' => 'رقم الهاتف',
        'mobile' => 'رقم الهاتف',
        'address' => 'العنوان',
        'location' => 'الموقع',
        'latitude' => 'خط العرض',
        'longitude' => 'خط الطول',

        // بيانات المريض
        'patient_id' => 'المريض',
        'patient_name' => 'اسم المريض',
        'birth_date' => 'تاريخ الميلاد',
        'gender' => 'النوع',
        'national_id' => 'الرقم القومي',

        // الحجوزات
        'appointment_date' => 'تاريخ الموعد',
        'start_time' => 'وقت بداية الموعد',
        'booking_type' => 'نوع الحجز',
        'status' => 'الحالة',
        'price' => 'السعر',
        'paid' => 'المبلغ المدفوع',
        'service_id' => 'الخدمة',
        'service' => 'الخدمة',

        // الزيارات
        'complaint' => 'الشكوى',
        'diagnosis' => 'التشخيص',
        'notes' => 'الملاحظات',
        'next_visit_date' => 'موعد المتابعة',
        'visit_date' => 'تاريخ الزيارة',
        'treatment' => 'العلاج',

        // الروشتات
        'medication' => 'الدواء',
        'medications' => 'الأدوية',
        'dosage' => 'الجرعة',
        'frequency' => 'عدد مرات الاستخدام',
        'duration' => 'مدة العلاج',
        'instructions' => 'التعليمات',

        // المواعيد والجدول
        'day_of_week' => 'يوم الأسبوع',
        'start' => 'وقت البداية',
        'end' => 'وقت النهاية',
        'start_at' => 'وقت البداية',
        'end_at' => 'وقت النهاية',
        'slot_duration' => 'مدة الموعد',

        // المساعدين
        'assistant_id' => 'المساعد',
        'assistant_name' => 'اسم المساعد',

        // الملفات
        'file' => 'الملف',
        'document' => 'المستند',
        'documents' => 'المستندات',

        // الرسائل
        'message' => 'الرسالة',
        'subject' => 'الموضوع',
        'title' => 'العنوان',

        // الاشتراكات
        'plan_id' => 'الباقة',
        'start_date' => 'تاريخ البداية',
        'end_date' => 'تاريخ النهاية',

    ],

];

