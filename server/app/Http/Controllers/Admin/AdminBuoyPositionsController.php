<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buoy;
use App\Models\BuoyPosition;
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
        BuoyPosition::create([
            'buoy_id' => $buoy->id,
            'latitude' => $fields['latitude'],
            'longitude' => $fields['longitude']
        ]);

        // Return to the admin buoy show page
        return redirect()->route('admin.buoys.show', $buoy);
    }
}
