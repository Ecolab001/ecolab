@extends('layouts.app')

@section('content')

<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Représentants</h1>

    <a href="{{ route('representatives.create') }}" class="bg-blue-600 text-white px-3 py-2 rounded">
        Ajouter représentant
    </a>

    <table class="w-full mt-4 border">
        <tr>
            <th>Nom</th>
            <th>Code</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Statut</th>
            <th>Expiration</th>
            <th>Document</th>
            <th>Actions</th>
                        
        </tr>

        @foreach($representatives as $r)
        <tr>
            <td>{{ $r->name }}</td>
            <td>{{ $r->code }}</td>
            <td>{{ $r->email }}</td>
            <td>{{ $r->phone }}</td>
            <td>{{ $r->status }}</td>
            <td>{{ $r->expires_at ?? '-' }}</td>

            <td>
    @if($r->identity_document)
    <a href="{{ asset('storage/' . $r->identity_document) }}" target="_blank">
        Voir
    </a>
    @else
    <span class="text-gray-400">Aucun</span>

    @endif
</td>

            <td class="space-y-2">

    <!-- 👁️ Voir commissions -->
    <a href="{{ route('commissions.index', ['user_id' => $r->id]) }}"
       class="text-blue-600 underline">
        Commissions
    </a>

    <!-- ✏️ Modifier -->
    <a href="{{ route('representatives.edit', $r->id) }}"
       class="text-green-600 underline">
        Modifier
    </a>

    <!-- ❌ Suspendre -->
    <form method="POST" action="{{ route('representatives.destroy', $r->id) }}">
        @csrf
        @method('DELETE')

        <button class="bg-red-600 text-white px-2 py-1 rounded">
            Suspendre
        </button>
    </form>

</td>
        </tr>
        @endforeach
    </table>

    {{ $representatives->links() }}
</div>

@endsection