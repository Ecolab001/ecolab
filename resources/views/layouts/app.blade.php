<!DOCTYPE html> 
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ECOLAB Network') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 text-gray-800">

<div class="min-h-screen flex">

    <!-- SIDEBAR -->
    @include('layouts.navigation')

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <div class="bg-white border-b px-6 py-4 flex justify-between items-center">
            <div class="font-semibold text-gray-800">
                {{ config('app.name', 'ECOLAB Network') }}
            </div>

<div class="flex items-center gap-4">

    <!-- NOM -->
    <span class="text-sm text-gray-700">
        {{ auth()->user()->name }}
    </span>

    <!-- PROFIL -->
    <a href="{{ route('profile.edit') }}"
       class="text-sm text-blue-600 hover:underline">
        Profil
    </a>

    <!-- LOGOUT -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="text-sm text-red-600 hover:underline">
            Déconnexion
        </button>
    </form>

</div>
        </div>

        <!-- CONTENT -->
        <main class="flex-1 p-6 bg-gray-100">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>

        <!-- FOOTER -->
        <footer class="bg-white border-t px-6 py-4 text-sm text-gray-600 flex justify-between">
            <span>© {{ date('Y') }} ECOLAB Network</span>

<div class="flex flex-wrap gap-4 text-sm">

    <a href="{{ route('legal.mentions') }}" class="hover:underline">
        Mentions légales
    </a>

    <a href="{{ route('legal.privacy') }}" class="hover:underline">
        Confidentialité
    </a>

    <a href="{{ route('legal.cgu') }}" class="hover:underline">
        CGU
    </a>
    
    <a href="{{ route('legal.cgv') }}" class="hover:underline">
        CGV
    </a>
    <a href="{{ route('legal.payment') }}" class="hover:underline">
        Paiement
    </a>

    <a href="{{ route('legal.representatives') }}" class="hover:underline">
        Représentants
    </a>

    <a href="{{ route('contact') }}" class="hover:underline">
        Nous contacter
    </a>

  

</div>
        </footer>

    </div>
</div>

</body>
</html>