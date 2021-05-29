<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\Event;
use App\Models\EventClass;
use App\Models\EventClassFleet;

class ApiEventClassFleetBoatsController extends Controller
{
    // Api event class fleet boats index route
    public function index(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet)
    {
        // Return the event class fleet boats
        return $eventClassFleet->boats->paginate(config('pagination.api.limit'));
    }

    // Api event class fleet boats show route
    public function show(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet, Boat $boat)
    {
        // Return the boat
        return $boat;
    }
}
