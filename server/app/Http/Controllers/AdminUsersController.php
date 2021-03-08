<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUsersController extends Controller {
    // Admin users index route
    public function index() {
        $users = User::all();
        return view('admin.users.index', [ 'users' => $users ]);
    }

    // Admin users show route
    public function show(User $user) {
        return view('admin.users.show', [ 'user' => $user ]);
    }
}
