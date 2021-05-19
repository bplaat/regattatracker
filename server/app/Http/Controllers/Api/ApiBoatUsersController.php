<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\User;

class ApiBoatUsersController extends Controller
{
    // Api boat users index route
    public function index(Boat $boat)
    {
        // Return the boat users
        return $boat->users->paginate(config('pagination.api.limit'));
    }

    // Api boat user show route
    public function show(Boat $boat, User $user)
    {
        // Return the boat user
        return $user;
    }
}
