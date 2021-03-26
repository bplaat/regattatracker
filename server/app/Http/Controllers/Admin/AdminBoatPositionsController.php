<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boat;
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
            'latitude' => ['required', new Latitude],
            'longitude' => ['required', new Longitude]
        ]);

        // Create boat position
        $boat->positions()->create([
            'latitude' => $fields['latitude'],
            'longitude' => $fields['longitude']
        ]);

        // Return to the admin boat show page
        return redirect()->route('admin.boats.show', $boat);
    }
}
