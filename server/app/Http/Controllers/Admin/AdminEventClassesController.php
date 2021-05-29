<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventClass;
use Illuminate\Http\Request;

class AdminEventClassesController extends Controller
{
    // Admin event classes create route
    public function create(Event $event)
    {
        return view('admin.events.classes.create', ['event' => $event]);
    }

    // Admin event classes store route
    public function store(Request $request, Event $event)
    {
        $fields = $request->validate([
            'name' => 'required|min:2|max:48',
            'flag' => 'size:1|regex:/[A-Z-]/'
        ]);

        EventClass::create([
            'event_id' => $event->id,
            'name' => $fields['name'],
            'flag' => $fields['flag'] == "-" ? NULL : $fields['flag']
        ]);

        return redirect()->route('admin.events.show', $event);
    }

    // Admin event classes edit route
    public function edit(Event $event, EventClass $eventClass)
    {
        return view('admin.events.classes.edit', ['event' => $event, 'eventClass' => $eventClass]);
    }

    // Admin event classes update route
    public function update(Request $request, Event $event, EventClass $eventClass)
    {
        $fields = $request->validate([
            'name' => 'required|min:2|max:48',
            'flag' => 'size:1|regex:/[A-Z-]/'
        ]);

        $eventClass->update([
            'name' => $fields['name'],
            'flag' => $fields['flag'] == "-" ? NULL : $fields['flag']
        ]);

        return redirect()->route('admin.events.show', $event);
    }

    // Admin event classes delete route
    public function delete(Event $event, EventClass $eventClass)
    {
        $eventClass->delete();

        return redirect()->route('admin.events.show', $event);
    }
}
