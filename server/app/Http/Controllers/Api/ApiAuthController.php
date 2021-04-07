<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;

class ApiAuthController extends Controller
{
    // API login route
    public function login(Request $request)
    {
        // Validate input
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validation->fails()) {
            return response(['errors' => $validation->errors()], 400);
        }

        // Try to login
        $user = User::where('email', request('email'))->first();
        if (!$user || !Hash::check(request('password'), $user->password)) {
            return response(['errors' => [
                'email' => [
                    __('auth.login.error')
                ]
            ]], 400);
        }

        // When successfull create new token and return it
        return [
            'token' => $user->createToken('API auth token for api')->plainTextToken
        ];
    }

    // API register route
    public function register(Request $request)
    {
        // Validate input
        $validation = Validator::make($request->all(), [
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
            'password' => 'required|min:6'
        ]);
        if ($validation->fails()) {
            return response(['errors' => $validation->errors()], 400);
        }

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

            // First created account is always admin
            'role' => User::count() == 0 ? User::ROLE_ADMIN : User::ROLE_NORMAL
        ]);

        // When successfull create new token for new user and return it
        return [
            'token' => $user->createToken('API auth token for api')->plainTextToken
        ];
    }

    // API logout route
    public function logout(Request $request)
    {
        // Revoke current used token
        $request->user()->currentAccessToken()->delete();

        // Return success message
        return [
            'message' => 'Your current token has been signed out!'
        ];
    }
}
