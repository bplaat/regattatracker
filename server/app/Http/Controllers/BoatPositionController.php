<?php

namespace App\Http\Controllers;

use App\Models\Boat;
use App\Models\BoatPosition;
use App\Rules\Latitude;
use App\Rules\Longitude;
use Illuminate\Http\Request;

class BoatPositionController extends Controller
{
    public function create(Request $request, Boat $boat)
    {
        // Validate input.
        $fields = $request->validate([
            'latitude' => [new Latitude],
            'longitude' => [new Longitude]
        ]);

        // Create point.
        BoatPosition::create([
            'boat_id' => $boat->id,
            'latitude' => $fields['latitude'],
            'longitude' => $fields['longitude']
        ]);

        // Return to the boat.
        return redirect()->route('boats.show', $boat);
    }
}
