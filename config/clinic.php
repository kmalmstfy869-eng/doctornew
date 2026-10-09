<?php

return [
    // حد مساحة ملفات المرضى لكل دكتور بالـ GB. رقم ثابت في الـ config، مش باقة ولا اشتراك.
    'patient_files_storage_gb' => (float) env('CLINIC_PATIENT_FILES_STORAGE_GB', 25),

    // أقصى حجم للملف الواحد بالـ MB.
    'patient_files_max_file_mb' => (int) env('CLINIC_PATIENT_FILE_MAX_MB', 25),

    // مدة الاحتفاظ بالنسخة الاحتياطية بعد حذف الملف من الـ Primary.
    'patient_files_backup_retention_days' => (int) env('CLINIC_PATIENT_FILES_BACKUP_RETENTION_DAYS', 30),

    // أسماء الـ Disks. الكود كله بيتعامل معاهم بالاسم بس، فتغيير التخزين بيتم من filesystems.php و.env.
    'patient_files_disk' => 'medical_files',
    'patient_files_backup_disk' => 'medical_files_backup',
        // سعر وحجم الزيادة الإضافية للمساحة (بيظهروا في إعلان الزيادة).
    'extra_storage_gb' => 25,
    'extra_storage_price' => 100,
    // نسبة الاستهلاك اللي بعدها الطبيب يتحسب "قرب من الحد" في لوحة الأدمن.
    'patient_files_near_limit_percent' => 90,
];
