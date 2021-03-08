<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class AuthController extends Controller {
    // Login route
    public function login() {
        // Get input
        $email = request('email');
        $password = request('password');

        // Try to login
        if (Auth::attempt([ 'email' => $email, 'password' => $password ])) {
            // Go to home page when successfull
            return redirect()->route('home');
        }

        return back()->withInput()->with('error', __('auth/login.error'));
    }

    // Register route
    public function register(Request $request) {
        // Validate input
        $fields = $request->validate([
            'firstname' => 'required|min:2',
            'lastname' => 'required|min:2',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        // Create user
        User::create([
            'firstname' => $fields['firstname'],
            'lastname' => $fields['lastname'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password'])
        ]);

        // Login user in
        Auth::attempt([
            'email' => $fields['email'],
            'password' => $fields['password']
        ]);

        // Go to home page
        return redirect()->route('home');
    }

    // Logout route
    public function logout() {
        // Logout user
        Session::flush();
        Auth::logout();

        // Go to login page
        return redirect()->route('auth.login');
    }
}
