<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Center;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    public function index()
    {
        $centers = Center::latest()->paginate(20);

        return view('admin.centers.index', compact('centers'));
    }

    public function create()
    {
        return view('admin.centers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string',
            'domain' => 'nullable|string',
            'location' => 'nullable|string',
        ]);

        Center::create($request->all());

        return redirect()->route('centers.index')->with('success', 'Centre créé');
    }

    public function edit(Center $center)
    {
        return view('admin.centers.edit', compact('center'));
    }

    public function update(Request $request, Center $center)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $center->update($request->all());

        return redirect()->route('centers.index')->with('success', 'Centre mis à jour');
    }

    public function destroy(Center $center)
    {
        $center->delete();

        return redirect()->route('centers.index')->with('success', 'Centre supprimé');
    }
}