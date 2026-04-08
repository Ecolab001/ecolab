<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // ✅ ICI SEULEMENT
use Carbon\Carbon;

class RepresentativeController extends Controller
{
    public function index()
    {
        $representatives = User::where('role', 'representative')
            ->latest()
            ->paginate(20);

        return view('admin.representatives.index', compact('representatives'));
    }

    public function create()
    {
        return view('admin.representatives.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string',
            'password' => 'required|min:6',

            // 🔥 OBLIGATOIRE
            'identity_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        // 📄 Upload document
        $documentPath = null;

        if ($request->hasFile('identity_document')) {
            $documentPath = $request->file('identity_document')
                ->store('representatives/documents', 'public');
        }



User::create([
    'name' => $request->name,
    'email' => $request->email,
    'phone' => $request->phone,
    'password' => Hash::make($request->password),

    'role' => 'representative',
    'status' => 'active',

    // 🔥 OBLIGATOIRE POUR TON MIDDLEWARE
    'expires_at' => Carbon::now()->addMonths(3),

    'code' => 'REP-' . strtoupper(Str::random(6)),

    'identity_document' => $documentPath,
]);

        return redirect()->route('representatives.index')
            ->with('success', 'Représentant créé');
    }

    public function show(User $representative)
    {
        return view('admin.representatives.show', compact('representative'));
    }

    public function edit(User $representative)
    {
        return view('admin.representatives.edit', compact('representative'));
    }

    public function update(Request $request, User $representative)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
        ]);

        $representative->update($request->only('name', 'phone'));

        return redirect()->route('representatives.index')->with('success', 'Mis à jour');
    }

    public function destroy(User $representative)
    {
        $representative->update([
            'status' => 'suspended'
        ]);

        return back()->with('success', 'Représentant suspendu');
    }
}