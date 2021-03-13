<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class AuthController extends Controller
{
    // Login route
    public function login()
    {
        // Get input
        $email = request('email');
        $password = request('password');

        // Try to login when successfull go to home page
        if (Auth::attempt(['email' => $email, 'password' => $password], true)) {
            return redirect()->route('home');
        }

        return back()->withInput()->with('error', __('auth.login.error'));
    }

    // Register route
    public function register(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'firstname' => 'required|min:2',
            'insertion' => 'nullable',
            'lastname' => 'required|min:2',
            'gender' => 'required|integer|digits_between:' . User::GENDER_MALE . ',' . User::GENDER_OTHER,
            'birthday' => 'required|date',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable',
            'address' => 'required|min:2',
            'postcode' => 'required|min:2',
            'city' => 'required|min:2',
            'country' => 'required|min:2',
            'password' => 'required|min:6|confirmed'
        ]);

        // Create user
        User::create([
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

            // First created account is always admin
            'role' => User::count() == 0 ? User::ROLE_ADMIN : User::ROLE_NORMAL
        ]);

        // Login user in
        Auth::attempt(['email' => $fields['email'], 'password' => $fields['password']], true);

        // Go to home page
        return redirect()->route('home');
    }

    // Logout route
    public function logout()
    {
        // Logout user
        Session::flush();
        Auth::logout();

        // Go to login page
        return redirect()->route('auth.login');
    }
}
