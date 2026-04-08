<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Payment;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 📊 Candidats
        $totalCandidates = Candidate::count();
        $paidCandidates = Candidate::where('status', 'paid')->count();

        // 💰 Revenus abonnements
        $subscriptionRevenue = Payment::where('type', 'subscription_payment')
            ->where('status', 'paid')
            ->sum('amount');

        // 💰 Revenus inscriptions
        $candidateRevenue = Payment::where('type', 'candidate_payment')
            ->where('status', 'paid')
            ->sum('amount');

        // 💸 Commissions
        $totalCommissions = Commission::sum('amount');
        $paidCommissions = Commission::where('status', 'paid')->sum('amount');

        // 👥 Représentants
        $representatives = User::where('role', 'representative')->count();

        return view('admin.dashboard.index', compact(
            'totalCandidates',
            'paidCandidates',
            'subscriptionRevenue',
            'candidateRevenue',
            'totalCommissions',
            'paidCommissions',
            'representatives'
        ));
    }

 public function reports(Request $request)
{
    $start = $request->start_date;
    $end = $request->end_date;

    // 🔥 GLOBAL
    $candidateQuery = \App\Models\Candidate::query();
    $paymentQuery = \App\Models\Payment::where('status', 'paid');
    $commissionQuery = \App\Models\Commission::query();

    if ($start && $end) {
        $candidateQuery->whereBetween('created_at', [$start, $end]);
        $paymentQuery->whereBetween('created_at', [$start, $end]);
        $commissionQuery->whereBetween('created_at', [$start, $end]);
    }

    $totalCandidates = $candidateQuery->count();
    $paidCandidates = (clone $candidateQuery)->where('status', 'paid')->count();

    $subscriptionRevenue = (clone $paymentQuery)
        ->where('type', 'subscription_payment')
        ->sum('amount');

    $candidateRevenue = (clone $paymentQuery)
        ->where('type', 'candidate_payment')
        ->sum('amount');

    $commissions = $commissionQuery->sum('amount');
    $paidCommissions = (clone $commissionQuery)
        ->where('status', 'paid')
        ->sum('amount');

    // 🔥 REPRESENTANTS
    $representatives = \App\Models\User::where('role', 'representative')
        ->withCount(['candidates' => function ($q) use ($start, $end) {
            if ($start && $end) {
                $q->whereBetween('created_at', [$start, $end]);
            }
        }])
        ->get()
        ->map(function ($user) use ($start, $end) {

            $subscriptionQuery = \App\Models\Payment::where('user_id', $user->id)
                ->where('type', 'subscription_payment')
                ->where('status', 'paid');

            $candidateQuery = \App\Models\Payment::where('user_id', $user->id)
                ->where('type', 'candidate_payment')
                ->where('status', 'paid');

            $commissionQuery = \App\Models\Commission::where('user_id', $user->id);

            if ($start && $end) {
                $subscriptionQuery->whereBetween('created_at', [$start, $end]);
                $candidateQuery->whereBetween('created_at', [$start, $end]);
                $commissionQuery->whereBetween('created_at', [$start, $end]);
            }

            return [
                'name' => $user->name,
                'phone' => $user->phone,
                'candidates' => $user->candidates_count,
                'subscriptionRevenue' => $subscriptionQuery->sum('amount'),
                'candidateRevenue' => $candidateQuery->sum('amount'),
                'commissions' => $commissionQuery->sum('amount'),
                'paidCommissions' => $commissionQuery->where('status', 'paid')->sum('amount'),
            ];
        });

    return view('admin.reports.index', compact(
        'totalCandidates',
        'paidCandidates',
        'subscriptionRevenue',
        'candidateRevenue',
        'commissions',
        'paidCommissions',
        'representatives',
        'start',
        'end'
    ));
}
}