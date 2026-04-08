<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Commission::with(['user', 'candidate']);

        // 🔍 filtre par représentant
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // 🔍 filtre par statut
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $commissions = $query->latest()->paginate(20);

        $users = User::where('role', 'representative')->get();

        return view('admin.commissions.index', compact('commissions', 'users'));
    }

   public function pay(Request $request, $id)
{
    $commission = Commission::findOrFail($id);

    if ($commission->status === 'paid') {
        return back()->with('error', 'Déjà payé');
    }

    $request->validate([
        'payment_reference' => 'nullable|string',
        'payment_method' => 'nullable|string',
        'payment_note' => 'nullable|string',
    ]);

    $commission->update([
        'status' => 'paid',
        'paid_at' => now(),
        'payment_reference' => $request->payment_reference,
        'payment_method' => $request->payment_method,
        'payment_note' => $request->payment_note,
    ]);

    return back()->with('success', 'Commission payée');
}

    public function payAll($userId)
{
    $commissions = \App\Models\Commission::where('user_id', $userId)
        ->where('status', 'pending')
        ->get();

    foreach ($commissions as $c) {
        $c->update(['status' => 'paid']);
    }

    return back()->with('success', 'Toutes les commissions payées');
}
}