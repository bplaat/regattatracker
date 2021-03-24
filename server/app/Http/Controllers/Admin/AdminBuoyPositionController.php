<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buoy;
use App\Models\BuoyPosition;
use App\Rules\Latitude;
use App\Rules\Longitude;
use Illuminate\Http\Request;

class AdminBuoyPositionController extends Controller
{
    // Admin buoy position create route
    public function create(Request $request, Buoy $buoy)
    {
        // Validate input
        $fields = $request->validate([
            'latitude' => [new Latitude],
            'longitude' => [new Longitude]
        ]);

        // Create buoy position
        BuoyPosition::create([
            'buoy_id' => $buoy->id,
            'latitude' => $fields['latitude'],
            'longitude' => $fields['longitude']
        ]);

        // Return to the admin buoy show page
        return redirect()->route('admin.buoys.show', $buoy);
    }
}
