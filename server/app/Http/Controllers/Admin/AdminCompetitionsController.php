<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use Illuminate\Http\Request;

class AdminCompetitionsController extends Controller
{
    // Admin competitions index route
    public function index() {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $competitions = Competition::search($query)->get();
        } else {
            $competitions = Competition::all();
        }
        $competitions = $competitions->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();

        // Return admin boat index view
        return view('admin.competitions.index', ['competitions' => $competitions]);
    }

}
