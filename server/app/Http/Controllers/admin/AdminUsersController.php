<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUsersController extends Controller {
    // Admin users index route
    public function index() {
        $users = User::all();
        return view('admin.users.index', [ 'users' => $users ]);
    }

    // Admin users store route
    public function store(Request $request) {
        // Validate input
        $fields = $request->validate([
            'firstname' => 'required|min:2',
            'lastname' => 'required|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|integer|digits_between:' . User::ROLE_NORMAL . ',' . User::ROLE_ADMIN
        ]);

        // Create user
        $user = User::create([
            'firstname' => $fields['firstname'],
            'lastname' => $fields['lastname'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
            'role' => $fields['role']
        ]);

        // Go to the new admin user page
        return redirect()->route('admin.users.show', $user);
    }

    // Admin users show route
    public function show(User $user) {
        return view('admin.users.show', [ 'user' => $user ]);
    }

    // Admin users edit route
    public function edit(User $user) {
        return view('admin.users.edit', [ 'user' => $user ]);
    }

    // Admin users update route
    public function update(Request $request, User $user) {
        // Validate input
        $fields = $request->validate([
            'firstname' => 'required|min:2',
            'lastname' => 'required|min:2',
            'email' => 'required|email',
            'role' => 'required|integer|digits_between:' . User::ROLE_NORMAL . ',' . User::ROLE_ADMIN
        ]);

        // Validate email for uniqueness or it is the same
        if ($fields['email'] != $user->email && count(User::where('email', $fields['email'])->get()) > 0) {
            return back()->withInput()->withErrors([ 'email' => __('validation.not_unique_email', [ 'attribute' => 'email' ]) ]);
        }

        // Update user
        $user->update([
            'firstname' => $fields['firstname'],
            'lastname' => $fields['lastname'],
            'email' => $fields['email'],
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

        // Go to the admin user page
        return redirect()->route('admin.users.show', $user);
    }

    // Admin users delete route
    public function delete(User $user) {
        // Complete delete user
        $user->completeDelete();

        // Go to the users index page
        return redirect()->route('admin.users.index');
    }
}
