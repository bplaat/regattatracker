<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoatUser extends Model
{
    protected $table = 'boat_user';

    // A user can be a normal crew member, a captain on a boat or a boat owner
    const ROLE_CREW = 0;
    const ROLE_CAPTAIN = 1;
    const ROLE_OWNER = 2;

    protected $fillable = [
        'boat_id',
        'user_id',
        'role'
    ];
}
