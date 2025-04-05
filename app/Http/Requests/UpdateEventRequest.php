<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateEventRequest",
 *     @OA\Property(property="title", type="string", example="Updated Title"),
 *     @OA\Property(property="description", type="string", example="Updated description"),
 *     @OA\Property(property="location", type="string", example="Canada"),
 *     @OA\Property(property="start_time", type="string", format="date-time", example="2025-04-20T10:00:00Z"),
 *     @OA\Property(property="end_time", type="string", format="date-time", example="2025-04-20T12:00:00Z"),
 *     @OA\Property(property="capacity", type="integer", example=150)
 * )
 */
class UpdateEventRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'sometimes|date|after:now',
            'end_time' => 'sometimes|date|after:start_time',
            'location' => 'sometimes|string|size:2',
            'capacity' => 'sometimes|integer|min:1|max:10000',
        ];
    }
}