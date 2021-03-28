<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Rules\Latitude;
use App\Rules\Longitude;
use Illuminate\Http\Request;

class ApiBoatsController extends Controller
{
    // Api boats index route
    public function index()
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $boats = Boat::search($query)->get();
        } else {
            $boats = Boat::all();
        }
        $boats = $boats->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.api.limit'))->withQueryString();

        // Return the boats
        return $boats;
    }

    // Api boats show route
    public function show(Boat $boat)
    {
        // Activate relations (this is ugly I know)
        $boat->positions;
        $boat->boatTypes;
        $boat->users;

        // Return the boat
        return $boat;
    }
}
