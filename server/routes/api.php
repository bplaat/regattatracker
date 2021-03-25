<?php

use App\Http\Controllers\Api\ApiBoatPositionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('boats/positions/{id}',[ApiBoatPositionController::class, 'show']);

Route::get('boats/positions', [ApiBoatPositionController::class, 'index']);

Route::post('boats/positions/{id}', [ApiBoatPositionController::class, 'store']);

Route::put('boats/positions/{id}', [ApiBoatPositionController::class, 'update']);


