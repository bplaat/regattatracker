<?php

namespace App\Http\Controllers;

use App\Models\Boat;
use App\Models\BoatPosition;
use App\Rules\Latitude;
use App\Rules\Longitude;
use Illuminate\Http\Request;

class BoatPositionsController extends Controller
{
    // Boat positions store route
    public function store(Request $request, Boat $boat)
    {
        // Validate input
        $fields = $request->validate([
            'latitude' => ['required', new Latitude],
            'longitude' => ['required', new Longitude]
        ]);

        // Create boat position
        BoatPosition::create([
            'boat_id' => $boat->id,
            'latitude' => $fields['latitude'],
            'longitude' => $fields['longitude']
        ]);

        // Return to the boat show page
        return redirect()->route('boats.show', $boat);
    }
}
