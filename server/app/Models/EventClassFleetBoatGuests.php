<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventClassFleetBoatGuests extends Model
{
    protected $fillable = [
        'event_class_fleet_boat_id',
        'firstname',
        'insertion',
        'lastname',
        'gender',
        'birthday',
        'email',
        'phone',
        'address',
        'postcode',
        'city',
        'country'
    ];

    protected $casts = [
        'birthday' => 'datetime'
    ];
}
