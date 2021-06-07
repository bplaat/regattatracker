<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventClassFleetBoatUser extends Model
{
    protected $table = 'event_class_fleet_boat_user';

    protected $fillable = [
        'event_class_fleet_boat_id',
        'user_id'
    ];
}
