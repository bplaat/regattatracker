<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventClass;
use App\Models\Fleet;
use Illuminate\Http\Request;

class AdminFleetsController extends Controller
{
    // Admin fleet store route
    public function store(Request $request, Event $event, EventClass $eventClass) {
        $fields = $request->validate([
            'name' => 'required|min:2|max:255'
        ]);

        Event::create([
            'name' => $fields['name'],
            'event_class_id' => $eventClass->id
        ]);

        return redirect()->route('admin.events.show', ['event' => $event]);
    }

    // Admin fleet update route
    public function update(Request $request, Event $event, Fleet $fleet) {
        $fields = $request->validate([
            'name' => 'required|min:2|max:255'
        ]);

        $fleet->update([
            'name' => $fields['name']
        ]);

        return redirect()->route('admin.events.show', ['event' => $event]);
    }

    // Admin fleet edit route
    public function edit(Event $event, EventClass $eventClass, Fleet $fleet) {
        return view('admin.events.classes.fleets.edit', ['event' => $event, 'class' => $eventClass, 'fleet' => $fleet]);
    }

    // Admin fleet delete route
    public function delete(Event $event, Fleet $fleet) {
        $fleet->delete();

        return redirect()->route('admin.events.show', ['event' => $event]);
    }
}
