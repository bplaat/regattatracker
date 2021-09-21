<?php

namespace App\Http\Controllers;

use App\Models\Boat;
use App\Models\BoatPosition;
use App\Models\BoatType;
use App\Models\BoatUser;
use App\Models\User;
use App\Rules\SailNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            'weight' => 'required|numeric|min:1|max:100000',
            'sail_number' => ['nullable', new SailNumber],
            'sail_area' => 'required|numeric|min:1|max:10000'
        ]);

        // Create boat
        $boat = Boat::create([
            'name' => $fields['name'],
            'description' => $fields['description'],
            'mmsi' => $fields['mmsi'],
            'length' => $fields['length'],
            'breadth' => $fields['breadth'],
            'weight' => $fields['weight'] * 1000,
            'sail_number' => $fields['sail_number'],
            'sail_area' => $fields['sail_area']
        ]);

        // Update boat image when not empty
        if (request('image') != '') {
            $fields = $request->validate([
                'image' => 'required|image'
            ]);

            // Save file to boats folder
            $image = Boat::generateImageName($request->file('image')->extension());
            $request->file('image')->storeAs('public/boats', $image);

            // Delete old boat image
            if ($boat->image != null) {
                Storage::delete('public/boats/' . $boat->image);
            }

            // Update boat that he has an image
            $boat->update([ 'image' => $image ]);
        }

        // Add authed user to boat as owner
        $boat->users()->attach(Auth::user(), [
            'role' => BoatUser::ROLE_OWNER
        ]);

        // Go to the new boat page
        return redirect()->route('boats.show', $boat);
    }

    // Boats show route
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
        $boatNotCrew = $boatUsers->filter(function ($user) {
            return $user->pivot->role != BoatUser::ROLE_CREW;
        });
        $boatOwners = $boatUsers->filter(function ($user) {
            return $user->pivot->role == BoatUser::ROLE_OWNER;
        });
        $users = User::all()->sortBy('sortName', SORT_NATURAL | SORT_FLAG_CASE);

        $boatGuests = $boat->guests->sortBy('sortName', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();

        // Return boat show view
        return view('boats.show', [
            'boat' => $boat,

            'time' => $time,
            'boatPositions' => $boatPositions,

            'boatBoatTypes' => $boatBoatTypes,
            'boatTypes' => $boatTypes,

            'boatUsers' => $boatUsers,
            'boatNotCrew' => $boatNotCrew,
            'boatOwners' => $boatOwners,
            'users' => $users,
            'boatGuests' => $boatGuests
        ]);
    }

    // Boats track route
    public function track(Boat $boat)
    {
        // Get boat positions of today
        $boatPositions = $boat->positionsByDay(time());

        // Return boat track view
        return view('boats.track', [
            'boat' => $boat,
            'boatPositions' => $boatPositions
        ]);
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
            'weight' => 'required|numeric|min:1|max:100000',
            'sail_number' => ['nullable', new SailNumber],
            'sail_area' => 'required|numeric|min:1|max:10000'
        ]);

        // Update boat
        $boat->update([
            'name' => $fields['name'],
            'description' => $fields['description'],
            'mmsi' => $fields['mmsi'],
            'length' => $fields['length'],
            'breadth' => $fields['breadth'],
            'weight' => $fields['weight'] * 1000,
            'sail_number' => $fields['sail_number'],
            'sail_area' => $fields['sail_area']
        ]);

        // Update boat image when not empty
        if (request('image') != '') {
            $fields = $request->validate([
                'image' => 'required|image'
            ]);

            // Save file to boats folder
            $image = Boat::generateImageName($request->file('image')->extension());
            $request->file('image')->storeAs('public/boats', $image);

            // Delete old boat image
            if ($boat->image != null) {
                Storage::delete('public/boats/' . $boat->image);
            }

            // Update boat that he has an image
            $boat->update([ 'image' => $image ]);
        }

        // Go to the boat page
        return redirect()->route('boats.show', $boat);
    }

    // Boats delete image route
    public function deleteImage(Boat $boat)
    {
        // Delete boat image file from storage
        Storage::delete('public/boats/' . $boat->image);

        // Update boat that he has no image
        $boat->update([ 'image' => null ]);

        // Go to the boats edit page
        return redirect()->route('boats.edit', $boat);
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
