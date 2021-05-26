<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'flag',
    ];

    // A event class belongs to an event.
    public function event() {
        return $this->belongsTo(Event::class);
    }

    // An event class has many fleets
    public function fleets() {
        return $this->hasMany(EventClassFleet::class);
    }
}
