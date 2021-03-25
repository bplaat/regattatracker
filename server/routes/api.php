<?php

use App\Http\Controllers\Api\ApiBoatsController;
use App\Http\Controllers\Api\ApiBoatPositionsController;
use App\Http\Controllers\Api\ApiBoatBoatTypesController;
use App\Http\Controllers\Api\ApiBoatUsersController;

use Illuminate\Support\Facades\Route;

// TODO: API auth

// Api boat routes
Route::get('boats', [ApiBoatsController::class, 'index']);

Route::get('boats/{boat}', [ApiBoatsController::class, 'show']);

Route::get('boats/{boat}/positions', [ApiBoatPositionsController::class, 'index']);

Route::post('boats/{boat}/positions', [ApiBoatPositionsController::class, 'store']);

Route::get('boats/{boat}/boat_types', [ApiBoatBoatTypesController::class, 'index']);

Route::get('boats/{boat}/users', [ApiBoatUsersController::class, 'index']);
