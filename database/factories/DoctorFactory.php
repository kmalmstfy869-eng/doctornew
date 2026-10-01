<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\Doctor;
use App\Models\Specialties;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition(): array
    {
        return [

            'user_id' => User::factory(),

            'specialty_id' => Specialties::inRandomOrder()->value('id'),

            'area_id' => Area::inRandomOrder()->value('id'),

            'phone' => '01' . fake()->numerify('#########'),

            'whatsapp' => '01' . fake()->numerify('#########'),

            /*
            |--------------------------------------------------------------------------
            | Medical Services
            |--------------------------------------------------------------------------
            */

            'services' => collect([
                'تشخيص الحالات المرضية',
                'الفحص الطبي الشامل',
                'متابعة الحالات المزمنة',
                'متابعة ضغط الدم',
                'متابعة مرضى السكري',
                'رسم القلب',
                'الإشاعات والفحوصات الطبية',
                'متابعة العلاج',
                'الكشف الطبي',
                'الاستشارات الطبية',
            ])->random(4)->values()->toArray(),

            /*
            |--------------------------------------------------------------------------
            | Doctor Information
            |--------------------------------------------------------------------------
            */

            'consultation_price' => fake()->randomElement([
                200,
                250,
                300,
                350,
                400,
                500,
            ]),

            'experience' => fake()->randomElement([
                2,
                5,
                10,
                13,
                15,
                20,
                25,
                30,
            ]),

            'clinic_name' => fake()->company() . ' Clinic',

            'address' => fake()->address(),

            'google_maps_url' =>
                'https://maps.google.com/?q=' .
                fake()->latitude() . ',' .
                fake()->longitude(),

            'working_hours' => 'السبت - الخميس: 5م - 10م',

            'bio' => fake()->realText(200),

            'doctor_image' => null,

            'clinic_images' => null,



            /*
            |--------------------------------------------------------------------------
            | Approval Status
            |--------------------------------------------------------------------------
            */

            'status' => 'pending',

        ];
    }
}
