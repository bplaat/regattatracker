<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventClass;

class ApiEventClassesController extends Controller
{
    // Api event classes index route
    public function index(Event $event)
    {
        // Return the event classes
        return $event->classes->paginate(config('pagination.api.limit'));
    }

    // Api event classes show route
    public function show(Event $event, EventClass $eventClass)
    {
        // Activate relations (this is ugly I know)
        $eventClass->fleets;

        // Return the event class
        return $eventClass;
    }
}
