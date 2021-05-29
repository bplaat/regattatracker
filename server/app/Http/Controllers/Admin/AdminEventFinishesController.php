<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventFinish;
use App\Rules\Latitude;
use App\Rules\Longitude;
use Illuminate\Http\Request;

class AdminEventFinishesController extends Controller
{
    // Admin event finishes create route
    public function create(Event $event)
    {
        return view('admin.events.finishes.create', ['event' => $event]);
    }

    // Admin event finishes store route
    public function store(Request $request, Event $event)
    {
        // Validate input
        $fields = $request->validate([
            'latitude_a' => ['required', new Latitude],
            'longitude_a' => ['required', new Longitude],
            'latitude_b' => ['required', new Latitude],
            'longitude_b' => ['required', new Longitude]
        ]);

        // Create event finish
        $event->finishes()->create([
            'latitude_a' => $fields['latitude_a'],
            'longitude_a' => $fields['longitude_a'],
            'latitude_b' => $fields['latitude_b'],
            'longitude_b' => $fields['longitude_b']
        ]);

        // Return to the admin event show page
        return redirect()->route('admin.events.show', $event);
    }

    // Admin event finishes edit route
    public function edit(Event $event, EventFinish $eventFinish)
    {
        return view('admin.events.finishes.edit', [
            'event' => $event,
            'eventFinish' => $eventFinish
        ]);
    }

    // Admin event finishes update route
    public function update(Request $request, Event $event, EventFinish $eventFinish)
    {
        // Validate input
        $fields = $request->validate([
            'latitude_a' => ['required', new Latitude],
            'longitude_a' => ['required', new Longitude],
            'latitude_b' => ['required', new Latitude],
            'longitude_b' => ['required', new Longitude]
        ]);

        // Update the event finish
        $eventFinish->update([
            'latitude_a' => $fields['latitude_a'],
            'longitude_a' => $fields['longitude_a'],
            'latitude_b' => $fields['latitude_b'],
            'longitude_b' => $fields['longitude_b']
        ]);

        // Return to the admin event show page
        return redirect()->route('admin.events.show', $event);
    }

    // Admin event finishes delete route
    public function delete(Event $event, EventFinish $eventFinish)
    {
        $eventFinish->delete();

        return redirect()->route('admin.events.show', $event);
    }
}
