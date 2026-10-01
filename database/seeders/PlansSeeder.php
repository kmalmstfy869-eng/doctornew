<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [

            // =========================
            // FREE
            // =========================

            [
                'name' => 'Free',
                'slug' => 'free',
                'price' => 0,
                'description' => 'عرض البيانات الأساسية للطبيب.',
                'duration' => 0,
                'features' => [
                    'اسم الطبيب',
                    'التخصص',
                    'الموقع',
                    'سعر الكشف',
                    'رقم التواصل',
                    'مواعيد العمل',
                ],
"sort_order"=>99,
            ],

            // =========================
            // PRIME - شهر
            // =========================

            [
                'name' => 'Prime',
                'slug' => 'prime-monthly',
                'price' => 300,
                'description' => 'ظهور أفضل ومعلومات أكثر عن الطبيب والعيادة.',
                'duration' => 30,
                'features' => [
                    'كل مميزات الباقة المجانية',
                    'صورة الطبيب',
                    'صور العيادة',
                    'نبذة عن الطبيب',
                    'موقع العيادة على Google Maps',
                    'ظهور أفضل في نتائج البحث',
                ],
"sort_order"=>6,
            ],

            // =========================
            // PRIME - 3 شهور
            // =========================

            [
                'name' => 'Prime',
                'slug' => 'prime-3-months',
                'price' => 800,
                'description' => 'ظهور أفضل ومعلومات أكثر عن الطبيب والعيادة.',
                'duration' => 90,
                'features' => [
                    'كل مميزات الباقة المجانية',
                    'صورة الطبيب',
                    'صور العيادة',
                    'نبذة عن الطبيب',
                    'موقع العيادة على Google Maps',
                    'ظهور أفضل في نتائج البحث',
                ],

                "sort_order"=>5,
            ],
            // =========================
            // PRIME - سنة
            // =========================

            [
                'name' => 'Prime',
                'slug' => 'prime-yearly',
                'price' => 2800,
                'description' => 'ظهور أفضل ومعلومات أكثر عن الطبيب والعيادة.',
                'duration' => 365,
                'features' => [
                    'كل مميزات الباقة المجانية',
                    'صورة الطبيب',
                    'صور العيادة',
                    'نبذة عن الطبيب',
                    'موقع العيادة على Google Maps',
                    'ظهور أفضل في نتائج البحث',
                ],

                "sort_order"=>4,
            ],
            // =========================
            // PROFESSIONAL - شهر
            // =========================

            [
                'name' => 'Professional',
                'slug' => 'professional-monthly',
                'price' => 600,
                'description' => 'إدارة الحجوزات واستقبال الحجوزات أونلاين.',
                'duration' => 30,
                'features' => [
                    'كل مميزات Prime',
                    'الحجز أونلاين',
                    'إدارة الحجوزات',
                ],

                "sort_order"=>3,
            ],
            // =========================
            // PROFESSIONAL - 3 شهور
            // =========================

            [
                'name' => 'Professional',
                'slug' => 'professional-3-months',
                'price' => 1600,
                'description' => 'إدارة الحجوزات واستقبال الحجوزات أونلاين.',
                'duration' => 90,
                'features' => [
                    'كل مميزات Prime',
                    'الحجز أونلاين',
                    'إدارة الحجوزات',
                ],
"sort_order"=>2,
            ],

            // =========================
            // PROFESSIONAL - سنة
            // =========================

            [
                'name' => 'Professional',
                'slug' => 'professional-yearly',
                'price' => 5500,
                'description' => 'إدارة الحجوزات واستقبال الحجوزات أونلاين.',
                'duration' => 365,
                'features' => [
                    'كل مميزات Prime',
                    'الحجز أونلاين',
                    'إدارة الحجوزات',
                ],
"sort_order"=>2,
            ],

            // =========================
            // CLINIC SYSTEM - شهر
            // =========================

            [
                'name' => 'Clinic System',
                'slug' => 'clinic-system-monthly',
                'price' => 1200,
                'description' => 'نظام متكامل لإدارة العيادة.',
                'duration' => 30,
                'features' => [
                    'كل مميزات Professional',
                    'إدارة الحجوزات أوفلاين',
                    'إدارة العملاء',
                    'إدارة الدخل',
                    'إدارة العيادة',
                ],
"sort_order"=>1,
            ],

            // =========================
            // CLINIC SYSTEM - 3 شهور
            // =========================

            [
                'name' => 'Clinic System',
                'slug' => 'clinic-system-3-months',
                'price' => 3200,
                'description' => 'نظام متكامل لإدارة العيادة.',
                'duration' => 90,
                'features' => [
                    'كل مميزات Professional',
                    'إدارة الحجوزات أوفلاين',
                    'إدارة العملاء',
                    'إدارة الدخل',
                    'إدارة العيادة',
                ],
"sort_order"=>0,
            ],

            // =========================
            // CLINIC SYSTEM - سنة
            // =========================

            [
                'name' => 'Clinic System',
                'slug' => 'clinic-system-yearly',
                'price' => 11000,
                'description' => 'نظام متكامل لإدارة العيادة.',
                'duration' => 365,
                'features' => [
                    'كل مميزات Professional',
                    'إدارة الحجوزات أوفلاين',
                    'إدارة العملاء',
                    'إدارة الدخل',
                    'إدارة العيادة',
                ],

                "sort_order"=>1,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
