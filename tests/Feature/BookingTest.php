<?php

namespace Tests\Feature;

use App\Models\Attendee;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_booking()
    {
        $event = Event::factory()->create(['capacity' => 10]);
        $attendee = Attendee::factory()->create();

        $booking = Booking::create([
            'event_id' => $event->id,
            'attendee_id' => $attendee->id
        ]);

        $this->assertDatabaseHas('bookings', [
            'event_id' => $event->id,
            'attendee_id' => $attendee->id
        ]);
    }

    /** @test */
    public function prevents_overbooking()
    {
        $event = Event::factory()->create(['capacity' => 1]);
        $attendee1 = Attendee::factory()->create();
        $attendee2 = Attendee::factory()->create();

        // First booking via API
        $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'attendee_id' => $attendee1->id
        ])->assertCreated();

        // Second booking should return 422
        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'attendee_id' => $attendee2->id
        ]);

        $response->assertStatus(422)
         ->assertJsonPath('message', 'This event is fully booked.')
         ->assertJsonPath('errors.event_id.0', 'This event is fully booked.');
    }

    /** @test */
    public function prevents_duplicate_bookings()
    {
        $event = Event::factory()->create();
        $attendee = Attendee::factory()->create();

        Booking::create([
            'event_id' => $event->id,
            'attendee_id' => $attendee->id
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        
        // Duplicate booking
        Booking::create([
            'event_id' => $event->id,
            'attendee_id' => $attendee->id
        ]);
    }
}