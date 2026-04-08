@extends('layouts.app')

@section('content')

<div class="p-6">

<h1 class="text-xl font-bold mb-4">
    Inscrire un participant
</h1>

<form method="POST" action="{{ url('/representative/candidates') }}" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-2 gap-4">

        <div>
            <label>Nom</label>
            <input type="text" name="first_name" class="w-full border p-2" required>
        </div>

        <div>
            <label>Prénoms</label>
            <input type="text" name="last_name" class="w-full border p-2" required>
        </div>

        <div>
            <label>Téléphone</label>
            <input type="text" name="phone" class="w-full border p-2" required>
        </div>

        <div>
            <label>Événement</label>
            <select name="event_id" class="w-full border p-2" required>
                @foreach($events as $event)
                    <option value="{{ $event->id }}">{{ $event->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Module</label>
            <select name="module_id" class="w-full border p-2" required>
                @foreach($modules as $module)
                    <option value="{{ $module->id }}">{{ $module->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- 📸 PHOTO -->
        <div>
            <label>Photo d'identité</label>
            <input type="file" name="photo" class="w-full border p-2" required>
        </div>

        <!-- 🪪 DOCUMENT -->
        <div>
            <label>Pièce d'identité</label>
            <input type="file" name="document" class="w-full border p-2" required>
        </div>

    </div>

    <!-- 🔥 CHECKBOX LÉGALE -->
    <div class="mt-6">

        <label class="flex items-start space-x-2">
            <input type="checkbox" name="terms" class="mt-1" required>

            <span class="text-sm">
                J’accepte les 
                <a href="{{ route('legal.cgu') }}" target="_blank" class="text-blue-600 underline">CGU</a>, 
                <a href="{{ route('legal.cgv') }}" target="_blank" class="text-blue-600 underline">CGV</a> 
                et la 
                <a href="{{ route('legal.privacy') }}" target="_blank" class="text-blue-600 underline">politique de confidentialité</a>.
            </span>
        </label>

        @error('terms')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

    </div>

    <div class="mt-4">
        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Enregistrer
        </button>
    </div>

</form>

</div>

@endsection