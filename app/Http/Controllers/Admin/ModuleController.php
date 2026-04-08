<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Event;
use App\Models\Center;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::with(['event', 'center'])->latest()->paginate(20);

        return view('admin.modules.index', compact('modules'));
    }

    public function create()
    {
        $events = Event::all();
        $centers = Center::all();

        return view('admin.modules.create', compact('events', 'centers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'event_id' => 'required|exists:events,id',
            'center_id' => 'required|exists:centers,id',
            'capacity' => 'nullable|integer|min:1',
        ]);

        Module::create($request->all());

        return redirect()->route('modules.index')->with('success', 'Module créé');
    }

    public function edit(Module $module)
    {
        $events = Event::all();
        $centers = Center::all();

        return view('admin.modules.edit', compact('module', 'events', 'centers'));
    }

    public function update(Request $request, Module $module)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'event_id' => 'required|exists:events,id',
            'center_id' => 'required|exists:centers,id',
            'capacity' => 'nullable|integer|min:1',
        ]);

        $module->update($request->all());

        return redirect()->route('modules.index')->with('success', 'Module mis à jour');
    }

    public function destroy(Module $module)
    {
        $module->delete();

        return redirect()->route('modules.index')->with('success', 'Module supprimé');
    }
}