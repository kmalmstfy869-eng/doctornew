<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Subscription;
use Illuminate\Database\Seeder;

class SubscriptionsSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = Doctor::all();

        foreach ($doctors as $doctor) {

            Subscription::factory()->create([
                'doctor_id' => $doctor->id,
            ]);

        }
    }
}
