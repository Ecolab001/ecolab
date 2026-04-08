@extends('layouts.public')

@section('content')

<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">

    <h1 class="text-2xl font-bold">Nous contacter</h1>

    <p class="text-gray-600">
        Une question ? Besoin d’assistance ? Envoyez-nous un message.
    </p>

    <!-- INFOS -->
    <div class="space-y-2 text-gray-700">
        <p><b>Email :</b> contact@ecolab.com</p>
        <p><b>Téléphone :</b> +229 01 40 54 65 25</p>
        <p><b>Adresse :</b> Cotonou, Bénin</p>
    </div>

    <!-- FORMULAIRE -->
    <form method="POST" action="{{ route('contact.store') }}">
        @csrf

        @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
        @endif

        <div class="space-y-4">

            <input type="text" name="name"
                placeholder="Votre nom"
                class="w-full border p-3 rounded"
                required>

            <input type="email" name="email"
                placeholder="Votre email"
                class="w-full border p-3 rounded"
                required>

            <!-- 📞 NOUVEAU CHAMP -->
            <input type="text" name="phone"
                placeholder="Votre numéro WhatsApp ou téléphone"
                class="w-full border p-3 rounded"
                required>

            <input type="text" name="subject"
                placeholder="Sujet"
                class="w-full border p-3 rounded">

            <textarea name="message"
                placeholder="Votre message"
                class="w-full border p-3 rounded"
                rows="5"
                required></textarea>

            <!-- 🔒 CHECKBOX -->
            <div>
                <label class="flex items-start space-x-2">
                    <input type="checkbox" name="terms" class="mt-1" required>

                    <span class="text-sm text-gray-600">
                        J’accepte les 
                        <a href="{{ route('legal.cgu') }}" target="_blank" class="text-blue-600 underline">CGU</a> 
                        et la 
                        <a href="{{ route('legal.privacy') }}" target="_blank" class="text-blue-600 underline">politique de confidentialité</a>.
                    </span>
                </label>

                @error('terms')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                📩 Envoyer
            </button>

        </div>

    </form>

</div>

@endsection