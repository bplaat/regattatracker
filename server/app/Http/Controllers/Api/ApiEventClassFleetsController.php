<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventClass;
use App\Models\EventClassFleet;

class ApiEventClassFleetsController extends Controller
{
    // Api event class fleets index route
    public function index(Event $event, EventClass $eventClass)
    {
        // Return the event class fleets
        return $eventClass->fleets->paginate(config('pagination.api.limit'));
    }

    // Api event class fleets show route
    public function show(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet)
    {
        // Activate relations (this is ugly I know)
        $eventClassFleet->boats;

        // Return the event class fleet
        return $eventClassFleet;
    }
}
