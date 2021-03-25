<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\BoatPosition;
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
        return $boat->positions->paginate(20);
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
            return response([ 'errors' => $validation->errors() ], 400);
        }

        // Create boat position
        $boatPosition = BoatPosition::create([
            'boat_id' => $boat->id,
            'latitude' => request('latitude'),
            'longitude' => request('longitude')
        ]);

        // Return the new created boat position
        return $boatPosition;
    }
}
