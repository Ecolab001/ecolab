<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        $query = Candidate::with(['event', 'module', 'user']);

        if ($request->event_id) {
            $query->where('event_id', $request->event_id);
        }

        if ($request->module_id) {
            $query->where('module_id', $request->module_id);
        }

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->code) {
        $query->where('code', 'like', '%' . $request->code . '%');
        }

        $candidates = $query->latest()->paginate(20);

        return view('admin.candidates.index', compact('candidates'));
    }

    public function show(Candidate $candidate)
    {
        $candidate->load(['event', 'module', 'user', 'payments', 'commission']);

        return view('admin.candidates.show', compact('candidate'));
    }

    public function update(Request $request, Candidate $candidate)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,validated,rejected,completed'
        ]);

        $candidate->update([
            'status' => $request->status
        ]);

        // ✅ EMAIL SI VALIDÉ
        if ($request->status === 'validated') {
            Mail::raw('Votre inscription est validée ✅', function ($message) use ($candidate) {
                $message->to($candidate->user->email)
                        ->subject('Validation de votre inscription');
            });
        }

        // ❌ EMAIL SI REJETÉ
        if ($request->status === 'rejected') {
            Mail::raw('Votre inscription a été rejetée ❌', function ($message) use ($candidate) {
                $message->to($candidate->user->email)
                        ->subject('Rejet de votre inscription');
            });
        }

        return back()->with('success', 'Statut mis à jour');
    }

    public function replaceDocs(Request $request, $id)
    {
        $candidate = Candidate::findOrFail($id);

        if ($request->hasFile('photo')) {
            $candidate->photo = $request->file('photo')->store('candidates/photos', 'public');
        }

        if ($request->hasFile('document')) {
            $candidate->document = $request->file('document')->store('candidates/documents', 'public');
        }

        $candidate->save();

        return back()->with('success', 'Documents mis à jour');
    }

    public function destroy(Candidate $candidate)
    {
        $candidate->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Candidat rejeté');
    }
}