@extends('layouts.app')

@section('content')

<div class="p-6">
    <h1>Créer centre</h1>

    <form method="POST" action="{{ route('centers.store') }}">
        @csrf

        <input type="text" name="name" placeholder="Nom" class="border p-2"><br><br>
        <input type="text" name="contact" placeholder="Contact" class="border p-2"><br><br>
        <input type="text" name="domain" placeholder="Domaine" class="border p-2"><br><br>
        <input type="text" name="location" placeholder="Localisation" class="border p-2"><br><br>

        <button class="bg-green-600 text-white px-4 py-2">Créer</button>
    </form>
</div>

@endsection