<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller {
    // Change details route
    public function changeDetails(Request $request) {
        // Validate input
        $fields = $request->validate([
            'firstname' => 'required|min:2',
            'lastname' => 'required|min:2',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if ($value != Auth::user()->email && count(User::where('email', $value)->get()) > 0) {
                        $fail(__('validation.not_unique_email', [ 'attribute' => $attribute ]));
                    }
                }
            ]
        ]);

        // Update user details
        Auth::user()->update([
            'firstname' => $fields['firstname'],
            'lastname' => $fields['lastname'],
            'email' => $fields['email']
        ]);

        // Go back with message
        return back()->with('message', __('settings.change_details_message'));
    }

    // Change password route
    public function changePassword(Request $request) {
        // Validate input
        $fields = $request->validate([
            'old_password' => function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail(__('validation.old_password', [ 'attribute' => $attribute ]));
                }
            },
            'password' => 'required|min:6'
        ]);

        // Update user password
        Auth::user()->update([
            'password' => Hash::make($fields['password'])
        ]);

        // Go back with message
        return back()->with('message', __('settings.change_password_message'));
    }
}
