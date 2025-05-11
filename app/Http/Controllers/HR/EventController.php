<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('date', 'asc')->get();
        return view('hr.events.index', compact('events'));
    }

    public function create()
    {
        return view('hr.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'nullable|string|max:20',
            'type' => 'required|string|max:20',
            'employee_id' => 'nullable|exists:employees,id',
        ]);

        Event::create($request->all());

        return redirect()->route('hr.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        return view('hr.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'nullable|string|max:20',
            'type' => 'required|string|max:20',
            'employee_id' => 'nullable|exists:employees,id',
        ]);

        $event->update($request->all());

        return redirect()->route('hr.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('hr.events.index')->with('success', 'Event deleted successfully.');
    }
}
