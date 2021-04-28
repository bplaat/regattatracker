<?php

namespace App\Http\Controllers\Admin;

use App\Signals\NewBuoyPositionSignal;
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
        $buoyPosition = $buoy->positions()->create([
            'latitude' => $fields['latitude'],
            'longitude' => $fields['longitude']
        ]);

        // Send new buoy position signal to websockets server
        new NewBuoyPositionSignal($buoyPosition);

        // Return to the admin buoy show page
        return redirect()->route('admin.buoys.show', $buoy);
    }

    // Admin buoy positions edit route
    public function edit(Request $request, Buoy $buoy, BuoyPosition $buoyPosition)
    {
        // Return the admin buoy positions edit page
        return view('admin.buoys.positions.edit', [
            'buoy' => $buoy,
            'buoyPosition' => $buoyPosition
        ]);
    }

    // Admin buoy positions update route
    public function update(Request $request, Buoy $buoy, BuoyPosition $buoyPosition)
    {
        // Validate input
        $fields = $request->validate([
            'latitude' => ['required', new Latitude],
            'longitude' => ['required', new Longitude],
            'created_at_date' => 'required|date_format:Y-m-d',
            'created_at_time' => 'required|date_format:H:i:s'
        ]);

        // Update buoy position
        $buoyPosition->update([
            'latitude' => $fields['latitude'],
            'longitude' => $fields['longitude'],
            'created_at' => $fields['created_at_date'] . ' ' . $fields['created_at_time']
        ]);

        // Send new buoy position signal to websockets server when is the current buoy position
        if ($buoy->positions()->first()->id == $buoyPosition->id) {
            new NewBuoyPositionSignal($buoyPosition);
        }

        // Return to the admin buoy show page
        return redirect()->route('admin.buoys.show', $buoy);
    }

    // Admin buoy positions delete route
    public function delete(Request $request, Buoy $buoy, BuoyPosition $buoyPosition)
    {
        // Check if the buoy position is the current buoy position
        $isCurrent = $buoy->positions()->first()->id == $buoyPosition->id;

        // Delete buoy position
        $buoyPosition->delete();

        // Send new buoy position signal to websockets server of older buoy position
        if ($isCurrent && $buoy->positions()->count() > 0) {
            new NewBuoyPositionSignal($buoy->positions()->first());
        }

        // Return to the admin buoy show page
        return redirect()->route('admin.buoys.show', $buoy);
    }
}
