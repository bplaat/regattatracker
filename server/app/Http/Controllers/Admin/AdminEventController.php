<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminEventController extends Controller
{
    // Admin events index route
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
            ->paginate(config('pagination.web.limit'))->withQueryString();

        // Return admin boat index view
        return view('admin.events.index', ['events' => $events]);
    }

    // Admin events store route
    public function store(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:255',
            'start_date' => 'nullable|date_format:Y-m-d',
            'start_time' => 'nullable|date_format:H:i',
            'end_date' => 'nullable|date_format:Y-m-d',
            'end_time' => 'nullable|date_format:H:i'
        ]);

        // Create Event
        $event = Event::create([
            'name' => $fields['name'],
            'start' => $fields['start_date'] != null && $fields['start_time'] != null ? $fields['start_date'] . ' ' . $fields['start_time'] : null,
            'end' => $fields['end_date'] != null && $fields['end_time'] != null ? $fields['end_date'] . ' ' . $fields['end_time'] : null
        ]);

        // Go to the new event show page
        return redirect()->route('admin.events.show', $event);
    }

    // Admin events show route
    public function show(Event $event) {
        return view('admin.events.show', ['event' => $event]);
    }

    // Admin events edit route
    public function edit(Event $event) {
        return view('admin.events.edit', ['event' => $event]);
    }

    public function update(Request $request, Event $event) {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:255',
            'start_date' => 'nullable|date_format:Y-m-d',
            'start_time' => 'nullable|date_format:H:i',
            'end_date' => 'nullable|date_format:Y-m-d',
            'end_time' => 'nullable|date_format:H:i'
        ]);

        // Update event
        $event->update([
            'name' => $fields['name'],
            'start' => $fields['start_date'] != null && $fields['start_time'] != null ? $fields['start_date'] . ' ' . $fields['start_time'] : null,
            'end' => $fields['end_date'] != null && $fields['end_time'] != null ? $fields['end_date'] . ' ' . $fields['end_time'] : null
        ]);

        // Go to the event show page
        return redirect()->route('admin.events.show', $event);
    }

    // Admin events delete route
    public function delete(Event $event) {
        // Delete event
        $event->delete();

        // Go to the event index page
        return redirect()->route('admin.events.index');
    }

}
