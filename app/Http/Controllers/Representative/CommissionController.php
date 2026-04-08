<?php

namespace App\Http\Controllers\Representative;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Support\Facades\Auth;

class CommissionController extends Controller
{
    // 🔹 LISTE DES COMMISSIONS
    public function index()
    {
        $commissions = Commission::where('user_id', Auth::id())
            ->with('candidate')
            ->latest()
            ->paginate(15);

        $total = Commission::where('user_id', Auth::id())->sum('amount');

        $paid = Commission::where('user_id', Auth::id())
            ->where('status', 'paid')
            ->sum('amount');

        return view('representative.commissions.index', compact(
            'commissions',
            'total',
            'paid'
        ));
    }
}