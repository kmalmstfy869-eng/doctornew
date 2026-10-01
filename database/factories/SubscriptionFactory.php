<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        $plan = Plan::inRandomOrder()->first();

        $startDate = fake()->dateTimeBetween('-6 months', 'now');

        $endDate = $plan->duration > 0
            ? (clone $startDate)->modify("+{$plan->duration} days")
            : null;

        return [
            'doctor_id' => null,

            'plan_id' => $plan->id,

            'start_date' => $startDate->format('Y-m-d'),

            'end_date' => $endDate?->format('Y-m-d'),

            'status' => 'active',

            'price' => $plan->price,
        ];
    }
}
