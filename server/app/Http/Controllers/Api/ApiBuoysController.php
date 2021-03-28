<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buoy;

class ApiBuoysController extends Controller
{
    // API buoys index route
    public function index()
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $buoys = Buoy::search($query)->get();
        } else {
            $buoys = Buoy::all();
        }
        $buoys = $buoys->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.api.limit'))->withQueryString();

        // Return the buoys
        return $buoys;
    }

    // API boats show route
    public function show(Buoy $buoy)
    {
        $buoy->positions;

        // Return the buoy
        return $buoy;
    }
}
