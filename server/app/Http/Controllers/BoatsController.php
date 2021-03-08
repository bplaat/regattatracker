<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoatsController extends Controller {
    // Boats index route
    public function index() {
        $boats = Auth::user()->boats;
        return view('boats.index', [ 'boats' => $boats ]);
    }

    // Boats store route
    public function store(Request $request) {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2',
            'description' => 'required'
        ]);

        // Create boat
        $boat = Boat::create([
            'user_id' => Auth::id(),
            'name' => $fields['name'],
            'description' => $fields['description']
        ]);

        // Go to the new boat page
        return redirect()->route('boats.show', $boat);
    }

    // Boats show route
    public function show(Boat $boat) {
        $this->checkUser($boat);

        return view('boats.show', [ 'boat' => $boat ]);
    }

    // Boats edit route
    public function edit(Boat $boat) {
        $this->checkUser($boat);

        return view('boats.edit', [ 'boat' => $boat ]);
    }

    // Boats update route
    public function update(Request $request, Boat $boat) {
        $this->checkUser($boat);

        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2',
            'description' => 'required'
        ]);

        // Update boat
        $boat->update([
            'name' => $fields['name'],
            'description' => $fields['description']
        ]);

        // Go to the boat page
        return redirect()->route('boats.show', $boat);
    }

    // Boats delete route
    public function delete(Boat $boat) {
        $this->checkUser($boat);

        // Delete boat
        $boat->delete();

        // Go to the boats index page
        return redirect()->route('boats.index');
    }

    // Check if user is onwer of boat
    private function checkUser($boat) {
        if ($boat->user_id != Auth::id()) {
            abort(404);
        }
    }
}
