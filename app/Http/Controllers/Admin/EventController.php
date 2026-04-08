<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // 🔹 LISTE
    public function index()
{
    $events = Event::latest()->paginate(10);
    return view('admin.events.index', compact('events'));
}

    // 🔹 FORMULAIRE CRÉATION
    public function create()
    {
        return view('admin.events.create');
    }

    // 🔹 ENREGISTRER
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string',
            'capacity' => 'required|integer|min:1',
        ]);

        Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'status' => 'draft',
            'is_visible' => false,
        ]);

        return redirect()->route('events.index')->with('success', 'Événement créé avec succès');
    }

    // 🔹 EDIT
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    // 🔹 UPDATE
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'location' => 'required|string',
            'capacity' => 'required|integer|min:1',
        ]);

        $event->update($request->all());

        return redirect()->route('events.index')->with('success', 'Événement modifié');
    }

    // 🔹 DELETE
    public function destroy(Event $event)
    {
        $event->delete();

        return back()->with('success', 'Événement supprimé');
    }

    // 🔥 ACTIVER / DÉSACTIVER
    public function toggle(Event $event)
    {
        $event->update([
            'status' => $event->status === 'active' ? 'draft' : 'active'
        ]);

        return back()->with('success', 'Statut modifié');
    }
}