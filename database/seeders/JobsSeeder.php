<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;

class JobSSeeder extends Seeder
{
    public function run(): void
    {
        Job::factory(20)->create();
    }
}
