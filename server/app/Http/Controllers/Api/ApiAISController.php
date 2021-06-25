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

class ApiAISController extends Controller
{
    // API AIS store route
    public function store(Request $request)
    {
        // Create array from json string
        $data = json_decode(request('data'), true);

        // Check if a boat exsists with the given mmsi
        try{
            $boat = Boat::where('mmsi', $data['mmsi'])->first();
        }catch(\Exception $e){
            return NULL;
        }
        
        // Create boat position
        $boatPosition = $boat->positions()->create([
            'latitude' => $data['lat'],
            'longitude' => $data['lon']
        ]);

        // Send new boat position signal to websockets server
        new NewBoatPositionSignal($boatPosition);

        return $boatPosition;
    }
}