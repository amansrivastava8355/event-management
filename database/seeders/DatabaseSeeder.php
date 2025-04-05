<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Attendee;
use App\Models\Booking;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $users = User::factory(5)->create();

        // For each user, create 3-5 events
        $users->each(function ($user) {
            $events = Event::factory(rand(3, 5))->create([
                'capacity' => rand(20, 100), // Ensure sufficient capacity
            ]);

            // For each event, create attendees and bookings
            $events->each(function ($event) {
                // Create 15-30 attendees
                $attendees = Attendee::factory(rand(15, 30))->create();

                // Create bookings for 50-80% of attendees
                $attendees->random(rand(
                    ceil($attendees->count() * 0.5),
                    ceil($attendees->count() * 0.8)
                ))->each(function ($attendee) use ($event) {
                    Booking::create([
                        'event_id' => $event->id,
                        'attendee_id' => $attendee->id,
                    ]);
                });
            });
        });

        // Create some additional unassociated attendees
        Attendee::factory(20)->create();
    }
}
