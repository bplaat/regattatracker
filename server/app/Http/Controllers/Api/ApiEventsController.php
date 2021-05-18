<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiEventsController extends Controller
{
    // Api events update route
    public function update(Request $request, Event $event)
    {
        // Validate input
        $validation = Validator::make($request->all(), [
            'connected' => 'required|boolean',
            'path' => 'required|json'
        ]);
        if ($validation->fails()) {
            return response(['errors' => $validation->errors()], 400);
        }

        // Create buoy position
        $event->update([
            'connected' => request('connected'),
            'path' => request('path')
        ]);

        return $event;
    }
}
