<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoatType;
use Illuminate\Http\Request;

class AdminBoatTypesController extends Controller {
    // Admin boat types index route
    public function index() {
        $boatTypes = BoatType::paginate(5);
        return view('admin.boat_types.index', [ 'boatTypes' => $boatTypes ]);
    }

    // Admin boat types store route
    public function store(Request $request) {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2'
        ]);

        // Create boat type
        $boatType = BoatType::create([
            'name' => $fields['name'],
            'description' => request('description')
        ]);

        // Go to the new admin boat type page
        return redirect()->route('admin.boat_types.show', $boatType);
    }

    // Admin boat types show route
    public function show(BoatType $boatType) {
        return view('admin.boat_types.show', [ 'boatType' => $boatType ]);
    }

    // Admin boat types edit route
    public function edit(BoatType $boatType) {
        return view('admin.boat_types.edit', [ 'boatType' => $boatType ]);
    }

    // Admin boat types update route
    public function update(Request $request, BoatType $boatType) {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2'
        ]);

        // Update boat type
        $boatType->update([
            'name' => $fields['name'],
            'description' => request('description')
        ]);

        // Go to the admin boat type page
        return redirect()->route('admin.boat_types.show', $boatType);
    }

    // Admin boat types delete route
    public function delete(BoatType $boatType) {
        // Delete boat type
        $boatType->delete();

        // Go to the boat types index page
        return redirect()->route('admin.boat_types.index');
    }
}