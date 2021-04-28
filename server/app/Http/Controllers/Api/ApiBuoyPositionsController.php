<?php

namespace App\Http\Controllers\Api;

use App\Signals\NewBuoyPositionSignal;
use App\Http\Controllers\Controller;
use App\Models\Buoy;
use App\Rules\Latitude;
use App\Rules\Longitude;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiBuoyPositionsController extends Controller
{
    // API buoy positions index route
    public function index(Buoy $buoy)
    {
        // Return the buoy positions
        return $buoy->positions->paginate(config('pagination.api.limit'));
    }

    // API buoy positions store route
    public function store(Request $request, Buoy $buoy)
    {
        // Validate input
        $validation = Validator::make($request->all(), [
            'latitude' => ['required', new Latitude],
            'longitude' => ['required', new Longitude]
        ]);
        if ($validation->fails()) {
            return response(['errors' => $validation->errors()], 400);
        }

        // Create buoy position
        $buoyPosition = $buoy->positions()->create([
            'latitude' => request('latitude'),
            'longitude' => request('longitude')
        ]);

        // Send new buoy position signal to websockets server
        new NewBuoyPositionSignal($buoyPosition);

        // Return the new created buoy position
        return $buoyPosition;
    }

    // Api buoy positions show route
    public function show(Request $request, Buoy $buoy, BuoyPosition $buoyPosition)
    {
        // Return to the buoy position
        return $buoyPosition;
    }

    // Api buoy positions update route
    public function update(Request $request, Buoy $buoy, BuoyPosition $buoyPosition)
    {
        // Validate input
        $validation = Validator::make($request->all(), [
            'latitude' => ['required', new Latitude],
            'longitude' => ['required', new Longitude],
            'created_at_date' => 'required|date_format:Y-m-d',
            'created_at_time' => 'required|date_format:H:i:s'
        ]);
        if ($validation->fails()) {
            return response(['errors' => $validation->errors()], 400);
        }

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

        // Return to the buoy position
        return $buoyPosition;
    }

    // Api buoy positions delete route
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

        // Return success message
        return [
            'message' => 'Your buoy position has been deleted!'
        ];
    }
}
