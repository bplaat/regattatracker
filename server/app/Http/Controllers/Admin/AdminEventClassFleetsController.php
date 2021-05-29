<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventClass;
use App\Models\EventClassFleet;
use Illuminate\Http\Request;

class AdminEventClassFleetsController extends Controller
{
    // Admin event class fleets create route
    public function create(Event $event, EventClass $eventClass)
    {
        return view('admin.events.classes.fleets.create', [
            'event' => $event,
            'eventClass' => $eventClass
        ]);
    }

    // Admin event class fleets store route
    public function store(Request $request, Event $event, EventClass $eventClass)
    {
        $fields = $request->validate([
            'name' => 'required|max:48'
        ]);

        EventClassFleet::create([
            'event_class_id' => $eventClass->id,
            'name' => $fields['name']
        ]);

        return redirect()->route('admin.events.show', $event);
    }

    // Admin event class fleets edit route
    public function edit(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet)
    {
        return view('admin.events.classes.fleets.edit', [
            'event' => $event,
            'eventClass' => $eventClass,
            'eventClassFleet' => $eventClassFleet
        ]);
    }

    // Admin event class fleets update route
    public function update(Request $request, Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet)
    {
        $fields = $request->validate([
            'name' => 'required|max:48'
        ]);

        $eventClassFleet->update([
            'name' => $fields['name']
        ]);

        return redirect()->route('admin.events.show', $event);
    }

    // Admin event class fleets delete route
    public function delete(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet)
    {
        $eventClassFleet->delete();

        return redirect()->route('admin.events.show', $event);
    }
}
