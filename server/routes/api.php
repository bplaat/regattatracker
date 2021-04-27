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

// Verify API key with auth token check
Route::middleware('api_key')->group(function () {
    // API boat routes
    Route::get('boats', [ApiBoatsController::class, 'index']);
    Route::get('boats/{boat}', [ApiBoatsController::class, 'show']);

    Route::get('boats/{boat}/positions', [ApiBoatPositionsController::class, 'index']);
    Route::post('boats/{boat}/positions', [ApiBoatPositionsController::class, 'store'])->name('api.boats.positions.store');
    Route::get('boats/{boat}/positions/{boatPosition}/delete', [ApiBoatPositionsController::class, 'delete']);
    Route::get('boats/{boat}/positions/{boatPosition}', [ApiBoatPositionsController::class, 'show']);
    Route::post('boats/{boat}/positions/{boatPosition}', [ApiBoatPositionsController::class, 'update']);

    Route::get('boats/{boat}/boat_types', [ApiBoatBoatTypesController::class, 'index']);
    Route::get('boats/{boat}/users', [ApiBoatUsersController::class, 'index']);

    // API buoy routes
    Route::get('buoys', [ApiBuoysController::class, 'index']);
    Route::get('buoys/{buoy}', [ApiBuoysController::class, 'show']);

    Route::get('buoys/{buoy}/positions', [ApiBuoyPositionsController::class, 'index']);
    Route::post('buoys/{buoy}/positions', [ApiBuoyPositionsController::class, 'store'])->name('api.buoys.positions.store');
    Route::get('buoys/{buoy}/positions/{buoyPosition}/delete', [ApiBuoyPositionsController::class, 'delete']);
    Route::get('buoys/{buoy}/positions/{buoyPosition}', [ApiBuoyPositionsController::class, 'show']);
    Route::post('buoys/{buoy}/positions/{buoyPosition}', [ApiBuoyPositionsController::class, 'update']);

    // API auth routes
    Route::get('auth/logout', [ApiAuthController::class, 'logout']);
});

// Verify API key without auth token check
Route::middleware('api_key:false')->group(function () {
    // API auth routes
    Route::any('auth/login', [ApiAuthController::class, 'login']);
    Route::any('auth/register', [ApiAuthController::class, 'register']);
});
