@extends('layouts.app')

@section('content')

<div class="p-6">
    <h1>Créer représentant</h1>

    <form method="POST" action="{{ route('representatives.store') }}" enctype="multipart/form-data">
    @csrf

    <input type="text" name="name" placeholder="Nom" class="border p-2 w-full" required><br><br>

    <input type="email" name="email" placeholder="Email" class="border p-2 w-full" required><br><br>

    <input type="text" name="phone" placeholder="Téléphone" class="border p-2 w-full"><br><br>

    <input type="password" name="password" placeholder="Mot de passe" class="border p-2 w-full" required><br><br>

    <!-- 📄 DOCUMENT OBLIGATOIRE -->
    <input type="file" name="identity_document" class="border p-2 w-full" required><br><br>

    <button class="bg-green-600 text-white px-4 py-2">Créer</button>
</form>
</div>

@endsection