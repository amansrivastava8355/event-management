<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'attendee_id' => Attendee::factory(),
        ];
    }
}