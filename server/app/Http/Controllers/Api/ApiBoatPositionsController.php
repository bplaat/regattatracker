<?php

namespace App\Http\Controllers\Api;

use App\Events\NewBoatPositionEvent;
use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Rules\Latitude;
use App\Rules\Longitude;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiBoatPositionsController extends Controller
{
    // Api boat positions index route
    public function index(Boat $boat)
    {
        // Return the boat positions
        return $boat->positions->paginate(config('pagination.api.limit'));
    }

    // Api boat positions store route
    public function store(Request $request, Boat $boat)
    {
        // Validate input
        $validation = Validator::make($request->all(), [
            'latitude' => ['required', new Latitude],
            'longitude' => ['required', new Longitude]
        ]);
        if ($validation->fails()) {
            return response(['errors' => $validation->errors()], 400);
        }

        // Create boat position
        $boatPosition = $boat->positions()->create([
            'latitude' => request('latitude'),
            'longitude' => request('longitude')
        ]);

        event(new NewBoatPositionEvent($boatPosition));

        // Return the new created boat position
        return $boatPosition;
    }
}
