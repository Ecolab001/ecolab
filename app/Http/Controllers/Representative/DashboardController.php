<?php

namespace App\Http\Controllers\Representative;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Commission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    $user = auth()->user();

    // 📅 Filtres dates
    $start = $request->start_date;
    $end = $request->end_date;

    $candidateQuery = \App\Models\Candidate::where('user_id', $user->id);
    $commissionQuery = \App\Models\Commission::where('user_id', $user->id);

    if ($start && $end) {
        $candidateQuery->whereBetween('created_at', [$start, $end]);
        $commissionQuery->whereBetween('created_at', [$start, $end]);
    }

    $totalCandidates = $candidateQuery->count();
    $paidCandidates = (clone $candidateQuery)->where('status', 'paid')->count();

    $commissions = $commissionQuery->sum('amount');
    $paidCommissions = (clone $commissionQuery)->where('status', 'paid')->sum('amount');

    $commissionsList = \App\Models\Commission::where('user_id', auth()->id())
    ->with('candidate')
    ->latest()
    ->get();
    
    // 📋 Liste candidats
    $candidates = $candidateQuery->latest()->paginate(10);

return view('representative.dashboard', compact(
    'totalCandidates',
    'paidCandidates',
    'commissions',
    'paidCommissions',
    'candidates',
    'commissionsList', 
    'start',
    'end'
));
}
}