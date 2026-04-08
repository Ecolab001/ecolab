@extends('layouts.app')

@section('content')

<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Modules</h1>

    <a href="{{ route('modules.create') }}" class="bg-blue-600 text-white px-3 py-2 rounded">
        Ajouter module
    </a>

    <table class="w-full mt-4 border">
        <tr>
            <th>Nom</th>
            <th>Événement</th>
            <th>Centre</th>
            <th>Capacité</th>
            <th>Actions</th>
        </tr>

        @foreach($modules as $m)
        <tr>
            <td>{{ $m->name }}</td>
            <td>{{ $m->event->name ?? '-' }}</td>
            <td>{{ $m->center->name ?? '-' }}</td>
            <td>{{ $m->capacity ?? '-' }}</td>
            <td>
                <a href="{{ route('modules.edit', $m->id) }}">Modifier</a>
            </td>
        </tr>
        @endforeach
    </table>

    {{ $modules->links() }}
</div>

@endsection