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
    public function view(User $user, Boat $boat)
    {
        $boatUser = BoatUser::where('boat_id', $boat->id)->where('user_id', $user->id);
        return $boatUser->count() == 1;
    }

    // You need to be a captain to track and update the boat
    public function track(User $user, Boat $boat)
    {
        return $this->update($user, $boat);
    }

    public function update(User $user, Boat $boat)
    {
        $boatUser = BoatUser::where('boat_id', $boat->id)->where('user_id', $user->id);
        return $boatUser->count() == 1 && $boatUser->first()->role == BoatUser::ROLE_CAPTAIN;
    }

    public function delete(User $user, Boat $boat)
    {
        return $this->update($user, $boat);
    }

    // Boat Position connection
    public function create_boat_position(User $user, Boat $boat)
    {
        return $this->update($user, $boat);
    }

    public function update_boat_position(User $user, Boat $boat)
    {
        return $this->update($user, $boat);
    }

    public function delete_boat_position(User $user, Boat $boat)
    {
        return $this->update($user, $boat);
    }

    // Boat Boat Type connection
    public function create_boat_boat_type(User $user, Boat $boat)
    {
        return $this->update($user, $boat);
    }

    public function delete_boat_boat_type(User $user, Boat $boat)
    {
        return $this->update($user, $boat);
    }

    // Boat User connection
    public function create_boat_user(User $user, Boat $boat)
    {
        return $this->update($user, $boat);
    }

    public function update_boat_user(User $user, Boat $boat)
    {
        return $this->update($user, $boat);
    }

    public function delete_boat_user(User $user, Boat $boat)
    {
        return $this->update($user, $boat);
    }
}
