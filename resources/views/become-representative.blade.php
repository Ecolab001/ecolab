<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devenir représentant - ECOLAB</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-50 text-gray-800">

<!-- NAV -->
<div class="flex justify-between items-center px-6 py-4 bg-white shadow">
    <h1 class="text-xl font-bold text-green-600">ECOLAB Network</h1>

    <a href="{{ route('login') }}" class="text-green-600 font-semibold">
        Connexion
    </a>
</div>

<!-- HERO -->
<section class="relative text-white text-center">

    <img src="{{ asset('images/hero.png') }}"
         class="absolute inset-0 w-full h-full object-cover opacity-40">

    <div class="relative py-20 px-6 bg-gray-900 bg-opacity-60">

        <h1 class="text-4xl font-bold mb-4">
            💼 Aujourd'hui, deviens représentant ECOLAB
        </h1>

        <p class="max-w-xl mx-auto mb-6">
            Partages ton experience et Gagnes des revenus en inscrivant des participants aux formations.
        </p>

<a href="{{ route('contact') }}"
   class="bg-green-600 px-6 py-3 rounded-lg text-lg shadow">
    📩 Nous contacter pour devenir représentant
</a>

    </div>

</section>

<!-- ARGUMENT BUSINESS -->
<section class="py-16 px-6 text-center bg-white">

    <h2 class="text-2xl font-bold mb-6">
        💰 Gagnes des primes pour chaque inscription confirmee
    </h2>

    <p class="max-w-2xl mx-auto text-gray-600">
        Chaque fois que tu inscrits un participant qui paie sa contribution, tu gagnes automatiquement une prime.
    </p>

</section>

<!-- AVANTAGES -->
<section class="py-16 px-6 bg-white">

    <h2 class="text-2xl font-bold text-center mb-10">
        Pourquoi rejoindre ?
    </h2>

    <div class="grid md:grid-cols-3 gap-6 max-w-6xl mx-auto text-center">

        <div>
            <h3 class="font-bold">💸 Revenus tangibles et variables</h3>
            <p>Pas besoin d’investissement lourd</p>
        </div>

        <div>
            <h3 class="font-bold">📱 Simple et pratique</h3>
            <p>Tout se fait depuis ton téléphone ou ton ordinateur</p>
        </div>

        <div>
            <h3 class="font-bold">🚀 Opportunités</h3>
            <p>Développe ton réseau et impactes autour de toi</p>
        </div>

    </div>

</section>

<!-- FOOTER -->
<footer class="bg-gray-900 text-white py-8 px-6 text-center">

    <p>© {{ date('Y') }} ECOLAB Network</p>

    <div class="mt-4 space-x-4">
        <a href="{{ route('legal.cgu') }}">CGU</a>
        <a href="{{ route('legal.privacy') }}">Confidentialité</a>
        <a href="{{ route('contact') }}">Contact</a>
    </div>

</footer>

</body>
</html>