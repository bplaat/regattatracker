<?php

namespace App\Http\Controllers\Api;

use App\Signals\NewBoatPositionSignal;
use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\BoatPosition;
use App\Rules\Latitude;
use App\Rules\Longitude;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiBoatPositionsController extends Controller
{
    // Api boat positions index route
    public function index(Boat $boat)
    {
        // Return the boat positions
        return $boat->positions->paginate(config('pagination.api.limit'));
    }

    // Api boat positions store route
    public function store(Request $request, Boat $boat)
    {
        // Validate input
        $validation = Validator::make($request->all(), [
            'latitude' => ['required', new Latitude],
            'longitude' => ['required', new Longitude]
        ]);
        if ($validation->fails()) {
            return response(['errors' => $validation->errors()], 400);
        }

        // Create boat position
        $boatPosition = $boat->positions()->create([
            'latitude' => request('latitude'),
            'longitude' => request('longitude')
        ]);

        // Send new boat position signal to websockets server
        new NewBoatPositionSignal($boatPosition);

        // Return the new created boat position
        return $boatPosition;
    }

    // Api boat positions show route
    public function show(Request $request, Boat $boat, BoatPosition $boatPosition)
    {
        // Return to the boat position
        return $boatPosition;
    }

    // Api boat positions update route
    public function update(Request $request, Boat $boat, BoatPosition $boatPosition)
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

        // Return to the boat position
        return $boatPosition;
    }

    // Api boat positions delete route
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

        // Return success message
        return [
            'message' => 'Your boat position has been deleted!'
        ];
    }
}
