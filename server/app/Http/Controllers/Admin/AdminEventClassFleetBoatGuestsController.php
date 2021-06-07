<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\Event;
use App\Models\EventClass;
use App\Models\EventClassFleet;
use App\Models\EventClassFleetBoat;
use App\Models\EventClassFleetBoatGuest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminEventClassFleetBoatGuestsController extends Controller
{
    // Admin event class fleet boat guest create route
    public function create(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet, Boat $boat)
    {
        $eventClassFleetBoat = EventClassFleetBoat::where('event_class_fleet_id', $eventClassFleet->id)->where('boat_id', $boat->id)->first();

        return view('admin.events.classes.fleets.boats.guests.create', [
            'event' => $event,
            'eventClass' => $eventClass,
            'eventClassFleet' => $eventClassFleet,
            'boat' => $boat,
            'eventClassFleetBoat' => $eventClassFleetBoat
        ]);
    }

    // Admin event class fleet boat guest store route
    public function store(Request $request, Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet, Boat $boat)
    {
        $eventClassFleetBoat = EventClassFleetBoat::where('event_class_fleet_id', $eventClassFleet->id)->where('boat_id', $boat->id)->first();

        // Validate input
        $fields = $request->validate([
            'firstname' => 'required|min:2|max:48',
            'insertion' => 'nullable|max:16',
            'lastname' => 'required|min:2|max:48',
            'gender' => 'nullable|integer|digits_between:' . User::GENDER_MALE . ',' . User::GENDER_OTHER,
            'birthday' => 'nullable|date',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|max:255',
            'address' => 'nullable|min:2|max:255',
            'postcode' => 'nullable|min:2|max:255',
            'city' => 'nullable|min:2|max:255',
            'country' => 'nullable|min:2|max:255'
        ]);

        // Create guest
        $eventClassFleetBoat->guests()->create([
            'firstname' => $fields['firstname'],
            'insertion' => $fields['insertion'],
            'lastname' => $fields['lastname'],
            'gender' => $fields['gender'],
            'birthday' => $fields['birthday'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
            'address' => $fields['address'],
            'postcode' => $fields['postcode'],
            'city' => $fields['city'],
            'country' => $fields['country']
        ]);

        // Go to the event class fleet boat users index page
        return redirect()->route('admin.events.classes.fleets.boats.users.index', [$event, $eventClass, $eventClassFleet, $boat]);
    }

    // Admin event class fleet boat guest edit route
    public function edit(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet, Boat $boat, EventClassFleetBoatGuest $eventClassFleetBoatGuest)
    {
        $eventClassFleetBoat = EventClassFleetBoat::where('event_class_fleet_id', $eventClassFleet->id)->where('boat_id', $boat->id)->first();

        return view('admin.events.classes.fleets.boats.guests.edit', [
            'event' => $event,
            'eventClass' => $eventClass,
            'eventClassFleet' => $eventClassFleet,
            'boat' => $boat,
            'eventClassFleetBoat' => $eventClassFleetBoat,
            'eventClassFleetBoatGuest' => $eventClassFleetBoatGuest
        ]);
    }

    // Admin event class fleet boat guest update route
    public function update(Request $request, Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet, Boat $boat, EventClassFleetBoatGuest $eventClassFleetBoatGuest)
    {
        $eventClassFleetBoat = EventClassFleetBoat::where('event_class_fleet_id', $eventClassFleet->id)->where('boat_id', $boat->id)->first();

        // Validate input
        $fields = $request->validate([
            'firstname' => 'required|min:2|max:48',
            'insertion' => 'nullable|max:16',
            'lastname' => 'required|min:2|max:48',
            'gender' => 'nullable|integer|digits_between:' . User::GENDER_MALE . ',' . User::GENDER_OTHER,
            'birthday' => 'nullable|date',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|max:255',
            'address' => 'nullable|min:2|max:255',
            'postcode' => 'nullable|min:2|max:255',
            'city' => 'nullable|min:2|max:255',
            'country' => 'nullable|min:2|max:255'
        ]);

        // Update guest
        $eventClassFleetBoatGuest->update([
            'firstname' => $fields['firstname'],
            'insertion' => $fields['insertion'],
            'lastname' => $fields['lastname'],
            'gender' => $fields['gender'],
            'birthday' => $fields['birthday'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
            'address' => $fields['address'],
            'postcode' => $fields['postcode'],
            'city' => $fields['city'],
            'country' => $fields['country']
        ]);

        // Go to the event class fleet boat users index page
        return redirect()->route('admin.events.classes.fleets.boats.users.index', [$event, $eventClass, $eventClassFleet, $boat]);
    }

    // Admin event class fleet boat guest delete route
    public function delete(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet, Boat $boat, EventClassFleetBoatGuest $eventClassFleetBoatGuest)
    {
        // Delete guest
        $eventClassFleetBoatGuest->delete();

        // Go to the event class fleet boat users index page
        return redirect()->route('admin.events.classes.fleets.boats.users.index', [$event, $eventClass, $eventClassFleet, $boat]);
    }
}
