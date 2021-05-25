<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventFinish;
use App\Rules\Latitude;
use App\Rules\Longitude;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiEventFinishesController extends Controller
{
    // Api event finishes index route
    public function index(Event $event)
    {
        // Return the event finishes
        return $event->finishes->paginate(config('pagination.api.limit'));
    }

    // Api event finishes store route
    public function store(Request $request, Event $event)
    {
        // Validate input
        $validation = Validator::make($request->all(), [
            'latitude_a' => ['required', new Latitude],
            'longitude_a' => ['required', new Longitude],
            'latitude_b' => ['required', new Latitude],
            'longitude_b' => ['required', new Longitude]
        ]);
        if ($validation->fails()) {
            return response(['errors' => $validation->errors()], 400);
        }

        // Create event finish
        $eventFinish = $event->finishes()->create([
            'latitude_a' => request('latitude_a'),
            'longitude_a' => request('longitude_a'),
            'latitude_b' => request('latitude_b'),
            'longitude_b' => request('longitude_b')
        ]);

        return $eventFinish;
    }

    // Api event finishes show route
    public function show(Event $event, EventFinish $eventFinish)
    {
        // Return the event finish
        return $eventFinish;
    }

    // Api event finishes update route
    public function update(Request $request, Event $event, EventFinish $eventFinish)
    {
        // Validate input
        $validation = Validator::make($request->all(), [
            'latitude_a' => ['required', new Latitude],
            'longitude_a' => ['required', new Longitude],
            'latitude_b' => ['required', new Latitude],
            'longitude_b' => ['required', new Longitude]
        ]);
        if ($validation->fails()) {
            return response(['errors' => $validation->errors()], 400);
        }

        // Update event finish
        $eventFinish->update([
            'latitude_a' => request('latitude_a'),
            'longitude_a' => request('longitude_a'),
            'latitude_b' => request('latitude_b'),
            'longitude_b' => request('longitude_b')
        ]);

        return $eventFinish;
    }

    // Api event finishes delete route
    public function delete(Request $request, Event $event, EventFinish $eventFinish)
    {
        // Delete event finish
        $eventFinish->delete();

        // Return success message
        return [
            'message' => 'Your event finish has been deleted!'
        ];
    }
}
