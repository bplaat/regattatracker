<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\BoatType;
use App\Models\BoatUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoatsController extends Controller {
    // Boats index route
    public function index() {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $boats = Boat::searchCollection(Auth::user()->boats, $query);
        } else {
            $boats = Auth::user()->boats;
        }
        $boats = $boats->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->paginate(5)->withQueryString();

        return view('boats.index', [ 'boats' => $boats ]);
    }

    // Boats store route
    public function store(Request $request) {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2'
        ]);

        // Create boat
        $boat = Boat::create([
            'name' => $fields['name'],
            'description' => request('description')
        ]);

        // Add user to boat as captain
        BoatUser::create([
            'boat_id' => $boat->id,
            'user_id' => Auth::id(),
            'role' => BoatUser::ROLE_CAPTAIN
        ]);

        // Go to the new boat page
        return redirect()->route('boats.show', $boat);
    }

    // Boats show route
    public function show(Boat $boat) {
        $this->checkUser($boat);

        $boatBoatTypes = $boat->boatTypes->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->paginate(5)->withQueryString();
        $boatTypes = BoatType::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);

        $boatUsers = $boat->users->sortBy('firstname', SORT_NATURAL | SORT_FLAG_CASE)->paginate(5)->withQueryString();
        $boatCaptains = $boatUsers->filter(function ($user) { return $user->pivot->role == BoatUser::ROLE_CAPTAIN; });
        $boatUser = $boatUsers->firstWhere('id', Auth::id());
        $users = User::all()->sortBy('firstname', SORT_NATURAL | SORT_FLAG_CASE);

        return view('boats.show', [
            'boat' => $boat,
            'boatBoatTypes' => $boatBoatTypes,
            'boatTypes' => $boatTypes,
            'boatUsers' => $boatUsers,
            'boatCaptains' => $boatCaptains,
            'boatUser' => $boatUser,
            'users' => $users
        ]);
    }

    // Boats edit route
    public function edit(Boat $boat) {
        $this->checkUserAsCaptain($boat);

        return view('boats.edit', [ 'boat' => $boat ]);
    }

    // Boats update route
    public function update(Request $request, Boat $boat) {
        $this->checkUserAsCaptain($boat);

        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2'
        ]);

        // Update boat
        $boat->update([
            'name' => $fields['name'],
            'description' => request('description')
        ]);

        // Go to the boat page
        return redirect()->route('boats.show', $boat);
    }

    // Boats delete route
    public function delete(Boat $boat) {
        $this->checkUserAsCaptain($boat);

        // Delete boat
        $boat->delete();

        // Go to the boats index page
        return redirect()->route('boats.index');
    }

    // Check if user is connected to the boat
    private function checkUser($boat) {
        if (BoatUser::where('boat_id', $boat->id)->where('user_id', Auth::id())->count() == 0) {
            abort(404);
        }
    }

    // Check if user is connected to the boat and is captain
    private function checkUserAsCaptain($boat) {
        $this->checkUser($boat);

        if (BoatUser::where('boat_id', $boat->id)->where('user_id', Auth::id())->first()->role != BoatUser::ROLE_CAPTAIN) {
            abort(404);
        }
    }
}
