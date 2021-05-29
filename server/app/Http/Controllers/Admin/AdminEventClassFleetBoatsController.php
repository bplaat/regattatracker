<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\boat;
use App\Models\Event;
use App\Models\EventClass;
use App\Models\EventClassFleet;
use App\Models\EventClassFleetBoat;
use Illuminate\Http\Request;

class AdminEventClassFleetBoatsController extends Controller
{
    // Admin event class fleet boats create route
    public function index(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet)
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $eventClassFleetBoats = Boat::searchCollection($eventClassFleet->boats, $query);
        } else {
            $eventClassFleetBoats = $eventClassFleet->boats;
        }
        $eventClassFleetBoats = $eventClassFleetBoats->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();

        $boats = Boat::all()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);

        // Return admin event class fleet boats index view
        return view('admin.events.classes.fleets.boats.index', [
            'event' => $event,
            'eventClass' => $eventClass,
            'eventClassFleet' => $eventClassFleet,
            'eventClassFleetBoats' => $eventClassFleetBoats,
            'boats' => $boats
        ]);
    }

    // Admin event class fleet boats store route
    public function store(Request $request, Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet)
    {
        $fields = $request->validate([
            'boat_id' => 'required|exists:boats,id'
        ]);

        $eventClassFleet->boats()->attach($fields['boat_id']);

        return redirect()->route('admin.events.classes.fleets.boats.index', [$event, $eventClass, $eventClassFleet]);
    }

    // Admin event class fleet boats edit route
    public function edit(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet, Boat $boat)
    {
        $eventClassFleetBoat = EventClassFleetBoat::where('event_class_fleet_id', $eventClassFleet->id)->where('boat_id', $boat->id)->first();

        return view('admin.events.classes.fleets.boats.edit', [
            'event' => $event,
            'eventClass' => $eventClass,
            'eventClassFleet' => $eventClassFleet,
            'boat' => $boat,
            'eventClassFleetBoat' => $eventClassFleetBoat
        ]);
    }

    // Admin event class fleet boats update route
    public function update(Request $request, Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet, Boat $boat)
    {
        $fields = $request->validate([
            'started_at_date' => 'nullable|date_format:Y-m-d',
            'started_at_time' => 'nullable|date_format:H:i:s',
            'finished_at_date' => 'nullable|date_format:Y-m-d',
            'finished_at_time' => 'nullable|date_format:H:i:s'
        ]);

        if ($fields['started_at_date'] != '' && $fields['started_at_time'] != '') {
            $eventClassFleet->boats()->updateExistingPivot($boat, [
                'started_at' => $fields['started_at_date'] . ' ' . $fields['started_at_time']
            ]);
        } else {
            $eventClassFleet->boats()->updateExistingPivot($boat, [
                'started_at' => null
            ]);
        }

        if ($fields['finished_at_date'] != '' && $fields['finished_at_time'] != '') {
            $eventClassFleet->boats()->updateExistingPivot($boat, [
                'finished_at' => $fields['finished_at_date'] . ' ' . $fields['finished_at_time']
            ]);
        } else {
            $eventClassFleet->boats()->updateExistingPivot($boat, [
                'finished_at' => null
            ]);
        }

        return redirect()->route('admin.events.classes.fleets.boats.index', [$event, $eventClass, $eventClassFleet]);
    }

    // Admin event class fleet boats delete route
    public function delete(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet, Boat $boat)
    {
        $eventClassFleet->boats()->detach($boat);

        return redirect()->route('admin.events.classes.fleets.boats.index', [$event, $eventClass, $eventClassFleet]);
    }
}
