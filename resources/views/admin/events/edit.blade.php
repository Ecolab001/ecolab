@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto p-6 bg-white shadow rounded">

    <h1 class="text-xl font-bold mb-6">Modifier événement</h1>

    <form method="POST" action="{{ route('events.update', $event->id) }}">
        @csrf
        @method('PUT')

        <!-- Nom -->
        <div class="mb-4">
            <label class="block mb-1">Nom</label>
            <input type="text" name="name"
                   value="{{ $event->name }}"
                   class="w-full border p-2 rounded">
        </div>

        <!-- Date début -->
        <div class="mb-4">
            <label class="block mb-1">Date début</label>
            <input type="date" name="start_date"
                   value="{{ $event->start_date }}"
                   class="w-full border p-2 rounded">
        </div>

        <!-- Date fin -->
        <div class="mb-4">
            <label class="block mb-1">Date fin</label>
            <input type="date" name="end_date"
                   value="{{ $event->end_date }}"
                   class="w-full border p-2 rounded">
        </div>

        <!-- Lieu -->
        <div class="mb-4">
            <label class="block mb-1">Lieu</label>
            <input type="text" name="location"
                   value="{{ $event->location }}"
                   class="w-full border p-2 rounded">
        </div>

        <!-- Capacité -->
        <div class="mb-4">
            <label class="block mb-1">Capacité</label>
            <input type="number" name="capacity"
                   value="{{ $event->capacity }}"
                   class="w-full border p-2 rounded">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Mettre à jour
        </button>

    </form>

</div>

@endsection