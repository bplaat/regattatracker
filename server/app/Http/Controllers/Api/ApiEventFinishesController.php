<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventFinish;

class ApiEventFinishesController extends Controller
{
    // Api event finishes index route
    public function index(Event $event)
    {
        // Return the event finishes
        return $event->finishes->paginate(config('pagination.api.limit'));
    }

    // Api event finishes show route
    public function show(Event $event, EventFinish $eventFinish)
    {
        // Return the event finish
        return $eventFinish;
    }
}
