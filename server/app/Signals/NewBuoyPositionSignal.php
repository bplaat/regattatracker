<?php

namespace App\Signals;

use App\Models\BuoyPosition;

class NewBuoyPositionSignal extends Signal
{
    public function __construct(BuoyPosition $buoyPosition)
    {
        $this->sendSignal('new_buoy_position', [
            'buoy_position_id' => $buoyPosition->id
        ]);
    }
}
