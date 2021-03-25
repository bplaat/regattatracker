<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Boat;

class ApiBoatBoatTypesController extends Controller
{
    // Api boat boat types index route
    public function index(Boat $boat)
    {
        // Return the boat boat types
        return $boat->boatTypes->paginate(20);
    }
}
