<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Boat;

class ApiBoatUsersController extends Controller
{
    // Api boat users index route
    public function index(Boat $boat)
    {
        // Return the boat users
        return $boat->users->paginate(config('pagination.api.limit'));
    }
}
