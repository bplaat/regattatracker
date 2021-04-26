<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Finish;
use App\Rules\Latitude;
use App\Rules\Longitude;
use Illuminate\Http\Request;

class AdminFinishesController extends Controller
{
    // Admin finish store route
    public function store(Request $request, Event $event)
    {
        // Validate input
        $fields = $request->validate([
            'latitude_a' => ['required', new Latitude],
            'longitude_a' => ['required', new Longitude],
            'latitude_b' => ['required', new Latitude],
            'longitude_b' => ['required', new Longitude]
        ]);

        // Create finish
        Finish::create([
            'event' => $event->id,
            'latitude_a' => $fields['latitude_a'],
            'longitude_a' => $fields['longitude_a'],
            'latitude_b' => $fields['latitude_b'],
            'longitude_b' => $fields['longitude_b']
        ]);

        // Return to the admin event show page
        return redirect()->route('admin.events.show', $event);
    }

    // Admin finish update route
    public function update(Request $request, Event $event, Finish $finish)
    {
        // Validate input
        $fields = $request->validate([
            'latitude_a' => ['required', new Latitude],
            'longitude_a' => ['required', new Longitude],
            'latitude_b' => ['required', new Latitude],
            'longitude_b' => ['required', new Longitude]
        ]);

        // Update the finish.
        $finish->update([
            'latitude_a' => $fields['latitude_a'],
            'longitude_a' => $fields['longitude_a'],
            'latitude_b' => $fields['latitude_b'],
            'longitude_b' => $fields['longitude_b']
        ]);

        // Return to the admin event show page.
        return redirect()->route('admin.events.show', $event);
    }

    // Admin finish delete route
    public function delete(Finish $finish)
    {
        $finish->delete();
    }
}
