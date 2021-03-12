<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Boat;
use App\Models\BoatUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoatPolicy
{
    use HandlesAuthorization;

    // You need to be a crew member to view the boat
    public function show(User $user, Boat $boat) {
        $boatUser = BoatUser::where('boat_id', $boat->id)->where('user_id', $user->id);
        return $boatUser->count() == 1;
    }

    // You need to be a captain to edit the boat
    public function edit(User $user, Boat $boat) {
        $boatUser = BoatUser::where('boat_id', $boat->id)->where('user_id', $user->id);
        return $boatUser->count() == 1 && $boatUser->first()->role == BoatUser::ROLE_CAPTAIN;
    }

    public function update(User $user, Boat $boat) {
        return $this->edit($user, $boat);
    }

    public function delete(User $user, Boat $boat) {
        return $this->edit($user, $boat);
    }

    public function boat_boat_type_create(User $user, Boat $boat) {
        return $this->edit($user, $boat);
    }

    public function boat_boat_type_delete(User $user, Boat $boat) {
        return $this->edit($user, $boat);
    }
}
