<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventClassFleetBoat extends Model
{
    protected $table = 'event_class_fleet_boat';

    protected $fillable = [
        'event_class_fleet_id',
        'boat_id',
        'started_at',
        'finished_at'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime'
    ];

    // A event class fleet boat belongs to many users
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    // A event class fleet boat has many guests
    public function guests()
    {
        return $this->hasMany(EventClassFleetBoatGuest::class);
    }
}
