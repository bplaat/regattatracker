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
}
