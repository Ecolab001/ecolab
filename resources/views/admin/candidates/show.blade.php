@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

<h1 class="text-2xl font-bold">Détails du candidat</h1>

<!-- 👤 INFOS -->
<div class="bg-white p-4 rounded shadow space-y-2">

    <p><strong>Nom :</strong> {{ $candidate->first_name }} {{ $candidate->last_name }}</p>
    <p><strong>Identifiant :</strong> 
    <span class="font-mono text-blue-600">{{ $candidate->code }}</span></p>
    <p><strong>Téléphone :</strong> {{ $candidate->phone }}</p>
    <p><strong>Représentant :</strong> {{ $candidate->user->name ?? '-' }}</p>

    <p><strong>Événement :</strong> {{ $candidate->event->name ?? '-' }}</p>
    <p><strong>Module :</strong> {{ $candidate->module->name ?? '-' }}</p>

    <p><strong>Statut :</strong>
        @if($candidate->status === 'validated')
            <span class="text-green-600 font-semibold">✅ Validé</span>
        @elseif($candidate->status === 'rejected')
            <span class="text-red-600 font-semibold">❌ Rejeté</span>
        @elseif($candidate->status === 'paid')
            <span class="text-blue-600 font-semibold">💰 En attente de validation</span>
        @else
            <span class="text-orange-500 font-semibold">⏳ En attente de paiement</span>
        @endif
    </p>

</div>

<!-- 📸 DOCUMENTS -->
<div class="bg-white p-4 rounded shadow space-y-4">

    <h2 class="font-bold">📂 Documents</h2>

    @if($candidate->photo)
        <div>
            <p class="font-semibold">Photo :</p>
            <img src="{{ asset('storage/' . $candidate->photo) }}"
                 class="w-32 rounded border">
        </div>
    @endif

    @if($candidate->document)
        <div>
            <p class="font-semibold">Pièce d'identité :</p>
            <a href="{{ asset('storage/' . $candidate->document) }}"
               target="_blank"
               class="text-blue-600 underline">
                Voir le document
            </a>
        </div>
    @endif

</div>

<!-- 🔄 REMPLACER DOCUMENTS -->
<div class="bg-white p-4 rounded shadow space-y-4">

    <h2 class="font-bold">📤 Remplacer documents</h2>

    <form method="POST" action="{{ route('admin.candidates.replaceDocs', $candidate->id) }}" enctype="multipart/form-data">
        @csrf

        <input type="file" name="photo" class="border p-2 w-full">
        <input type="file" name="document" class="border p-2 w-full mt-2">

        <button class="bg-blue-600 text-white px-3 py-2 rounded mt-2">
            🔄 Mettre à jour
        </button>
    </form>

</div>

<!-- ⚙️ ACTIONS ADMIN -->
<div class="bg-white p-4 rounded shadow space-y-4">

    <h2 class="font-bold">⚙️ Actions administrateur</h2>

    <!-- ✅ VALIDER -->
<form method="POST" action="{{ url('/admin/candidates/' . $candidate->id) }}">
    @csrf
    @method('PUT')
    <input type="hidden" name="status" value="validated">

    <button class="bg-green-600 text-white px-4 py-2 rounded w-full">
        ✅ Valider le candidat
    </button>
</form>

<!-- ❌ REJETER -->
<form method="POST" action="{{ url('/admin/candidates/' . $candidate->id) }}">
    @csrf
    @method('PUT')
    <input type="hidden" name="status" value="rejected">

    <button class="bg-red-600 text-white px-4 py-2 rounded w-full">
        ❌ Rejeter le candidat
    </button>
</form>

</div>

<!-- 💳 PAIEMENTS -->
<div class="bg-white p-4 rounded shadow">

    <h2 class="font-bold mb-2">💳 Paiements</h2>

    @forelse($candidate->payments as $payment)
        <div class="border p-2 mb-2">
            <p><strong>Montant :</strong> {{ $payment->amount }} FCFA</p>
            <p><strong>Statut :</strong> {{ $payment->status }}</p>
            <p><strong>Transaction :</strong> {{ $payment->transaction_id ?? '-' }}</p>
        </div>
    @empty
        <p>Aucun paiement</p>
    @endforelse

</div>

<!-- 💰 COMMISSION -->
<div class="bg-white p-4 rounded shadow">

    <h2 class="font-bold mb-2">💰 Commission</h2>

    @if($candidate->commission)
        <p><strong>Montant :</strong> {{ $candidate->commission->amount }} FCFA</p>

        <p>
            <strong>Statut :</strong>
            @if($candidate->commission->status == 'paid')
                <span class="text-green-600">Payée</span>
            @else
                <span class="text-orange-500">En attente</span>
            @endif
        </p>

        <p><strong>Référence :</strong> {{ $candidate->commission->payment_reference ?? '-' }}</p>
        <p><strong>Méthode :</strong> {{ $candidate->commission->payment_method ?? '-' }}</p>
        <p><strong>Détails :</strong> {{ $candidate->commission->payment_note ?? '-' }}</p>
        <p><strong>Date :</strong>
            {{ $candidate->commission->paid_at ? $candidate->commission->paid_at->format('d/m/Y H:i') : '-' }}
        </p>
    @else
        <p>Aucune commission</p>
    @endif

</div>

</div>

@endsection