<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventClassFleetBoatGuest extends Model
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

    // A event class fleet boat guest belongs to a event class fleet boat
    public function eventClassFleetBoat()
    {
        return $this->belongsTo(EventClassFleetBoat::class);
    }
}
