<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\BoatType;

class ApiBoatBoatTypesController extends Controller
{
    // Api boat boat types index route
    public function index(Boat $boat)
    {
        // Return the boat boat types
        return $boat->boatTypes->paginate(config('pagination.api.limit'));
    }

    // Api boat boat types show route
    public function show(Boat $boat, BoatType $boatType)
    {
        // Return the boat boat type
        return $boatType;
    }
}
