<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\BoatPosition;
use App\Rules\Latitude;
use App\Rules\Longitude;
use Illuminate\Http\Request;

class AdminBoatPositionsController extends Controller
{
    // Admin boat positions store route
    public function store(Request $request, Boat $boat)
    {
        // Validate input
        $fields = $request->validate([
            'latitude' => [new Latitude],
            'longitude' => [new Longitude]
        ]);

        // Create boat position
        BoatPosition::create([
            'boat_id' => $boat->id,
            'latitude' => $fields['latitude'],
            'longitude' => $fields['longitude']
        ]);

        // Return to the admin boat show page
        return redirect()->route('admin.boats.show', $boat);
    }
}
