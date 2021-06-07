<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\Event;
use App\Models\EventClass;
use App\Models\EventClassFleet;
use App\Models\EventClassFleetBoat;
use App\Models\User;
use Illuminate\Http\Request;

class AdminEventClassFleetBoatUsersController extends Controller
{
    // Admin event class fleet boat users create route
    public function index(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet, Boat $boat)
    {
        $eventClassFleetBoat = EventClassFleetBoat::where('event_class_fleet_id', $eventClassFleet->id)->where('boat_id', $boat->id)->first();

        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $boatUsers = User::searchCollection($eventClassFleetBoat->users, $query);
            $boatGuests = EventClassFleetBoatGuest::searchCollection($eventClassFleetBoat->guests, $query);
        } else {
            $boatUsers = $eventClassFleetBoat->users;
            $boatGuests = $eventClassFleetBoat->guests;
        }
        $boatUsers = $boatUsers->sortBy('sortName', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();
        $users = User::all()->sortBy('sortName', SORT_NATURAL | SORT_FLAG_CASE);
        $boatGuests = $boatGuests->sortBy('sortName', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();

        return view('admin.events.classes.fleets.boats.users.index', [
            'event' => $event,
            'eventClass' => $eventClass,
            'eventClassFleet' => $eventClassFleet,
            'boat' => $boat,
            'eventClassFleetBoat' => $eventClassFleetBoat,
            'boatUsers' => $boatUsers,
            'users' => $users,
            'boatGuests' => $boatGuests
        ]);
    }

    // Admin event class fleet boat users store route
    public function store(Request $request, Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet, Boat $boat)
    {
        $fields = $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $eventClassFleetBoat = EventClassFleetBoat::where('event_class_fleet_id', $eventClassFleet->id)->where('boat_id', $boat->id)->first();
        $eventClassFleetBoat->users()->attach($fields['user_id']);

        return redirect()->route('admin.events.classes.fleets.boats.users.index', [$event, $eventClass, $eventClassFleet, $boat]);
    }

    // Admin event class fleet boat users delete route
    public function delete(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet, Boat $boat, User $user)
    {
        $eventClassFleetBoat = EventClassFleetBoat::where('event_class_fleet_id', $eventClassFleet->id)->where('boat_id', $boat->id)->first();
        $eventClassFleetBoat->users()->detach($user);

        return redirect()->route('admin.events.classes.fleets.boats.users.index', [$event, $eventClass, $eventClassFleet, $boat]);
    }
}
