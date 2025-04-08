<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

abstract class BaseApiController extends Controller
{
    /**
     * Handle errors and return a JSON response.
     *
     * @param \Exception $e
     * @param string $message
     * @return JsonResponse
     */
    protected function handleError(\Exception $e, string $message): JsonResponse
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
