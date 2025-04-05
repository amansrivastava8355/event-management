<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'start_time' => fake()->dateTimeBetween('+1 week', '+1 month'),
            'end_time' => fake()->dateTimeBetween('+2 months', '+3 months'),
            'location' => fake()->countryCode(),
            'capacity' => fake()->numberBetween(50, 200),
        ];
    }
}