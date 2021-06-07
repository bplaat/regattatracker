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

    // Get guest full name (firstname insertion lastname)
    public function getNameAttribute()
    {
        if ($this->insertion != null) {
            return $this->firstname . ' ' . $this->insertion . ' ' . $this->lastname;
        } else {
            return $this->firstname . ' ' . $this->lastname;
        }
    }

    // Get guest sort name (lastname, insertion firstname)
    public function getSortNameAttribute()
    {
        if ($this->insertion != null) {
            return $this->lastname . ', ' . $this->insertion . ' ' . $this->firstname;
        } else {
            return $this->lastname . ' ' . $this->firstname;
        }
    }

    // A event class fleet boat guest belongs to a event class fleet boat
    public function eventClassFleetBoat()
    {
        return $this->belongsTo(EventClassFleetBoat::class);
    }

    // Search collection by a query
    public static function searchCollection($collection, $query)
    {
        return $collection->filter(function ($guest) use ($query) {
            return Str::contains(strtolower($guest->firstname), strtolower($query)) ||
                Str::contains(strtolower($guest->insertion), strtolower($query)) ||
                Str::contains(strtolower($guest->lastname), strtolower($query)) ||
                Str::contains(strtolower($guest->email), strtolower($query));
        });
    }
}
