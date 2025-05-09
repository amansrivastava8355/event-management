<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\AttendeeController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\BookController;

Route::apiResource('events', EventController::class);
Route::apiResource('attendees', AttendeeController::class)->only(['store','index']);
Route::post('bookings', [BookingController::class, 'store']);
// if we enable so we can generate token Authentication
Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!auth()->attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    return response()->json([
        'token' => $request->user()->createToken('api')->plainTextToken
    ]);
});

Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index']);   
    Route::get('/{id}', [BookController::class, 'show']);     
    Route::post('/', [BookController::class, 'store']);       
    Route::put('/{id}', [BookController::class, 'update']);  
});