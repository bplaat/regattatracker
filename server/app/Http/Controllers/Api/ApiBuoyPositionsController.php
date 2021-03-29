<?php

namespace App\Http\Controllers\Api;

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
        // Return the boat positions
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

        // Return the new created boat position
        return $buoyPosition;
    }
}
