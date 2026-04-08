@extends('layouts.app')

@section('content')

<div class="space-y-8">

@php
    $user = auth()->user();
    $daysLeft = $user->expires_at ? now()->diffInDays($user->expires_at, false) : 0;
@endphp

<div class="bg-white p-5 rounded-xl shadow-sm border flex flex-col md:flex-row justify-between items-center gap-4">

    <div>
        <p class="text-sm text-gray-500">Abonnement</p>

        @if($user->status === 'active' && $daysLeft > 0)
            <p class="text-lg font-bold text-green-600">
                Actif ({{ $daysLeft }} jours restants)
            </p>
            <p class="text-sm text-gray-500">
                Expire le {{ $user->expires_at->format('d/m/Y') }}
            </p>
        @else
            <p class="text-lg font-bold text-red-600">
                Expiré
            </p>
            <p class="text-sm text-gray-500">
                Veuillez renouveler votre abonnement
            </p>
        @endif
    </div>

    <!-- ACTION -->
    <div>
<form method="POST" action="{{ route('subscription.pay') }}">
    @csrf

    <input type="hidden" name="phone" value="{{ auth()->user()->phone }}">

    <button type="submit"
        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
        💳 Payer abonnement
    </button>
</form>
    </div>

</div>
    <!-- HEADER -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">📊 Tableau de bord</h1>
        <a href="{{ route('representative.candidates.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
            ➕ Inscrire un participant
        </a>
    </div>

    <!-- 🔎 FILTRE -->
    <form method="GET" class="flex flex-wrap gap-3 items-center bg-white p-4 rounded-xl shadow-sm border">
        <input type="date" name="start_date" value="{{ $start }}" class="border p-2 rounded">
        <input type="date" name="end_date" value="{{ $end }}" class="border p-2 rounded">

        <button class="bg-gray-800 text-white px-4 py-2 rounded">
            Filtrer
        </button>
    </form>

    <!-- 🔢 STATS MODERNES -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white p-5 rounded-xl shadow-sm border">
            <p class="text-sm text-gray-500">Candidats</p>
            <p class="text-2xl font-bold">{{ $totalCandidates }}</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border">
            <p class="text-sm text-gray-500">Payés</p>
            <p class="text-2xl font-bold text-green-600">{{ $paidCandidates }}</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border">
            <p class="text-sm text-gray-500">Commissions gagnées</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $commissions }} FCFA</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border">
            <p class="text-sm text-gray-500">Commissions payées</p>
            <p class="text-2xl font-bold text-green-600">{{ $paidCommissions }} FCFA</p>
        </div>

    </div>

    <!-- 📊 PERFORMANCE -->
    <div class="bg-white p-5 rounded-xl shadow-sm border">
        <h2 class="font-semibold mb-2 text-gray-800">📈 Performance</h2>

        <p class="text-gray-600">
            Taux de conversion :
            <b class="text-green-600">
                {{ $totalCandidates > 0 ? round(($paidCandidates / $totalCandidates) * 100, 2) : 0 }} %
            </b>
        </p>
    </div>

    <!-- 📋 CANDIDATS -->
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

        <div class="p-4 flex justify-between items-center">
            <h2 class="font-semibold text-gray-800">👥 Mes candidats</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="p-3 text-left">Nom</th>
                        <th class="p-3 text-left">Téléphone</th>
                        <th class="p-3 text-left">Statut</th>
                        <th class="p-3 text-left">Date</th>
                        <th class="p-3 text-left">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($candidates as $c)
                        <tr class="border-t hover:bg-gray-50">

                            <td class="p-3 font-medium">
                                {{ $c->first_name }} {{ $c->last_name }}
                            </td>

                            <td class="p-3">{{ $c->phone }}</td>

                            <td class="p-3">
                                @if($c->status === 'paid')
                                    <span class="text-green-600 font-semibold">Payé</span>
                                @else
                                    <span class="text-orange-500 font-semibold">En attente</span>
                                @endif
                            </td>

                            <td class="p-3">
                                {{ $c->created_at->format('d/m/Y') }}
                            </td>

                            <td class="p-3">
                                @if($c->status === 'pending')
                                    <a href="{{ route('representative.candidates.show', $c->id) }}"
                                       class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                        💳 Faire payer
                                    </a>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">
                                Aucun candidat
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- 💰 COMMISSIONS -->
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

        <div class="p-4">
            <h2 class="font-semibold text-gray-800">💰 Détail des commissions</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="p-3">Candidat</th>
                        <th class="p-3">Montant</th>
                        <th class="p-3">Statut</th>
                        <th class="p-3">Référence</th>
                        <th class="p-3">Méthode</th>
                        <th class="p-3">Date paiement</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($commissionsList as $com)
                        <tr class="border-t hover:bg-gray-50">

                            <td class="p-3">
                                {{ $com->candidate->first_name ?? '' }}
                                {{ $com->candidate->last_name ?? '' }}
                            </td>

                            <td class="p-3 font-semibold">
                                {{ $com->amount }} FCFA
                            </td>

                            <td class="p-3">
                                @if($com->paid_at)
                                    <span class="text-green-600 font-semibold">Payée</span>
                                @else
                                    <span class="text-orange-500 font-semibold">En attente</span>
                                @endif
                            </td>

                            <td class="p-3">{{ $com->payment_reference ?? '-' }}</td>

                            <td class="p-3">{{ $com->payment_method ?? '-' }}</td>

                            <td class="p-3">
                                {{ $com->paid_at ? $com->paid_at->format('d/m/Y H:i') : '-' }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">
                                Aucune commission
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- PAGINATION -->
    <div>
        {{ $candidates->links() }}
    </div>

</div>

@endsection