@extends('layouts.app')

@section('content')

<div class="p-6">

    <h1 class="text-xl font-bold mb-4">
        Détails du candidat
    </h1>

    <div class="bg-white p-4 rounded shadow space-y-2">

        <p><strong>Nom :</strong> {{ $candidate->first_name }} {{ $candidate->last_name }}</p>
        <p><strong>Identifiant :</strong> 
        <span class="font-mono text-blue-600">{{ $candidate->code }}</span></p>
        <p><strong>Téléphone :</strong> {{ $candidate->phone }}</p>
        <p><strong>Statut :</strong>

        @if($candidate->status === 'validated')
            <span class="text-green-600 font-semibold">✅ Validé</span>

        @elseif($candidate->status === 'rejected')
            <span class="text-red-600 font-semibold">❌ Rejeté</span>

        @elseif($candidate->status === 'paid')
            <span class="text-blue-600 font-semibold">💰 Paiement effectué (en attente de validation)</span>

        @else
            <span class="text-orange-500 font-semibold">⏳ En attente de paiement</span>
        @endif

        </p>

        <p><strong>Événement :</strong> {{ $candidate->event->name ?? '-' }}</p>
        <p><strong>Module :</strong> {{ $candidate->module->name ?? '-' }}</p>

    </div>

    <div class="mt-4">

        @if($candidate->status !== 'paid')
       <form method="POST" action="{{ route('candidate.pay', $candidate->id) }}" class="space-y-2">
    @csrf

    <input type="text"
           name="phone"
           placeholder="Numéro Mobile Money (ex: 97000000)"
           class="border p-2 rounded w-full"
           required>

    <button class="bg-green-600 text-white px-4 py-2 rounded w-full">
        💳 Faire payer (2500 FCFA)
    </button>
</form>
        @else
            <p class="text-green-600 font-bold">Paiement effectué ✅</p>
        @endif

    </div>

</div>

@endsection