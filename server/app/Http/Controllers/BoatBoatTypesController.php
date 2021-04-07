<?php

namespace App\Http\Controllers;

use App\Models\Boat;
use App\Models\BoatType;
use Illuminate\Http\Request;

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
        $boat->boatTypes()->attach($fields['boat_type_id']);

        // Go back to the boat page
        return redirect()->route('boats.show', $boat);
    }

    // Boat boat types delete route
    public function delete(Request $request, Boat $boat, BoatType $boatType)
    {
        // Delete boat boat type connection
        $boat->boatTypes()->detach($boatType);

        // Go back to the boat page
        return redirect()->route('boats.show', $boat);
    }
}
