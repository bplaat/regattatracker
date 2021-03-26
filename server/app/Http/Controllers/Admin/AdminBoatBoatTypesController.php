<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\BoatType;
use Illuminate\Http\Request;

class AdminBoatBoatTypesController extends Controller
{
    // Admin boat boat types store route
    public function store(Request $request, Boat $boat)
    {
        // Validate input
        $fields = $request->validate([
            'boat_type_id' => 'required|exists:boat_types,id'
        ]);

        // Create boat boat type connection
        $boat->boatTypes()->attach($fields['boat_type_id']);

        // Go back to the boat page
        return redirect()->route('admin.boats.show', $boat);
    }

    // Admin boat boat types delete route
    public function delete(Request $request, Boat $boat, BoatType $boatType)
    {
        // Delete boat boat type connection
        $boat->boatTypes()->detach($boatType);

        // Go back to the boat page
        return redirect()->route('admin.boats.show', $boat);
    }
}
