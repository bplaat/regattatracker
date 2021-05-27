<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiEventsController extends Controller
{
    // Api events index route
    public function index()
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $events = Event::search($query)->get();
        } else {
            $events = Event::all();
        }
        $events = $events->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.api.limit'))->withQueryString();

        // Return the events
        return $events;
    }

    // Api events store route
    public function store(Request $request)
    {
        // Validate input
        $validation = Validator::make($request->all(), [
            'name' => 'required|min:2|max:48',
            'start' => 'nullable|date_format:Y-m-d',
            'end_dendate' => 'nullable|date_format:Y-m-d',
            'connected' => 'required|integer|digits_between:' . Event::CONNECTED_FALSE . ',' . Event::CONNECTED_TRUE
        ]);
        if ($validation->fails()) {
            return response(['errors' => $validation->errors()], 400);
        }

        // Create event
        $event = Event::create([
            'name' => request('name'),
            'start' => request('start'),
            'end' => request('end'),
            'connected' => request('connected'),
            'path' => '[]'
        ]);

        return $event;
    }

    // Api events show route
    public function show(Event $event)
    {
        // Activate relations (this is ugly I know)
        $event->finishes;
        $event->classes;

        // Return the event
        return $event;
    }

    // Api events update route
    public function update(Request $request, Event $event)
    {
        // Validate input
        $validation = Validator::make($request->all(), [
            'name' => 'required|min:2|max:48',
            'start' => 'nullable|date_format:Y-m-d',
            'end' => 'nullable|date_format:Y-m-d',
            'connected' => 'required|integer|digits_between:' . Event::CONNECTED_FALSE . ',' . Event::CONNECTED_TRUE
        ]);
        if ($validation->fails()) {
            return response(['errors' => $validation->errors()], 400);
        }

        // Update event
        $event->update([
            'name' => request('name'),
            'start' => request('start'),
            'end' => request('end'),
            'connected' => request('connected')
        ]);

        // Update event path when given
        if (request('path') != '') {
            $validation = Validator::make($request->all(), [
                'path' => 'required|json',
            ]);
            if ($validation->fails()) {
                return response(['errors' => $validation->errors()], 400);
            }

            $event->update([
                'path' => request('path')
            ]);
        }

        return $event;
    }

    // Api event delete route
    public function delete(Request $request, Event $event)
    {
        // Delete event
        $event->delete();

        // Return success message
        return [
            'message' => 'Your event has been deleted!'
        ];
    }
}
