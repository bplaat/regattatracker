<?php

namespace App\Http\Controllers;

use App\Signals\NewBoatPositionSignal;
use App\Models\Boat;
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
        $boatPosition = $boat->positions()->create([
            'latitude' => $fields['latitude'],
            'longitude' => $fields['longitude']
        ]);

        // Send new boat position signal to websockets server
        new NewBoatPositionSignal($boatPosition);

        // Return to the boat show page
        return redirect()->route('boats.show', $boat);
    }
}
