<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\BoatPosition;
use App\Rules\Latitude;
use App\Rules\Longitude;
use Illuminate\Http\Request;

class AdminBoatPositionController extends Controller
{
    // Admin boat position create route
    public function create(Request $request, Boat $boat)
    {
        // Validate input
        $fields = $request->validate([
            'latitude' => [new Latitude],
            'longitude' => [new Longitude]
        ]);

        // Create boet position
        BoatPosition::create([
            'boat_id' => $boat->id,
            'latitude' => $fields['latitude'],
            'longitude' => $fields['longitude']
        ]);

        // Return to the admin boat show page
        return redirect()->route('admin.boats.show', $boat);
    }
}
