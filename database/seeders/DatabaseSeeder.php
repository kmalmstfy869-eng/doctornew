<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\SpecialtiesSeeder;
use Database\Seeders\PlansSeeder;
use Database\Seeders\AreasSeeder;
use Database\Seeders\DoctorsSeeder;
use Database\Seeders\RatingSeeder;
use Database\Seeders\SubscriptionsSeeder;
use Database\Seeders\JobsSeeder;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
        AreasSeeder::class,
        SpecialtiesSeeder::class,
        PlansSeeder::class,
        DoctorsSeeder::class,
        SubscriptionsSeeder::class,
        JobsSeeder::class,
    ]);
    }
}

