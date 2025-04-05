<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Event;
use App\Models\Booking;

class StoreBookingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'event_id' => [
                'required',
                'exists:events,id',
                function ($attribute, $value, $fail) {
                    $event = Event::find($value);
                    
                    if (!$event) {
                        return $fail('The selected event does not exist.');
                    }
    
                    if ($event->bookings()->count() >= $event->capacity) {
                        $fail('This event is fully booked.');
                    }
                },
            ],
            'attendee_id' => 'required|exists:attendees,id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (Booking::where('event_id', $this->event_id)
                ->where('attendee_id', $this->attendee_id)
                ->exists()
            ) {
                $validator->errors()->add('booking', 'This attendee is already registered for the event.');
            }
        });
    }
}