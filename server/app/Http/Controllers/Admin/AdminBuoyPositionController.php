<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buoy;
use App\Models\BuoyPosition;
use App\Rules\Latitude;
use App\Rules\Longitude;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminBuoyPositionController extends Controller
{
    public function create(Request $request, Buoy $buoy)
    {
        // Validate input.
        $fields = $request->validate([
            'latitude' => [new Latitude],
            'longitude' => [new Longitude]
        ]);

        // Create point.
        BuoyPosition::create([
            'buoy_id' => $buoy->id,
            'latitude' => $fields['latitude'],
            'longitude' => $fields['longitude']
        ]);

        // Return to the boat.
        return redirect()->route('admin.buoys.show', $buoy);
    }
}
