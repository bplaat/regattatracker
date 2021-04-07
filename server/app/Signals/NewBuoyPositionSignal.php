<?php

namespace App\Signals;

use App\Models\BuoyPosition;

class NewbuoyPositionSignal extends Signal
{
    public function __construct(PuoyPosition $buoyPosition)
    {
        $this->sendSignal('new_buoy_position', [
            'buoy_position_id' => $buoyPosition->id
        ]);
    }
}
