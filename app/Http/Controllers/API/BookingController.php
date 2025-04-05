<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Tag(name="Bookings")
 *
 * @OA\Schema(
 *     schema="StoreBookingRequest",
 *     required={"event_id", "attendee_id"},
 *     @OA\Property(property="event_id", type="integer", example=1),
 *     @OA\Property(property="attendee_id", type="integer", example=5),
 *     @OA\Property(property="notes", type="string", example="Front row seat requested")
 * )
 *
 * @OA\Schema(
 *     schema="BookingResource",
 *     @OA\Property(property="id", type="integer", example=10),
 *     @OA\Property(property="event_id", type="integer", example=1),
 *     @OA\Property(property="attendee_id", type="integer", example=5),
 *     @OA\Property(property="notes", type="string", example="Front row seat requested"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(
 *         property="event",
 *         type="object",
 *         ref="#/components/schemas/EventResource"
 *     ),
 *     @OA\Property(
 *         property="attendee",
 *         type="object",
 *         ref="#/components/schemas/AttendeeResource"
 *     )
 * )
 */
class BookingController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/bookings",
     *     summary="Create booking",
     *     tags={"Bookings"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreBookingRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(ref="#/components/schemas/BookingResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function store(StoreBookingRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $event = Event::findOrFail($request->event_id);
            $attendee = Attendee::findOrFail($request->attendee_id);

            if ($event->bookings()->count() >= $event->capacity) {
                return response()->json([
                    'error' => ['message' => 'Event is fully booked', 'code' => 422]
                ], 422);
            }

            $booking = Booking::firstOrCreate(
                ['event_id' => $event->id, 'attendee_id' => $attendee->id],
                $request->validated()
            );

            DB::commit();

            return (new BookingResource($booking->load(['event', 'attendee'])))
                ->response()
                ->setStatusCode(201);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->handleError($e, 'Booking failed');
        }
    }

    private function handleError(\Exception $e, string $message): JsonResponse
    {
        return response()->json([
            'error' => [
                'message' => $message,
                'details' => $e->getMessage(),
                'code' => 500
            ]
        ], 500);
    }
}
