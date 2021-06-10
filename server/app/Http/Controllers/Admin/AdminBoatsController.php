<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\BoatType;
use App\Models\BoatUser;
use App\Models\User;
use App\Rules\SailNumber;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminBoatsController extends Controller
{
    // Admin boats index route
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
            ->paginate(config('pagination.web.limit'))->withQueryString();

        // Return admin boat index view
        return view('admin.boats.index', ['boats' => $boats]);
    }

    // Admin boats create route
    public function create()
    {
        // Get all users
        $users = User::all()->sortBy('sortName', SORT_NATURAL | SORT_FLAG_CASE);

        // Return admin boat create view
        return view('admin.boats.create', ['users' => $users]);
    }

    // Admin boats store route
    public function store(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|min:2|max:48',
            'description' => 'nullable|max:20000',
            'mmsi' => 'required|digits:9|unique:boats',
            'length' => 'required|numeric|min:1|max:1000',
            'breadth' => 'required|numeric|min:1|max:1000',
            'weight' => 'required|numeric|min:1|max:100000000',
            'sail_number' => ['required', new SailNumber],
            'sail_area' => 'required|numeric|min:1|max:10000'
        ]);

        // Create boat
        $boat = Boat::create([
            'name' => $fields['name'],
            'description' => $fields['description'],
            'mmsi' => $fields['mmsi'],
            'length' => $fields['length'],
            'breadth' => $fields['breadth'],
            'weight' => $fields['weight'],
            'sail_number' => $fields['sail_number'],
            'sail_area' => $fields['sail_area']
        ]);

        // Add user to boat as captain
        $boat->users()->attach($fields['user_id'], [
            'role' => BoatUser::ROLE_CAPTAIN
        ]);

        // Go to the new admin boat page
        return redirect()->route('admin.boats.show', $boat);
    }

    // Admin boats show route
    public function show(Boat $boat)
    {
        // Select boat information
        $day = request('day');
        if ($day != null) {
            $time = strtotime($day);
        } else {
            $time = time();
        }
        $boatPositions = $boat->positionsByDay($time);

        $boatBoatTypes = $boat->boatTypes->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();
        $boatTypes = BoatType::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);

        $boatUsers = $boat->users->sortBy('sortName', SORT_NATURAL | SORT_FLAG_CASE)
            ->sortByDesc('pivot.role')->paginate(config('pagination.web.limit'))->withQueryString();
        $boatCaptains = $boatUsers->filter(function ($user) {
            return $user->pivot->role == BoatUser::ROLE_CAPTAIN;
        });
        $users = User::all()->sortBy('sortName', SORT_NATURAL | SORT_FLAG_CASE);

        $boatGuests = $boat->guests->sortBy('sortName', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();

        // Return boat show view
        return view('admin.boats.show', [
            'boat' => $boat,

            'time' => $time,
            'boatPositions' => $boatPositions,

            'boatBoatTypes' => $boatBoatTypes,
            'boatTypes' => $boatTypes,

            'boatUsers' => $boatUsers,
            'boatCaptains' => $boatCaptains,
            'users' => $users,
            'boatGuests' => $boatGuests
        ]);
    }

    // Admin boats track route
    public function track(Boat $boat)
    {
        // Get boat positions of today
        $boatPositions = $boat->positionsByDay(time());

        // Return admin boat track view
        return view('admin.boats.track', [
            'boat' => $boat,
            'boatPositions' => $boatPositions
        ]);
    }

    // Admin boats edit route
    public function edit(Boat $boat)
    {
        return view('admin.boats.edit', ['boat' => $boat]);
    }

    // Admin boats update route
    public function update(Request $request, Boat $boat)
    {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:48',
            'description' => 'nullable|max:20000',
            'mmsi' => [
                'required',
                'digits:9',
                Rule::unique('boats')->ignore($boat->mmsi, 'mmsi')
            ],
            'length' => 'required|numeric|min:1|max:1000',
            'breadth' => 'required|numeric|min:1|max:1000',
            'weight' => 'required|numeric|min:1|max:100000000',
            'sail_number' => ['required', new SailNumber],
            'sail_area' => 'required|numeric|min:0.1|max:10000'
        ]);

        // Update boat
        $boat->update([
            'name' => $fields['name'],
            'description' => $fields['description'],
            'mmsi' => $fields['mmsi'],
            'length' => $fields['length'],
            'breadth' => $fields['breadth'],
            'weight' => $fields['weight'],
            'sail_number' => $fields['sail_number'],
            'sail_area' => $fields['sail_area']
        ]);

        // Go to the admin boat page
        return redirect()->route('admin.boats.show', $boat);
    }

    // Admin boats delete route
    public function delete(Boat $boat)
    {
        // Delete boat
        $boat->delete();

        // Go to the boats index page
        return redirect()->route('admin.boats.index');
    }
}
