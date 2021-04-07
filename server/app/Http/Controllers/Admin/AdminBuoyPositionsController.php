<?php

namespace App\Http\Controllers\Admin;

use App\Signals\NewBuoyPositionSignal;
use App\Http\Controllers\Controller;
use App\Models\Buoy;
use App\Rules\Latitude;
use App\Rules\Longitude;
use Illuminate\Http\Request;

class AdminBuoyPositionsController extends Controller
{
    // Admin buoy positions store route
    public function store(Request $request, Buoy $buoy)
    {
        // Validate input
        $fields = $request->validate([
            'latitude' => ['required', new Latitude],
            'longitude' => ['required', new Longitude]
        ]);

        // Create buoy position
        $buoyPosition = $buoy->positions()->create([
            'latitude' => $fields['latitude'],
            'longitude' => $fields['longitude']
        ]);

        // Send new buoy position signal to websockets server
        new NewBuoyPositionSignal($buoyPosition);

        // Return to the admin buoy show page
        return redirect()->route('admin.buoys.show', $buoy);
    }
}
