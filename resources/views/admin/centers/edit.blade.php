@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Modifier le centre</h1>

    <form action="{{ route('centers.update', $center->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1">Nom</label>
            <input type="text" name="name" value="{{ $center->name }}" class="border p-2 w-full">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Contact</label>
            <input type="text" name="contact" value="{{ $center->contact }}" class="border p-2 w-full">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Domaine</label>
            <input type="text" name="domain" value="{{ $center->domain }}" class="border p-2 w-full">
        </div>

        <div class="mb-4">
            <label class="block mb-1">Localisation</label>
            <input type="text" name="location" value="{{ $center->location }}" class="border p-2 w-full">
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
            Mettre à jour
        </button>
    </form>
</div>
@endsection