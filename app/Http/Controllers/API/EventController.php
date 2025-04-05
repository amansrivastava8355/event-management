<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(name="Events")
 *
 * @OA\Schema(
 *     schema="EventResource",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Tech Meetup"),
 *     @OA\Property(property="description", type="string", example="An event for tech enthusiasts"),
 *     @OA\Property(property="location", type="string", example="US"),
 *     @OA\Property(property="start_time", type="string", format="date-time", example="2025-04-15T10:00:00Z"),
 *     @OA\Property(property="end_time", type="string", format="date-time", example="2025-04-15T12:00:00Z"),
 *     @OA\Property(property="capacity", type="integer", example=100),
 *     @OA\Property(property="available_seats", type="integer", example=85),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class EventController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/events",
     *     summary="List all events",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/EventResource")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $events = Event::paginate(10);
            return EventResource::collection($events)->response();
        } catch (\Exception $e) {
            return $this->handleError($e, 'Failed to retrieve events');
        }
    }

    /**
     * @OA\Post(
     *     path="/api/events",
     *     summary="Create new event",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreEventRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created",
     *         @OA\JsonContent(ref="#/components/schemas/EventResource")
     *     )
     * )
     */
    public function store(StoreEventRequest $request): JsonResponse
    {
        try {
            $event = Event::create($request->validated());
            return (new EventResource($event))->response()->setStatusCode(201);
        } catch (\Exception $e) {
            return $this->handleError($e, 'Event creation failed');
        }
    }

    /**
     * @OA\Get(
     *     path="/api/events/{id}",
     *     summary="Get event details",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/EventResource")
     *     )
     * )
     */
    public function show(Event $event): JsonResponse
    {
        try {
            return (new EventResource($event))->response();
        } catch (\Exception $e) {
            return $this->handleError($e, 'Failed to retrieve event');
        }
    }

    /**
     * @OA\Put(
     *     path="/api/events/{id}",
     *     summary="Update event",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateEventRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Updated",
     *         @OA\JsonContent(ref="#/components/schemas/EventResource")
     *     )
     * )
     */
    public function update(UpdateEventRequest $request, Event $event): JsonResponse
    {
        try {
            $event->update($request->validated());
            return (new EventResource($event))->response();
        } catch (\Exception $e) {
            return $this->handleError($e, 'Event update failed');
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/events/{id}",
     *     summary="Delete event",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Deleted")
     * )
     */
    public function destroy(Event $event): JsonResponse
    {
        try {
            $event->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return $this->handleError($e, 'Event deletion failed');
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