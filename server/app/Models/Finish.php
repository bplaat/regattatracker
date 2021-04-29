<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finish extends Model
{
    protected $fillable = [
        'event_id',
        'latitude_a',
        'longitude_a',
        'latitude_b',
        'longitude_b'
    ];

    // A finish has an event.
    public function event() {
        return Event::all()->where('id', '=', $this->event_id)->first();
    }
}
