<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ListingController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);
    });

    Route::get('/listings', [ListingController::class, 'index']);
    Route::get('/listings/{listing}', [ListingController::class, 'show'])->whereNumber('listing');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/listings/{listing}/bookings', [BookingController::class, 'store']);
    Route::get('/trips', [BookingController::class, 'trips']);
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel']);
});
