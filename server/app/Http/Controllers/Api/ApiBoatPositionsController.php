<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\BoatPosition;
use App\Rules\Latitude;
use App\Rules\Longitude;
use Illuminate\Http\Request;

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
        $fields = $request->validate([
            'latitude' => [new Latitude],
            'longitude' => [new Longitude]
        ]);

        // Create boat position
        $boatPosition = BoatPosition::create([
            'boat_id' => $boat->id,
            'latitude' => $fields['latitude'],
            'longitude' => $fields['longitude']
        ]);

        // Return the new created boat position
        return $boatPosition;
    }
}
