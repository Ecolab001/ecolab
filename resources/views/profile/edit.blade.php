@extends('layouts.app')

@section('content')

<div class="p-6 max-w-3xl mx-auto space-y-6">

    <h1 class="text-2xl font-bold">👤 Mon profil</h1>

    <!-- 📌 INFOS -->
    <div class="bg-white p-4 rounded shadow space-y-2">

        <p><strong>Nom :</strong> {{ $user->name }}</p>
        <p><strong>Email :</strong> {{ $user->email }}</p>
        <p><strong>Téléphone :</strong> {{ $user->phone ?? '-' }}</p>
        <p><strong>Rôle :</strong> {{ $user->role }}</p>

        <p>
            <strong>Statut :</strong>
            @if($user->status === 'active')
                <span class="text-green-600 font-semibold">✅ Actif</span>
            @else
                <span class="text-red-600 font-semibold">❌ Expiré</span>
            @endif
        </p>

        <p>
            <strong>Expire le :</strong>
            {{ $user->expires_at 
                ? \Carbon\Carbon::parse($user->expires_at)->format('d/m/Y') 
                : '-' }}
        </p>

    </div>

    <!-- ✏️ MODIFIER PROFIL -->
    <div class="bg-white p-4 rounded shadow">
        @include('profile.partials.update-profile-information-form')
    </div>

    <!-- 🔒 MOT DE PASSE -->
    <div class="bg-white p-4 rounded shadow">
        @include('profile.partials.update-password-form')
    </div>

    <!-- ❌ SUPPRESSION -->
    <div class="bg-white p-4 rounded shadow">
        @include('profile.partials.delete-user-form')
    </div>

</div>

@endsection