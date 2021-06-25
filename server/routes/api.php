<?php

use App\Http\Controllers\Api\ApiAuthController;

use App\Http\Controllers\Api\ApiAISController;

use App\Http\Controllers\Api\ApiBoatsController;
use App\Http\Controllers\Api\ApiBoatPositionsController;
use App\Http\Controllers\Api\ApiBoatBoatTypesController;
use App\Http\Controllers\Api\ApiBoatUsersController;

use App\Http\Controllers\Api\ApiBuoysController;
use App\Http\Controllers\Api\ApiBuoyPositionsController;

use App\Http\Controllers\Api\ApiEventsController;
use App\Http\Controllers\Api\ApiEventFinishesController;
use App\Http\Controllers\Api\ApiEventClassesController;
use App\Http\Controllers\Api\ApiEventClassFleetsController;
use App\Http\Controllers\Api\ApiEventClassFleetBoatsController;															   

use Illuminate\Support\Facades\Route;

// API home route
Route::get('', function () {
    return [
        'message' => 'RegattaTracker API documentation: https://bit.ly/3kKfgzH'
    ];
})->name('api.home');

// Verify API key with auth token check
Route::middleware('api_key')->group(function () {
    // API boat routes
    Route::get('boats', [ApiBoatsController::class, 'index'])->name('api.boats.index');
    Route::get('boats/{boat}', [ApiBoatsController::class, 'show'])->name('api.boats.show');

    Route::get('boats/{boat}/positions', [ApiBoatPositionsController::class, 'index'])->name('api.boats.positions.index');
    Route::post('boats/{boat}/positions', [ApiBoatPositionsController::class, 'store'])->name('api.boats.positions.store');
    Route::get('boats/{boat}/positions/{boatPosition}', [ApiBoatPositionsController::class, 'show'])->name('api.boats.positions.show');
    Route::post('boats/{boat}/positions/{boatPosition}', [ApiBoatPositionsController::class, 'update'])->name('api.boats.positions.update');
    Route::get('boats/{boat}/positions/{boatPosition}/delete', [ApiBoatPositionsController::class, 'delete'])->name('api.boats.positions.delete');

    Route::get('boats/{boat}/boat_types', [ApiBoatBoatTypesController::class, 'index'])->name('api.boats.boat_types.index');
    Route::get('boats/{boat}/boat_types/{boatType}', [ApiBoatBoatTypesController::class, 'show'])->name('api.boats.boat_types.show');

    Route::get('boats/{boat}/users', [ApiBoatUsersController::class, 'index'])->name('api.boats.users.index');
    Route::get('boats/{boat}/users/{user}', [ApiBoatUsersController::class, 'show'])->name('api.boats.users.show');

    // API buoy routes
    Route::get('buoys', [ApiBuoysController::class, 'index'])->name('api.buoys.index');
    Route::get('buoys/{buoy}', [ApiBuoysController::class, 'show'])->name('api.buoys.show');

    Route::get('buoys/{buoy}/positions', [ApiBuoyPositionsController::class, 'index'])->name('api.buoys.positions.index');
    Route::post('buoys/{buoy}/positions', [ApiBuoyPositionsController::class, 'store'])->name('api.buoys.positions.store');
    Route::get('buoys/{buoy}/positions/{buoyPosition}', [ApiBuoyPositionsController::class, 'show'])->name('api.buoys.positions.show');
    Route::post('buoys/{buoy}/positions/{buoyPosition}', [ApiBuoyPositionsController::class, 'update'])->name('api.buoys.positions.update');
    Route::get('buoys/{buoy}/positions/{buoyPosition}/delete', [ApiBuoyPositionsController::class, 'delete'])->name('api.buoys.positions.delete');

    // API events routes
    Route::get('events', [ApiEventsController::class, 'index'])->name('api.events.index');
    Route::post('events', [ApiEventsController::class, 'store'])->name('api.events.store');
    Route::get('events/{event}', [ApiEventsController::class, 'show'])->name('api.events.show');
    Route::post('events/{event}', [ApiEventsController::class, 'update'])->name('api.events.update');
    Route::get('events/{event}/delete', [ApiEventsController::class, 'delete'])->name('api.events.delete');

    Route::get('events/{event}/finishes', [ApiEventFinishesController::class, 'index'])->name('api.events.finishes.index');
    Route::post('events/{event}/finishes', [ApiEventFinishesController::class, 'store'])->name('api.events.finishes.store');
    Route::get('events/{event}/finishes/{eventFinish}', [ApiEventFinishesController::class, 'show'])->name('api.events.finishes.show');
    Route::post('events/{event}/finishes/{eventFinish}', [ApiEventFinishesController::class, 'update'])->name('api.events.finishes.update');
    Route::get('events/{event}/finishes/{eventFinish}/delete', [ApiEventFinishesController::class, 'delete'])->name('api.events.finishes.delete');

    Route::get('events/{event}/classes', [ApiEventClassesController::class, 'index'])->name('api.events.classes.index');
    Route::get('events/{event}/classes/{eventClass}', [ApiEventClassesController::class, 'show'])->name('api.events.classes.show');

    Route::get('events/{event}/classes/{eventClass}/fleets', [ApiEventClassFleetsController::class, 'index'])->name('api.events.classes.fleets.index');
    Route::get('events/{event}/classes/{eventClass}/fleets/{eventClassFleet}', [ApiEventClassFleetsController::class, 'show'])->name('api.events.classes.fleets.show');

    Route::get('events/{event}/classes/{eventClass}/fleets/{eventClassFleet}/boats', [ApiEventClassFleetBoatsController::class, 'index'])->name('api.events.classes.fleets.boats.index');
	Route::post('events/{event}/classes/{eventClass}/fleets/{eventClassFleet}/boats', [ApiEventClassFleetBoatsController::class, 'store'])->name('api.events.classes.fleets.boats.store');																																													  
    Route::get('events/{event}/classes/{eventClass}/fleets/{eventClassFleet}/boats/{boat}', [ApiEventClassFleetBoatsController::class, 'show'])->name('api.events.classes.fleets.boats.show');
	Route::post('events/{event}/classes/{eventClass}/fleets/{eventClassFleet}/boats/{boat}', [ApiEventClassFleetBoatsController::class, 'update'])->name('api.events.classes.fleets.boats.update');
    Route::get('events/{event}/classes/{eventClass}/fleets/{eventClassFleet}/boats/{boat}/delete', [ApiEventClassFleetBoatsController::class, 'delete'])->name('api.events.classes.fleets.boats.delete');																																															   

    // API auth routes
    Route::get('auth/logout', [ApiAuthController::class, 'logout'])->name('api.auth.logout');

    // API AIS Receiver routes
    Route::post('ais', [ApiAISController::class, 'store'])->name('api.ais.store');
});

// Verify API key without auth token check
Route::middleware('api_key:false')->group(function () {
    // API auth routes
    Route::any('auth/login', [ApiAuthController::class, 'login'])->name('api.auth.login');
    Route::any('auth/register', [ApiAuthController::class, 'register'])->name('api.auth.register');
});