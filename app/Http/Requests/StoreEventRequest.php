<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreEventRequest",
 *     required={"title", "description", "location", "start_time", "end_time", "capacity"},
 *     @OA\Property(property="title", type="string", example="Tech Meetup"),
 *     @OA\Property(property="description", type="string", example="An event for tech enthusiasts"),
 *     @OA\Property(property="location", type="string", example="US"),
 *     @OA\Property(property="start_time", type="string", format="date-time", example="2025-04-15T10:00:00Z"),
 *     @OA\Property(property="end_time", type="string", format="date-time", example="2025-04-15T12:00:00Z"),
 *     @OA\Property(property="capacity", type="integer", example=100)
 * )
 */
class StoreEventRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|size:2',
            'capacity' => 'required|integer|min:1|max:10000',
        ];
    }
}