@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto p-6 bg-white shadow rounded">

    <h1 class="text-xl font-bold mb-6">Créer module</h1>

    <form method="POST" action="{{ route('modules.store') }}" class="space-y-4">
        @csrf

        <!-- Nom -->
        <div>
            <label class="block mb-1 font-semibold">Nom du module</label>
            <input type="text" name="name"
                   class="w-full border p-2 rounded"
                   placeholder="Nom du module">
        </div>

        <!-- Événement -->
        <div>
            <label class="block mb-1 font-semibold">Événement</label>
            <select name="event_id" class="w-full border p-2 rounded">
                <option value="">-- Choisir un événement --</option>
                @foreach($events as $event)
                    <option value="{{ $event->id }}">
                        {{ $event->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Centre -->
        <div>
            <label class="block mb-1 font-semibold">Centre de formation</label>
            <select name="center_id" class="w-full border p-2 rounded">
                <option value="">-- Choisir un centre --</option>
                @foreach($centers as $center)
                    <option value="{{ $center->id }}">
                        {{ $center->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Capacité -->
        <div>
            <label class="block mb-1 font-semibold">Capacité</label>
            <input type="number" name="capacity"
                   class="w-full border p-2 rounded"
                   placeholder="Capacité">
        </div>

        <!-- Bouton -->
        <div>
            <button class="bg-green-600 text-white px-4 py-2 rounded w-full">
                Créer
            </button>
        </div>

    </form>

</div>

@endsection