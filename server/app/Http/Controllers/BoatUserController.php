<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\BoatUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoatUserController extends Controller {
    // Boat user create route
    public function create(Request $request, Boat $boat) {
        $this->checkUser($boat);

        // Validate input
        $fields = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|integer|digits_between:' . BoatUser::ROLE_CREW . ',' . BoatUser::ROLE_CAPTAIN
        ]);

        // Create boat user connection
        BoatUser::create([
            'boat_id' => $boat->id,
            'user_id' => $fields['user_id'],
            'role' => $fields['role']
        ]);

        // Go back to the boat page
        return redirect()->route('boats.show', $boat);
    }

    // Boat user delete route
    public function delete(Request $request, Boat $boat, User $user) {
        $this->checkUser($boat);

        // Delete boat user connection
        BoatUser::where('boat_id', $boat->id)
            ->where('user_id', $user->id)
            ->first()
            ->delete();

        // Go back to the boat page
        return redirect()->route('boats.show', $boat);
    }

    // Check if user is onwer of boat
    private function checkUser($boat) {
        if ($boat->user_id != Auth::id()) {
            abort(404);
        }
    }
}
