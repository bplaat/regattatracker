<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventClassFleetCrew extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_class_fleet_id',
        'name'
    ];

    // A event class fleet belongs to an event class
    public function fleet() {
        return $this->belongsTo(EventClassFleet::class);
    }
}
