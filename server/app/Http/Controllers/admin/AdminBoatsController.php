<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boat;

class AdminBoatsController extends Controller {
    // Admin boats index route
    public function index() {
        $boats = Boat::all();
        return view('admin.boats.index', [ 'boats' => $boats ]);
    }

    // Admin boats show route
    public function show(Boat $boat) {
        return view('admin.boats.show', [ 'boat' => $boat ]);
    }
}
