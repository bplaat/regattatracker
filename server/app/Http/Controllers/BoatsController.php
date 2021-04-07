<?php

namespace App\Http\Controllers;

use App\Models\Boat;
use App\Models\BoatPosition;
use App\Models\BoatType;
use App\Models\BoatUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BoatsController extends Controller
{
    // Boats index route
    public function index()
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $boats = Boat::searchCollection(Auth::user()->boats, $query);
        } else {
            $boats = Auth::user()->boats;
        }
        $boats = $boats->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->sortByDesc('pivot.role')->paginate(config('pagination.web.limit'))->withQueryString();

        // Return boat index view
        return view('boats.index', ['boats' => $boats]);
    }

    // Boats store route
    public function store(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:48',
            'description' => 'nullable|max:20000',
            'mmsi' => 'required|digits:9|unique:boats',
            'length' => 'required|numeric|min:1|max:1000',
            'breadth' => 'required|numeric|min:1|max:1000',
            'weight' => 'required|numeric|min:1|max:100000000',
            'sail_number' => 'required|integer|min:1|max:100000000',
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

        // Add authed user to boat as captain
        $boat->users()->attach(Auth::user(), [
            'role' => BoatUser::ROLE_CAPTAIN
        ]);

        // Go to the new boat page
        return redirect()->route('boats.show', $boat);
    }

    // Boats show route
    public function show(Boat $boat)
    {
        // Select boat information
        $boatPositions = $boat->positions;

        $boatBoatTypes = $boat->boatTypes->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();
        $boatTypes = BoatType::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);

        $boatUsers = $boat->users->sortBy(User::sortByName(), SORT_NATURAL | SORT_FLAG_CASE)
            ->sortByDesc('pivot.role')->paginate(config('pagination.web.limit'))->withQueryString();
        $boatCaptains = $boatUsers->filter(function ($user) {
            return $user->pivot->role == BoatUser::ROLE_CAPTAIN;
        });
        $users = User::all()->sortBy(User::sortByName(), SORT_NATURAL | SORT_FLAG_CASE);

        // Return boat show view
        return view('boats.show', [
            'boat' => $boat,

            'boatPositions' => $boatPositions,

            'boatBoatTypes' => $boatBoatTypes,
            'boatTypes' => $boatTypes,

            'boatUsers' => $boatUsers,
            'boatCaptains' => $boatCaptains,
            'users' => $users
        ]);
    }

    // Boats track route
    public function track(Boat $boat)
    {
        // Active boat position relationship
        $boat->positions;

        // Return boat track view
        return view('boats.track', ['boat' => $boat]);
    }

    // Boats edit route
    public function edit(Boat $boat)
    {
        // Return boat edit view
        return view('boats.edit', ['boat' => $boat]);
    }

    // Boats update route
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
            'sail_number' => 'required|integer|min:1|max:100000000',
            'sail_area' => 'required|numeric|min:1|max:10000'
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

        // Go to the boat page
        return redirect()->route('boats.show', $boat);
    }

    // Boats delete route
    public function delete(Boat $boat)
    {
        // Delete boat
        $boat->delete();

        // Go to the boats index page
        return redirect()->route('boats.index');
    }
}
