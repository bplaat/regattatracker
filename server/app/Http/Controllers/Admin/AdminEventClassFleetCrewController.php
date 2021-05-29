<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\EventClass;
use App\Models\EventClassFleet;
use App\Models\EventClassFleetCrew;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminEventClassFleetCrewController extends Controller
{
    // Admin event class fleet crews create route
    public function create(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet) {
        return view('admin.events.classes.fleets.crews.create', [
            'event' => $event,
            'eventClass' => $eventClass,
            'eventClassFleet' => $eventClassFleet
        ]);
    }

    // Admin event class fleet crews store route
    public function store(Request $request, Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet) {
        $fields = $request->validate([
            'name' => 'required|max:48'
        ]);

        EventClassFleetCrew::create([
            'event_class_fleet_id' => $eventClassFleet->id,
            'name' => $fields['name']
        ]);

        return redirect()->route('admin.events.show', ['event' => $event]);
    }

    // Admin crew show route
    public function show(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet) {
        // Get all the events finishes
//        $eventClassFleetCrews = $eventClassFleet->crews->paginate(config('pagination.web.limit'))->withQueryString();

        // Return the admin event show page
        return view('admin.events.classes.fleets.crews.show', [
            'event' => $event,
            'eventClass' => $eventClass,
            'eventClassFleet' => $eventClassFleet,
//            'eventClassFleetCrew' => $eventClassFleetCrew,
        ]);
    }

    // Admin event class fleet crews edit route
    public function edit(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet, EventClassFleetCrew $eventClassFleetCrew) {
        return view('admin.events.classes.fleets.crews.edit', [
            'event' => $event,
            'eventClass' => $eventClass,
            'eventClassFleet' => $eventClassFleet,
            'eventClassFleetCrew' => $eventClassFleetCrew
        ]);
    }

    // Admin event class fleet crew update route
    public function update(Request $request, Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet, EventClassFleetCrew $eventClassFleetCrew) {
        $fields = $request->validate([
            'name' => 'required|max:48'
        ]);

        $eventClassFleetCrew->update([
            'name' => $fields['name']
        ]);

        return redirect()->route('admin.events.show', ['event' => $event]);
    }

    // Admin event class fleet crews delete route
    public function delete(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet, EventClassFleetCrew $eventClassFleetCrew) {
        $eventClassFleetCrew->delete();

        return redirect()->route('admin.events.show', ['event' => $event]);
    }
}
