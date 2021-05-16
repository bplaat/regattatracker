<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventClass;
use Illuminate\Http\Request;

class AdminEventClassesController extends Controller
{
    // Admin event class create route
    public function create(Event $event) {
        return view('admin.events.classes.create', ['event' => $event]);
    }

    // Admin event class store route
    public function store(Request $request, Event $event) {
        $fields = $request->validate([
            'name' => 'required|min:2|max:255'
        ]);

        EventClass::create([
           'name' => $fields['name'],
           'event_id' => $event->id
        ]);

        return redirect()->route('admin.events.show', ['event' => $event]);
    }

    // Admin event class update route
    public function update(Request $request, Event $event, EventClass $class) {
        $fields = $request->validate([
            'name' => 'required|min:2|max:255'
        ]);

        $class->update([
           'name' => $fields['name']
        ]);

        return redirect()->route('admin.events.show', ['event' => $event]);
    }

    // Admin event class edit route
    public function edit(Event $event, EventClass $class) {
        return view('admin.events.classes.edit', ['event' => $event, 'class' => $class]);
    }

    // Admin event class delete route
    public function delete(Event $event, EventClass $class) {
        $class->delete();

        return redirect()->route('admin.events.show', ['event' => $event]);
    }
}
