<?php

namespace App\Http\Controllers\API;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Event Booking API",
 *         description="API Documentation for Event Booking System",
 *         @OA\Contact(
 *             email="amansrivastava8355@gmail.com"
 *         ),
 *         @OA\License(
 *             name="MIT",
 *             url="https://opensource.org/licenses/MIT"
 *         )
 *     ),
 *     @OA\Server(
 *         url=L5_SWAGGER_CONST_HOST,
 *         description="API Server"
 *     ),
 *     @OA\Tag(
 *         name="Events",
 *         description="Event management"
 *     ),
 *     @OA\Tag(
 *         name="Attendees",
 *         description="Attendee registration"
 *     ),
 *     @OA\Tag(
 *         name="Bookings",
 *         description="Booking management"
 *     ),
 *     @OA\Components(
 *         @OA\SecurityScheme(
 *             securityScheme="bearerAuth",
 *             type="http",
 *             scheme="bearer",
 *             bearerFormat="JWT"
 *         )
 *     )
 * )
 */
class SwaggerController
{
    // Just holds Swagger annotations
}
