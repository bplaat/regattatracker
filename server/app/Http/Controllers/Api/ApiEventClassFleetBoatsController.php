<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Boat;
use App\Models\Event;
use App\Models\EventClass;
use App\Models\EventClassFleet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiEventClassFleetBoatsController extends Controller
{
    // Api event class fleet boats index route
    public function index(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet)
    {
        // Return the event class fleet boats
        return $eventClassFleet->boats->paginate(config('pagination.api.limit'));
    }

    // Api event class fleet boats store route
    public function store(Request $request, Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet)
    {
        // Validate input
        $validation = Validator::make($request->all(), [
            'boat_id' => 'required|exists:boats,id',
            'started_at_date' => 'nullable|date_format:Y-m-d',
            'started_at_time' => 'nullable|date_format:H:i:s',
            'finished_at_date' => 'nullable|date_format:Y-m-d',
            'finished_at_time' => 'nullable|date_format:H:i:s'
        ]);
        if ($validation->fails()) {
            return response(['errors' => $validation->errors()], 400);
        }

        // Attach boat to event class fleet
        $boat = Boat::find(request('boat_id'));
        $eventClassFleet->boats()->attach($boat);

        // Update started at when given
        if (request('started_at_date') != '' && request('started_at_time') != '') {
            $eventClassFleet->boats()->updateExistingPivot($boat, [
                'started_at' => request('started_at_date') . ' ' . request('started_at_time')
            ]);
        } else {
            $eventClassFleet->boats()->updateExistingPivot($boat, [
                'started_at' => null
            ]);
        }

        // Update finished at when given
        if (request('finished_at_date') != '' && request('finished_at_time') != '') {
            $eventClassFleet->boats()->updateExistingPivot($boat, [
                'finished_at' => request('finished_at_date') . ' ' . request('finished_at_time')
            ]);
        } else {
            $eventClassFleet->boats()->updateExistingPivot($boat, [
                'finished_at' => null
            ]);
        }

        // Return boat with pivot info
        return $eventClassFleet->boats()->find($boat->id);
    }

    // Api event class fleet boats show route
    public function show(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet, Boat $boat)
    {
        // Return the boat
        return $eventClassFleet->boats()->find($boat->id);
    }

    // Api event class fleet boats update route
    public function update(Request $request, Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet, Boat $boat)
    {
        // Validate input
        $validation = Validator::make($request->all(), [
            'started_at_date' => 'nullable|date_format:Y-m-d',
            'started_at_time' => 'nullable|date_format:H:i:s',
            'finished_at_date' => 'nullable|date_format:Y-m-d',
            'finished_at_time' => 'nullable|date_format:H:i:s'
        ]);
        if ($validation->fails()) {
            return response(['errors' => $validation->errors()], 400);
        }

        // Update started at when given
        if (request('started_at_date') != '' && request('started_at_time') != '') {
            $eventClassFleet->boats()->updateExistingPivot($boat, [
                'started_at' => request('started_at_date') . ' ' . request('started_at_time')
            ]);
        } else {
            $eventClassFleet->boats()->updateExistingPivot($boat, [
                'started_at' => null
            ]);
        }

        // Update finished at when given
        if (request('finished_at_date') != '' && request('finished_at_time') != '') {
            $eventClassFleet->boats()->updateExistingPivot($boat, [
                'finished_at' => request('finished_at_date') . ' ' . request('finished_at_time')
            ]);
        } else {
            $eventClassFleet->boats()->updateExistingPivot($boat, [
                'finished_at' => null
            ]);
        }

        // Return boat with pivot info
        return $eventClassFleet->boats()->find($boat->id);
    }

    // Api event class fleet boats delete route
    public function delete(Event $event, EventClass $eventClass, EventClassFleet $eventClassFleet, Boat $boat)
    {
        // Delete event class fleet boat
        $eventClassFleet->boats()->detach($boat);

        // Return success message
        return [
            'message' => 'Your event class fleet boat has been deleted!'
        ];
    }
}
