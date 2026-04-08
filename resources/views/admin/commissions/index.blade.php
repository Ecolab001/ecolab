@extends('layouts.app')

@section('content')

<div class="p-6">

```
<h1 class="text-2xl font-bold mb-6">Commissions</h1>

<!-- 🔍 FILTRES -->
<form method="GET" class="mb-6 flex flex-wrap gap-3">

    <select name="user_id" class="border p-2 rounded">
        <option value="">Tous les représentants</option>
        @foreach($users as $u)
            <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                {{ $u->name }}
            </option>
        @endforeach
    </select>

    <select name="status" class="border p-2 rounded">
        <option value="">Tous statuts</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>pending</option>
        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>paid</option>
    </select>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Filtrer
    </button>

</form>

<!-- 💰 PAIEMENT GLOBAL -->
@if(request('user_id'))
    <form method="POST" action="{{ route('commissions.payAll', request('user_id')) }}">
        @csrf
        <button class="bg-green-700 text-white px-4 py-2 mb-4 rounded">
            💰 Payer toutes les commissions
        </button>
    </form>
@endif

<!-- 📋 TABLE -->
<div class="bg-white shadow rounded overflow-x-auto">

    <table class="w-full border-collapse">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-3 text-left">Représentant</th>
                <th class="p-3 text-left">Candidat</th>
                <th class="p-3 text-left">Montant</th>
                <th class="p-3 text-left">Statut</th>
                <th class="p-3 text-left">Référence</th>
                <th class="p-3 text-left">Méthode</th>
                <th class="p-3 text-left">Détails</th>
                <th class="p-3 text-left">Date paiement</th>
                <th class="p-3 text-left">Action</th>
            </tr>
        </thead>

        <tbody>

            @forelse($commissions as $c)
                <tr class="border-t">

                    <td class="p-3">
                        {{ $c->user->name ?? '-' }}
                    </td>

                    <td class="p-3">
                        {{ $c->candidate->first_name ?? '' }}
                        {{ $c->candidate->last_name ?? '' }}
                        <br>
                        <span class="text-sm text-gray-500">
                            {{ $c->candidate->phone ?? '' }}
                        </span>
                    </td>

                    <td class="p-3 font-bold">
                        {{ $c->amount }} FCFA
                    </td>

                    <td class="p-3">
                        <span class="px-2 py-1 text-white rounded
                            @if($c->status == 'paid') bg-green-500
                            @else bg-yellow-500
                            @endif">
                            {{ $c->status }}
                        </span>
                    </td>

                    <td class="p-3">
                        {{ $c->payment_reference ?? '-' }}
                    </td>

                    <td class="p-3">
                        {{ $c->payment_method ?? '-' }}
                    </td>

                    <td class="p-3">
                        {{ $c->payment_note ?? '-' }}
                    </td>

                    <td class="p-3">
                        {{ $c->paid_at ? $c->paid_at->format('d/m/Y H:i') : '-' }}
                    </td>

                    <td class="p-3">

                        @if($c->status == 'pending')

                            <form method="POST" action="{{ route('commissions.pay', $c->id) }}" class="space-y-1">
                                @csrf

                                <input type="text" name="payment_reference"
                                       placeholder="Référence"
                                       class="border p-1 text-sm w-full">

                                <input type="text" name="payment_method"
                                       placeholder="Méthode (cash, momo...)"
                                       class="border p-1 text-sm w-full">

                                <input type="text" name="payment_note"
                                       placeholder="Note (chèque, fiche...)"
                                       class="border p-1 text-sm w-full">

                                <button class="bg-green-600 text-white px-3 py-1 rounded w-full">
                                    💰 Payer
                                </button>
                            </form>

                        @else
                            <span class="text-green-600 font-bold">✔ Payé</span>
                        @endif

                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="9" class="p-4 text-center">
                        Aucune commission trouvée
                    </td>
                </tr>
            @endforelse

        </tbody>

    </table>

</div>

<!-- 📄 PAGINATION -->
<div class="mt-6">
    {{ $commissions->links() }}
</div>
```

</div>

@endsection
