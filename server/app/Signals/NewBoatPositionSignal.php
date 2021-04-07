<?php

namespace App\Signals;

use App\Models\BoatPosition;

class NewBoatPositionSignal extends Signal
{
    public function __construct(BoatPosition $boatPosition)
    {
        $this->sendSignal('new_boat_position', [
            'boat_position_id' => $boatPosition->id
        ]);
    }
}
