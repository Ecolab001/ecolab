<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECOLAB Network</title>

    @vite(['resources/css/app.css'])
</head>

<body class="bg-gray-50 text-gray-800">

<!-- NAVBAR SIMPLE -->
<div class="flex justify-between items-center px-6 py-4 bg-white shadow">
    <h1 class="text-xl font-bold text-green-600">ECOLAB Network</h1>

    <div class="space-x-4">
        <a href="/" class="text-gray-600 hover:text-green-600">Accueil</a>
        <a href="{{ route('login') }}" class="text-gray-600 hover:text-green-600">Connexion</a>
    </div>
</div>

<!-- CONTENT -->
<main class="py-10 px-4">
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="bg-gray-900 text-white py-8 px-6 mt-10">

    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-6">

        <div>
            <h3 class="font-bold mb-2">ECOLAB Network</h3>
            <p>Cotonou, Bénin</p>
            <p>+229 01 40 54 65 25</p>
            <p>contact@ecolab.com</p>
        </div>

        <div class="space-y-2">
            <a href="{{ route('legal.mentions') }}" class="block hover:underline">Mentions légales</a>
            <a href="{{ route('legal.privacy') }}" class="block hover:underline">Confidentialité</a>
            <a href="{{ route('legal.cgu') }}" class="block hover:underline">CGU</a>
            <a href="{{ route('legal.cgv') }}" class="block hover:underline">CGV</a>
            <a href="{{ route('legal.payment') }}" class="block hover:underline">Paiement</a>
            <a href="{{ route('contact') }}" class="block hover:underline">Nous contacter</a>
        </div>

    </div>

    <div class="text-center mt-6 text-sm text-gray-400">
        © {{ date('Y') }} ECOLAB Network
    </div>

</footer>

</body>
</html>