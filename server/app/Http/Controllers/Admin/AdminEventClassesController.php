<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventClass;
use Illuminate\Http\Request;

class AdminEventClassesController extends Controller
{
    // Admin event class store route
    public function store(Request $request, Event $event) {
        $fields = $request->validate([
            'name' => 'required|min:2|max:255'
        ]);

        Event::create([
           'name' => $fields['name'],
           'event_id' => $event->id
        ]);

        return redirect()->route('admin.events.show', ['event' => $event]);
    }

    // Admin event class update route
    public function update(Request $request, Event $event, EventClass $eventClass) {
        $fields = $request->validate([
            'name' => 'required|min:2|max:255'
        ]);

        $eventClass->update([
           'name' => $fields['name']
        ]);

        return redirect()->route('admin.events.show', ['event' => $event]);
    }

    // Admin event class edit route
    public function edit(Event $event, EventClass $eventClass) {
        return view('admin.events.classes.edit', ['event' => $event, 'class' => $eventClass]);
    }

    // Admin event class delete route
    public function delete(Event $event, EventClass $eventClass) {
        $eventClass->delete();

        return redirect()->route('admin.events.show', ['event' => $event]);
    }
}
