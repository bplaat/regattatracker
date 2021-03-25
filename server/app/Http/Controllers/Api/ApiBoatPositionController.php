<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\BoatPosition;
use Illuminate\Http\Request;

class ApiBoatPositionController extends Controller
{

    // Returns all boat positions
    public function index()
    {

        $boats = Boat::all();
        $subset = $boats->map(function ($boat) {
            return $boat->positions;
        });

        return $subset->collapse();

    }

    // Returns specified boat position
    public function show($id)
    {
        return Boat::findOrFail($id)->positions;
    }

    public function store(Request $request, $id)
    {
        $boatPosition = BoatPosition::create([
            'longitude' => $request->get('longitude'),
            'latitude' => $request->get('latitude'),
            'boat_id' => $id
        ]);
        return response()->json($boatPosition, 201);

    }

    // Updates specified boat position
    public function update(Request $request, $id)
    {
        $boatPosition = BoatPosition::findOrFail($id);
        $boatPosition->update([
            'longitude' => $request->get('longitude'),
            'latitude' => $request->get('latitude'),
        ]);

        return response()->json($boatPosition);;

    }
}
