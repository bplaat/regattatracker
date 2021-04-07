<?php

use App\Http\Controllers\Api\ApiAuthController;

use App\Http\Controllers\Api\ApiBoatsController;
use App\Http\Controllers\Api\ApiBoatPositionsController;
use App\Http\Controllers\Api\ApiBoatBoatTypesController;
use App\Http\Controllers\Api\ApiBoatUsersController;

use App\Http\Controllers\Api\ApiBuoysController;
use App\Http\Controllers\Api\ApiBuoyPositionsController;

use Illuminate\Support\Facades\Route;

// API home route
Route::get('', function () {
    return [
        'message' => 'RegattaTracker API documentation: https://bit.ly/3kKfgzH'
    ];
});

// Verify API key
Route::middleware('api_key')->group(function () {
    // Normal routes
    Route::middleware('auth:sanctum')->group(function () {
        // API boat routes
        Route::get('boats', [ApiBoatsController::class, 'index']);
        Route::get('boats/{boat}', [ApiBoatsController::class, 'show']);
        Route::get('boats/{boat}/positions', [ApiBoatPositionsController::class, 'index']);
        Route::post('boats/{boat}/positions', [ApiBoatPositionsController::class, 'store']);
        Route::get('boats/{boat}/boat_types', [ApiBoatBoatTypesController::class, 'index']);
        Route::get('boats/{boat}/users', [ApiBoatUsersController::class, 'index']);

        // API buoy routes
        Route::get('buoys', [ApiBuoysController::class, 'index']);
        Route::get('buoys/{buoy}', [ApiBuoysController::class, 'show']);
        Route::get('buoys/{buoy}/positions', [ApiBuoyPositionsController::class, 'index']);
        Route::post('buoys/{buoy}/positions', [ApiBuoyPositionsController::class, 'store']);

        // API auth routes
        Route::get('auth/logout', [ApiAuthController::class, 'logout']);
    });

    // API auth routes
    Route::any('auth/login', [ApiAuthController::class, 'login']);
    Route::any('auth/register', [ApiAuthController::class, 'register']);
});
