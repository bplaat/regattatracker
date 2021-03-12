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
        $this->checkUserAsCaptain($boat);

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
        $this->checkUserAsCaptain($boat);

        // Check if user is not the last capatain
        $boatUser = $boat->users->firstWhere('id', $user->id);
        $boatCaptains = $boat->users->filter(function ($user) { return $user->pivot->role == BoatUser::ROLE_CAPTAIN; });
        if ($boatUser->pivot->role == BoatUser::ROLE_CAPTAIN && $boatCaptains->count() <= 1) {
            return redirect()->route('boats.show', $boat);
        }

        // Delete boat user connection
        BoatUser::where('boat_id', $boat->id)
            ->where('user_id', $user->id)
            ->first()
            ->delete();

        // Go back to the boat page
        return redirect()->route('boats.show', $boat);
    }

    // Check if user is connected to the boat and is captain
    private function checkUserAsCaptain($boat) {
        $boatUser = BoatUser::where('boat_id', $boat->id)->where('user_id', Auth::id());

        if ($boatUser->count() == 0 || $boatUser->first()->role != BoatUser::ROLE_CAPTAIN) {
            abort(404);
        }
    }
}
