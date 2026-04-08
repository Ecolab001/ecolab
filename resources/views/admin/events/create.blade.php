@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">Créer un événement</h1>

    <form method="POST" action="{{ route('events.store') }}">
        @csrf

        <input type="text" name="name" placeholder="Nom"
            class="w-full mb-3 p-2 border rounded" required>

        <textarea name="description" placeholder="Description"
            class="w-full mb-3 p-2 border rounded"></textarea>

        <input type="date" name="start_date"
            class="w-full mb-3 p-2 border rounded" required>

        <input type="date" name="end_date"
            class="w-full mb-3 p-2 border rounded" required>

        <input type="text" name="location" placeholder="Lieu"
            class="w-full mb-3 p-2 border rounded" required>

        <input type="number" name="capacity" placeholder="Capacité"
            class="w-full mb-3 p-2 border rounded" required>

        <button class="bg-green-600 text-white px-4 py-2 rounded">
            Enregistrer
        </button>

    </form>

</div>

@endsection