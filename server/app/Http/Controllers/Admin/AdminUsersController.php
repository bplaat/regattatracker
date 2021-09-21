<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\BoatType;
use App\Models\BoatUser;
use App\Models\User;
use App\Rules\SailNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminUsersController extends Controller
{
    // Admin users index route
    public function index()
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $users = User::search($query)->get();
        } else {
            $users = User::all();
        }
        $users = $users->sortBy('sortName', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();

        // Return admin users index view
        return view('admin.users.index', ['users' => $users]);
    }

    // Admin users store route
    public function store(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'firstname' => 'required|min:2|max:48',
            'insertion' => 'nullable|max:16',
            'lastname' => 'required|min:2|max:48',
            'gender' => 'required|integer|digits_between:' . User::GENDER_MALE . ',' . User::GENDER_OTHER,
            'birthday' => 'required|date',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'nullable|max:255',
            'address' => 'required|min:2|max:255',
            'postcode' => 'required|min:2|max:255',
            'city' => 'required|min:2|max:255',
            'country' => 'required|min:2|max:255',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|integer|digits_between:' . User::ROLE_NORMAL . ',' . User::ROLE_ADMIN
        ]);

        // Create user
        $user = User::create([
            'firstname' => $fields['firstname'],
            'insertion' => $fields['insertion'],
            'lastname' => $fields['lastname'],
            'gender' => $fields['gender'],
            'birthday' => $fields['birthday'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
            'address' => $fields['address'],
            'postcode' => $fields['postcode'],
            'city' => $fields['city'],
            'country' => $fields['country'],
            'password' => Hash::make($fields['password']),
            'role' => $fields['role']
        ]);

        // Update user avatar when not empty
        if (request('avatar') != '') {
            $fields = $request->validate([
                'avatar' => 'required|image'
            ]);

            // Save file to avatars folder
            $avatar = User::generateAvatarName($request->file('avatar')->extension());
            $request->file('avatar')->storeAs('public/avatars', $avatar);

            // Delete old user avatar
            if ($user->avatar != null) {
                Storage::delete('public/avatars/' . $user->avatar);
            }

            // Update user that he has an avatar
            $user->update([ 'avatar' => $avatar ]);
        }

        // Go to the new admin user page
        return redirect()->route('admin.users.show', $user);
    }


    // Admin users store complete route
    public function storeComplete(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            // User info
            'firstname' => 'required|min:2|max:48',
            'insertion' => 'nullable|max:16',
            'lastname' => 'required|min:2|max:48',
            'gender' => 'required|integer|digits_between:' . User::GENDER_MALE . ',' . User::GENDER_OTHER,
            'birthday' => 'required|date',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'nullable|max:255',
            'address' => 'required|min:2|max:255',
            'postcode' => 'required|min:2|max:255',
            'city' => 'required|min:2|max:255',
            'country' => 'required|min:2|max:255',

            // Boat info
            'name' => 'required|min:2|max:48',
            'website' => 'nullable|url',
            'boat_type' => 'required|min:2|max:48',
            'mmsi' => 'required|digits:9|unique:boats',
            'length' => 'required|numeric|min:1|max:1000',
            'breadth' => 'required|numeric|min:1|max:1000',
            'weight' => 'required|numeric|min:1|max:100000',
            'sail_number' => ['nullable', new SailNumber],
            'sail_area' => 'required|numeric|min:1|max:10000'
        ]);

        // Create user
        $user = User::create([
            'firstname' => $fields['firstname'],
            'insertion' => $fields['insertion'],
            'lastname' => $fields['lastname'],
            'gender' => $fields['gender'],
            'birthday' => $fields['birthday'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
            'address' => $fields['address'],
            'postcode' => $fields['postcode'],
            'city' => $fields['city'],
            'country' => $fields['country'],
            'password' => Hash::make('regattatracker'),
            'role' => User::ROLE_NORMAL
        ]);

        // Create boat
        $boat = Boat::create([
            'name' => $fields['name'],
            'description' => $fields['website'] != '' ? 'Website: ' . $fields['website'] : null,
            'mmsi' => $fields['mmsi'],
            'length' => $fields['length'],
            'breadth' => $fields['breadth'],
            'weight' => $fields['weight'] * 1000,
            'sail_number' => $fields['sail_number'],
            'sail_area' => $fields['sail_area']
        ]);

        // Attach user to boat as owner
        $boat->users()->attach($user, [
            'role' => BoatUser::ROLE_OWNER
        ]);

        // Attach boat type (create if not existing) to new boat
        $boatType = BoatType::where('name', $fields['boat_type'])->first();
        if ($boatType == null) {
            $boatType = BoatType::create([
                'name' => $fields['boat_type']
            ]);
        }
        $boat->boatTypes()->attach($boatType);

        // Go to the new admin user page
        return redirect()->route('admin.users.show', $user);
    }

    // Admin users show route
    public function show(User $user)
    {
        // Get all user boats
        $boats = $user->boats->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->sortByDesc('pivot.role')->paginate(config('pagination.web.limit'))->withQueryString();

        // Return admin users show view
        return view('admin.users.show', [
            'user' => $user,
            'boats' => $boats
        ]);
    }

    // Admin users edit route
    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user, 'countries' => User::COUNTRIES]);
    }

    // Admin users hijack route
    public function hijack(User $user)
    {
        // Login as the user
        Auth::login($user, true);

        // Go to the home page
        return redirect()->route('home');
    }

    // Admin users update route
    public function update(Request $request, User $user)
    {
        // Validate input
        $fields = $request->validate([
            'firstname' => 'required|min:2|max:48',
            'insertion' => 'nullable|max:16',
            'lastname' => 'required|min:2|max:48',
            'gender' => 'required|integer|digits_between:' . User::GENDER_MALE . ',' . User::GENDER_OTHER,
            'birthday' => 'required|date',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->email, 'email')
            ],
            'phone' => 'nullable|max:255',
            'address' => 'required|min:2|max:255',
            'postcode' => 'required|min:2|max:255',
            'city' => 'required|min:2|max:255',
            'country' => 'required|min:2|max:255',
            'role' => 'required|integer|digits_between:' . User::ROLE_NORMAL . ',' . User::ROLE_ADMIN
        ]);

        // Update user
        $user->update([
            'firstname' => $fields['firstname'],
            'insertion' => $fields['insertion'],
            'lastname' => $fields['lastname'],
            'gender' => $fields['gender'],
            'birthday' => $fields['birthday'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
            'address' => $fields['address'],
            'postcode' => $fields['postcode'],
            'city' => $fields['city'],
            'country' => $fields['country'],
            'role' => $fields['role']
        ]);

        // Update user password when not empty
        if (request('password') != '') {
            $fields = $request->validate([
                'password' => 'required|min:6|confirmed'
            ]);

            $user->update([
                'password' => Hash::make($fields['password'])
            ]);
        }

        // Update user avatar when not empty
        if (request('avatar') != '') {
            $fields = $request->validate([
                'avatar' => 'required|image'
            ]);

            // Save file to avatars folder
            $avatar = User::generateAvatarName($request->file('avatar')->extension());
            $request->file('avatar')->storeAs('public/avatars', $avatar);

            // Delete old user avatar
            if ($user->avatar != null) {
                Storage::delete('public/avatars/' . $user->avatar);
            }

            // Update user that he has an avatar
            $user->update([ 'avatar' => $avatar ]);
        }

        // Go to the admin user page
        return redirect()->route('admin.users.show', $user);
    }

    // Admin users delete avatar route
    public function deleteAvatar(User $user)
    {
        // Delete user avatar file from storage
        Storage::delete('public/avatars/' . $user->avatar);

        // Update user that he has no avatar
        $user->update([ 'avatar' => null ]);

        // Go to the user edit page
        return redirect()->route('admin.users.edit', $user);
    }

    // Admin users delete route
    public function delete(User $user)
    {
        // Delete user
        $user->delete();

        // Go to the users index page
        return redirect()->route('admin.users.index');
    }
}
