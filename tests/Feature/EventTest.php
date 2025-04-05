<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_event()
    {
        $user = User::factory()->create();
        $eventData = [
            'title' => 'Tech Conference',
            'description' => 'Annual tech event',
            'start_time' => now()->addDay()->toDateTimeString(),
            'end_time' => now()->addDays(2)->toDateTimeString(),
            'location' => 'US',
            'capacity' => 100
        ];

        $event = Event::create($eventData);

        $this->assertDatabaseHas('events', ['title' => 'Tech Conference']);
        $this->assertEquals('US', $event->location);
    }

    /** @test */
    public function prevents_past_start_time()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/events', [
            'title' => 'Invalid Event',
            'start_time' => now()->subDay()->toDateTimeString(),
            'end_time' => now()->addDay()->toDateTimeString(),
            'location' => 'UK',
            'capacity' => 50,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['start_time']);
    }
    /** @test */
    public function calculates_available_seats()
    {
        $event = Event::factory()->create(['capacity' => 100]);
        $this->assertEquals(100, $event->availableSeats());

        // Create 30 bookings
        \App\Models\Booking::factory()->count(30)->create(['event_id' => $event->id]);
        
        $this->assertEquals(70, $event->fresh()->availableSeats());
    }
}