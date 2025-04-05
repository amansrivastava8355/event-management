<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttendeeRequest;
use App\Http\Resources\AttendeeResource;
use App\Models\Attendee;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Attendees",
 *     description="Attendee registration management"
 * )
 * 
 * @OA\Schema(
 *     schema="StoreAttendeeRequest",
 *     required={"name", "email"},
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="phone", type="string", example="+1234567890")
 * )
 * 
 * @OA\Schema(
 *     schema="AttendeeResource",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", example="john@example.com"),
 *     @OA\Property(property="phone", type="string", example="+1234567890"),
 *     @OA\Property(property="registered_at", type="string", format="date-time")
 * )
 */
class AttendeeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/attendees",
     *     summary="List all attendees",
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
            $events = Attendee::paginate(10);
            return AttendeeResource::collection($events)->response();
        } catch (\Exception $e) {
            return $this->handleError($e, 'Failed to retrieve events');
        }
    }
    /**
     * @OA\Post(
     *     path="/api/attendees",
     *     summary="Register attendee",
     *     @OA\RequestBody(@OA\JsonContent(ref="#/components/schemas/StoreAttendeeRequest")),
     *     @OA\Response(response=201, description="Created", @OA\JsonContent(ref="#/components/schemas/AttendeeResource"))
     * )
     */
    public function store(StoreAttendeeRequest $request): JsonResponse
    {
        try {
            $attendee = Attendee::create($request->validated());
            return (new AttendeeResource($attendee))->response()->setStatusCode(201);
        } catch (\Exception $e) {
            return $this->handleError($e, 'Attendee registration failed');
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