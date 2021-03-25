<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\BoatBoatType;
use App\Models\BoatType;
use App\Models\BoatUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoatBoatTypesController extends Controller
{
    // Boat boat types store route
    public function store(Request $request, Boat $boat)
    {
        // Validate input
        $fields = $request->validate([
            'boat_type_id' => 'required|exists:boat_types,id'
        ]);

        // Create boat boat type connection
        BoatBoatType::create([
            'boat_id' => $boat->id,
            'boat_type_id' => $fields['boat_type_id']
        ]);

        // Go back to the boat page
        return redirect()->route('boats.show', $boat);
    }

    // Boat boat types delete route
    public function delete(Request $request, Boat $boat, BoatType $boatType)
    {
        // Delete boat boat type connection
        BoatBoatType::where('boat_id', $boat->id)
            ->where('boat_type_id', $boatType->id)
            ->first()
            ->delete();

        // Go back to the boat page
        return redirect()->route('boats.show', $boat);
    }
}
