<?php

namespace App\Http\Controllers\Representative;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Event;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    public function index()
    {
        $candidates = Candidate::where('user_id', Auth::id())
            ->with(['event', 'module'])
            ->latest()
            ->paginate(15);

        return view('representative.candidates.index', compact('candidates'));
    }

    public function create()
    {
        $events = Event::where('status', 'active')->get();
        $modules = Module::all();

        return view('representative.candidates.create', compact('events', 'modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'event_id' => 'required',
            'module_id' => 'required',

            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',

             'terms' => 'accepted' //
        ]);

        // Upload photo
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('candidates/photos', 'public');
        }

        // Upload document
        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('candidates/documents', 'public');
        }

        $candidate = Candidate::create([
            'user_id' => Auth::id(),
            'event_id' => $request->event_id,
            'module_id' => $request->module_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'code' => 'CAND-' . strtoupper(uniqid()),
            'status' => 'pending',

            'photo' => $photoPath,
            'document' => $documentPath,
        ]);

        return redirect('/representative/candidates/' . $candidate->id)
            ->with('success', 'Candidat enregistré');
    }

    public function show(Candidate $candidate)
    {
        if ($candidate->user_id !== Auth::id()) {
            abort(403);
        }

        $candidate->load(['event', 'module', 'payments']);

        return view('representative.candidates.show', compact('candidate'));
    }

    public function destroy(Candidate $candidate)
    {
        if ($candidate->user_id !== Auth::id()) {
            abort(403);
        }

        $candidate->delete();

        return back()->with('success', 'Candidat supprimé');
    }
}