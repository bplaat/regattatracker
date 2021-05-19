<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoatEventClassFleet extends Model
{
    protected $table = 'boat_event_class_fleet';

    protected $fillable = [
        'boat_id',
        'event_class_fleet_id'
    ];
}
