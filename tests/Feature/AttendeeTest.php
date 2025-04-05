<?php

namespace Tests\Feature;

use App\Models\Attendee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Event;
use App\Models\Booking;

class AttendeeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_register_attendee()
    {
        $attendee = Attendee::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+1234567890'
        ]);

        $this->assertDatabaseHas('attendees', ['email' => 'john@example.com']);
    }

    /** @test */
    public function prevents_duplicate_emails()
    {
        Attendee::create([
            'name' => 'First User',
            'email' => 'duplicate@example.com'
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Attendee::create([
            'name' => 'Second User',
            'email' => 'duplicate@example.com'
        ]);
    }

    /** @test */
    public function can_have_multiple_bookings()
    {
        $attendee = Attendee::factory()->create();
        $events = Event::factory()->count(3)->create();

        foreach ($events as $event) {
            Booking::create([
                'event_id' => $event->id,
                'attendee_id' => $attendee->id
            ]);
        }

        $this->assertCount(3, $attendee->bookings);
    }
}