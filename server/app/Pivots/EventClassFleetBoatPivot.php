<?php

namespace App\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EventClassFleetBoatPivot extends Pivot
{
    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime'
    ];
}
