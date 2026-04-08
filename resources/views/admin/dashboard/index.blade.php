@extends('layouts.app')

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
        <div class="text-sm text-gray-500">
            Vue globale de la plateforme
        </div>
    </div>

    <!-- 🔢 STATS MODERNES -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <!-- Candidats -->
        <div class="bg-white p-5 rounded-xl shadow-sm border hover:shadow-md transition">
            <p class="text-sm text-gray-500">Candidats</p>
            <p class="text-2xl font-bold text-gray-800">{{ $totalCandidates }}</p>
            <p class="text-xs text-green-600 mt-1">
                {{ $paidCandidates }} payés
            </p>
        </div>

        <!-- Revenus -->
        <div class="bg-white p-5 rounded-xl shadow-sm border hover:shadow-md transition">
            <p class="text-sm text-gray-500">Revenus Total</p>
            <p class="text-2xl font-bold text-green-600">
                {{ $subscriptionRevenue + $candidateRevenue }} FCFA
            </p>
            <p class="text-xs text-gray-500 mt-1">
                Abonnements + Inscriptions
            </p>
        </div>

        <!-- Commissions -->
        <div class="bg-white p-5 rounded-xl shadow-sm border hover:shadow-md transition">
            <p class="text-sm text-gray-500">Commissions</p>
            <p class="text-2xl font-bold text-yellow-600">
                {{ $totalCommissions }} FCFA
            </p>
            <p class="text-xs text-gray-500 mt-1">
                {{ $paidCommissions }} payées
            </p>
        </div>

        <!-- Représentants -->
        <div class="bg-white p-5 rounded-xl shadow-sm border hover:shadow-md transition">
            <p class="text-sm text-gray-500">Représentants</p>
            <p class="text-2xl font-bold text-blue-600">
                {{ $representatives }}
            </p>
        </div>

    </div>

    <!-- 📊 INDICATEURS BUSINESS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white p-5 rounded-xl shadow-sm border">
            <p class="text-sm text-gray-500">Revenus inscriptions</p>
            <p class="text-xl font-bold text-gray-800">{{ $candidateRevenue }} FCFA</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border">
            <p class="text-sm text-gray-500">Revenus abonnements</p>
            <p class="text-xl font-bold text-gray-800">{{ $subscriptionRevenue }} FCFA</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border">
            <p class="text-sm text-gray-500">Taux de conversion</p>
            <p class="text-xl font-bold text-green-600">
                {{ $totalCandidates > 0 ? round(($paidCandidates / $totalCandidates) * 100, 2) : 0 }} %
            </p>
        </div>

    </div>

    <!-- ⚡ ACTIONS RAPIDES -->
    <div class="bg-white p-6 rounded-xl shadow-sm border">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">Actions rapides</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            <a href="{{ url('/admin/events') }}" class="bg-blue-50 hover:bg-blue-100 text-blue-700 p-4 rounded-lg text-center transition">
                📅 Événements
            </a>

            <a href="{{ url('/admin/modules') }}" class="bg-green-50 hover:bg-green-100 text-green-700 p-4 rounded-lg text-center transition">
                📚 Modules
            </a>

            <a href="{{ url('/admin/centers') }}" class="bg-purple-50 hover:bg-purple-100 text-purple-700 p-4 rounded-lg text-center transition">
                🏫 Centres
            </a>

            <a href="{{ url('/admin/representatives') }}" class="bg-orange-50 hover:bg-orange-100 text-orange-700 p-4 rounded-lg text-center transition">
                👤 Représentants
            </a>

            <a href="{{ url('/admin/candidates') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 p-4 rounded-lg text-center transition">
                👥 Candidats
            </a>

            <a href="{{ url('/admin/commissions') }}" class="bg-yellow-50 hover:bg-yellow-100 text-yellow-700 p-4 rounded-lg text-center transition">
                💰 Commissions
            </a>

            <a href="{{ url('/admin/reports') }}" class="bg-black text-white p-4 rounded-lg text-center hover:opacity-90 transition">
                📊 Rapports
            </a>

        </div>
    </div>

    <!-- 📌 RÉSUMÉ -->
    <div class="bg-white p-6 rounded-xl shadow-sm border">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">Résumé</h2>

        <div class="space-y-2 text-gray-700">
            <p>💰 Revenus total : <b>{{ $subscriptionRevenue + $candidateRevenue }} FCFA</b></p>
            <p>📉 Commissions dues : <b>{{ $totalCommissions - $paidCommissions }} FCFA</b></p>
        </div>
    </div>

</div>

@endsection