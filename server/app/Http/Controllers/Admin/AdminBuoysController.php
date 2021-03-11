<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buoy;
use Illuminate\Http\Request;

class AdminBuoysController extends Controller {
    // Admin buoys index route
    public function index() {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $buoys = Buoy::search($query)->paginate(5);
        } else {
            $buoys = Buoy::paginate(5);
        }

        return view('admin.buoys.index', [ 'buoys' => $buoys ]);
    }

    // Admin buoys store route
    public function store(Request $request) {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2'
        ]);

        // Create buoy
        $buoy = Buoy::create([
            'name' => $fields['name'],
            'description' => request('description')
        ]);

        // Go to the new admin buoy page
        return redirect()->route('admin.buoys.show', $buoy);
    }

    // Admin buoys show route
    public function show(Buoy $buoy) {
        return view('admin.buoys.show', [ 'buoy' => $buoy ]);
    }

    // Admin buoys edit route
    public function edit(Buoy $buoy) {
        return view('admin.buoys.edit', [ 'buoy' => $buoy ]);
    }

    // Admin buoys update route
    public function update(Request $request, Buoy $buoy) {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2'
        ]);

        // Update buoy
        $buoy->update([
            'name' => $fields['name'],
            'description' => request('description')
        ]);

        // Go to the admin buoy page
        return redirect()->route('admin.buoys.show', $buoy);
    }

    // Admin buoys delete route
    public function delete(Buoy $buoy) {
        // Delete buoy
        $buoy->delete();

        // Go to the buoys index page
        return redirect()->route('admin.buoys.index');
    }
}
