<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition(): array
    {
        return [

            'user_id' => User::inRandomOrder()->first()->id,

            'title' => fake()->randomElement([
                'مطور Laravel',
                'طبيب أسنان',
                'ممرض',
                'موظف استقبال',
                'صيدلي',
                'سكرتير طبي',
                'مساعد طبيب',
            ]),

            'company_name' => fake()->company(),

            'phone' => '010' . fake()->numerify('########'),

            'whatsapp' => '2010' . fake()->numerify('########'),

            'category' => fake()->randomElement([
                'برمجة وتقنية',
                'تمريض',
                'صيدلة',
                'طب',
                'إدارة',
                'استقبال',
            ]),

            'qualification' => fake()->randomElement([
                'بكالوريوس طب',
                'بكالوريوس تمريض',
                'بكالوريوس صيدلة',
                'مؤهل متوسط',
                'مؤهل عالي',
                'خريج طب',
            ]),

            'location' => fake()->randomElement([
                'القاهرة - التجمع الخامس',
                'الإسكندرية',
                'دمنهور',
                'الجيزة',
                'مدينة نصر',
                'المنصورة',
            ]),

            'job_type' => fake()->randomElement([
                'دوام كامل',
                'دوام جزئي',
                'العمل عن بعد',
            ]),

            'experience' => fake()->randomElement([
                'أقل من سنة',
                'من سنة إلى 3 سنوات',
                'من 3 إلى 5 سنوات',
                'أكثر من 5 سنوات',
            ]),

            'salary_min' => fake()->numberBetween(5000, 15000),

            'salary_max' => fake()->numberBetween(16000, 30000),

            'description' => fake()->paragraph(4),

            'vacancies' => fake()->numberBetween(1, 5),

            'working_hours' => fake()->randomElement([
                '8 ساعات يوميًا',
                '7 ساعات يوميًا',
                '6 ساعات يوميًا',
            ]),

            'working_days' => fake()->randomElement([
                'من الأحد إلى الخميس',
                'من السبت إلى الخميس',
                'من الأحد إلى الجمعة',
            ]),

            'application_deadline' => fake()
                ->dateTimeBetween('now', '+30 days')
                ->format('Y-m-d'),

            'status' => fake()->randomElement([
                'pending',
                'approved',
                'rejected',
            ]),

        ];
    }
}
