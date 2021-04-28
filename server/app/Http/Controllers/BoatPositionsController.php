<?php

namespace App\Http\Controllers;

use App\Signals\NewBoatPositionSignal;
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
        $boatPosition = $boat->positions()->create([
            'latitude' => $fields['latitude'],
            'longitude' => $fields['longitude']
        ]);

        // Send new boat position signal to websockets server
        new NewBoatPositionSignal($boatPosition);

        // Return to the boat show page
        return redirect()->route('boats.show', $boat);
    }

    // Boat positions edit route
    public function edit(Request $request, Boat $boat, BoatPosition $boatPosition)
    {
        // Return the boat positions edit page
        return view('boats.positions.edit', [
            'boat' => $boat,
            'boatPosition' => $boatPosition
        ]);
    }

    // Boat positions update route
    public function update(Request $request, Boat $boat, BoatPosition $boatPosition)
    {
        // Validate input
        $fields = $request->validate([
            'latitude' => ['required', new Latitude],
            'longitude' => ['required', new Longitude],
            'created_at_date' => 'required|date_format:Y-m-d',
            'created_at_time' => 'required|date_format:H:i:s'
        ]);

        // Update boat position
        $boatPosition->update([
            'latitude' => $fields['latitude'],
            'longitude' => $fields['longitude'],
            'created_at' => $fields['created_at_date'] . ' ' . $fields['created_at_time']
        ]);

        // Send new boat position signal to websockets server when is the current boat position
        if ($boat->positions()->first()->id == $boatPosition->id) {
            new NewBoatPositionSignal($boatPosition);
        }

        // Return to the boat show page
        return redirect()->route('boats.show', $boat);
    }

    // Boat positions delete route
    public function delete(Request $request, Boat $boat, BoatPosition $boatPosition)
    {
        // Check if the boat position is the current boat position
        $isCurrent = $boat->positions()->first()->id == $boatPosition->id;

        // Delete boat position
        $boatPosition->delete();

        // Send new boat position signal to websockets server of older boat position
        if ($isCurrent && $boat->positions()->count() > 0) {
            new NewBoatPositionSignal($boat->positions()->first());
        }

        // Return to the boat show page
        return redirect()->route('boats.show', $boat);
    }
}
