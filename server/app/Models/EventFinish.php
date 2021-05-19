<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventFinish extends Model
{
    protected $fillable = [
        'event_id',
        'latitude_a',
        'longitude_a',
        'latitude_b',
        'longitude_b'
    ];

    // A event finish belongs to an event
    public function event() {
        return $this->belongsTo(Event::class);
    }
}
