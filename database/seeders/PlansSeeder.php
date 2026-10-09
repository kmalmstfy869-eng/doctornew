<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansSeeder extends Seeder
{
    public function run(): void
    {
        $free = [
            'اسم الطبيب',
            'التخصص',
            'الموقع',
            'سعر الكشف',
            'رقم التواصل',
            'مواعيد العمل',
        ];

        $prime = [
            'صورتك الشخصية وشارة طبيب موثوق',
            'تقارير مشاهدات ملفك: شارت تفصيلي على مدار الأيام والأسابيع والشهور',
            'الخدمات الطبية',
            'صور العيادة',
            'موقع العيادة على Google Maps',
            'التقييمات',
            'ظهور أفضل في نتائج البحث',
        ];
        $professional = [
            'كل مميزات Prime',
            'حجز المواعيد أونلاين',
            'إدارة الحجوزات أونلاين وأوفلاين',
        ];

        $clinic = [
            'كل مميزات Professional',
            'إدارة المرضى',
            'متابعة الدخل والمصروفات',
            'تقارير العيادة',
            'تقارير المصروفات',
            'إضافة سكرتيرة',
            'طباعة الروشتات',
            'إدارة العيادة بالكامل',
        ];

        $primeDesc = 'ظهور أفضل لملفك، ومعلومات أكثر عن عيادتك، وإحصائيات مشاهدات ملفك.';
        $professionalDesc = ' ظهور أقوى مع الحجز أونلاين و أوفلاين.';
        $clinicDesc = 'نظام متكامل لإدارة العيادة.';

        $plans = [

            // ===== FREE =====
            ['Free', 'free', 0, 0, 'عرض البيانات الأساسية للطبيب.', $free, 9],

            // ===== PRIME =====
            ['Prime', 'prime-monthly', 199, 30, $primeDesc, $prime, 8],
            ['Prime', 'prime-3-months', 549, 90, $primeDesc, $prime, 6],
            ['Prime', 'prime-yearly', 1999, 365, $primeDesc, $prime, 3],

            // ===== PROFESSIONAL =====
            ['Professional', 'professional-monthly', 399, 30, $professionalDesc, $professional, 7],
            ['Professional', 'professional-3-months', 1099, 90, $professionalDesc, $professional, 4],
            ['Professional', 'professional-yearly', 3799, 365, $professionalDesc, $professional, 1],

            // ===== CLINIC SYSTEM =====
            ['Clinic System', 'clinic-system-monthly', 799, 30, $clinicDesc, $clinic, 5],
            ['Clinic System', 'clinic-system-3-months', 2199, 90, $clinicDesc, $clinic, 2],
            ['Clinic System', 'clinic-system-yearly', 7499, 365, $clinicDesc, $clinic, 0],
        ];

        foreach ($plans as [$name, $slug, $price, $duration, $description, $features, $order]) {
            Plan::updateOrCreate(
                ['slug' => $slug],
                [
                    'name'        => $name,
                    'price'       => $price,
                    'description' => $description,
                    'duration'    => $duration,
                    'features'    => $features,
                    'sort_order'  => $order,
                ]
            );
        }
    }
}
