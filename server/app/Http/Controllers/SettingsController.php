<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    // Change details route
    public function changeDetails(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'firstname' => 'required|min:2',
            'insertion' => 'nullable',
            'lastname' => 'required|min:2',
            'gender' => 'required|integer|digits_between:' . User::GENDER_MALE . ',' . User::GENDER_OTHER,
            'birthday' => 'required|date',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore(Auth::user()->email, 'email')
            ],
            'phone' => 'nullable',
            'address' => 'required|min:2',
            'postcode' => 'required|min:2',
            'city' => 'required|min:2',
            'country' => 'required|min:2',
        ]);

        // Update user details
        Auth::user()->update([
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
            'country' => $fields['country']
        ]);

        // Go back with message
        return redirect()->route('settings')
            ->with('message', __('settings.change_details_message'));
    }

    // Change password route
    public function changePassword(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'current_password' => function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail(__('validation.current_password', ['attribute' => $attribute]));
                }
            },
            'password' => 'required|min:6'
        ]);

        // Update user password
        Auth::user()->update([
            'password' => Hash::make($fields['password'])
        ]);

        // Go back with message
        return redirect()->route('settings')
            ->with('message', __('settings.change_password_message'));
    }
}
