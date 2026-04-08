@extends('layouts.app')

@section('content')

<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Centres</h1>

    <a href="{{ route('centers.create') }}" class="bg-blue-600 text-white px-3 py-2 rounded">
        Ajouter centre
    </a>

    <table class="w-full mt-4 border">
        <tr>
            <th>Nom</th>
            <th>Contact</th>
            <th>Domaine</th>
            <th>Localisation</th>
            <th>Actions</th>
        </tr>

        @foreach($centers as $c)
        <tr>
            <td>{{ $c->name }}</td>
            <td>{{ $c->contact }}</td>
            <td>{{ $c->domain }}</td>
            <td>{{ $c->location }}</td>
            <td>
                <a href="{{ route('centers.edit', $c->id) }}">Modifier</a>
            </td>
        </tr>
        @endforeach
    </table>

    {{ $centers->links() }}
</div>

@endsection