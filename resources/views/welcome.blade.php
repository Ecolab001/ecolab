<!DOCTYPE html> 
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECOLAB Network</title>

    @vite(['resources/css/app.css'])

</head>

<body class="bg-gray-50 text-gray-800">

<!-- NAVBAR -->
<div class="flex justify-between items-center px-6 py-4 bg-white shadow">
    <h1 class="text-xl font-bold text-green-600">ECOLAB Network</h1>

    <div class="space-x-4">
        <a href="{{ route('login') }}" class="text-gray-600 hover:text-green-600">Connexion</a>
    </div>
</div>

<!-- HERO -->
<section class="relative text-white">

    <!-- IMAGE BACKGROUND -->
    <img src="{{ asset('images/hero.png') }}"
     class="absolute inset-0 w-full h-full object-cover opacity-40">

    <!-- OVERLAY -->
    <div class="absolute inset-0 bg-black opacity-60"></div>

    <div class="relative text-center py-20 px-6">

        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            🌍 Le réseau africain qui transforme les compétences en opportunités...
        </h1>

        <p class="max-w-2xl mx-auto mb-6 text-gray-200">
            Formez-vous, développez vos compétences et accédez à des opportunités concrètes partout en Afrique.
        </p>

        <a href="{{ route('become.representative') }}"
           class="bg-green-600 hover:bg-green-700 px-6 py-3 rounded-lg text-lg shadow">
            💼 Devenir représentant
        </a>

    </div>

</section>

<!-- POURQUOI -->
<section class="py-16 px-6">
    <h2 class="text-2xl font-bold text-center mb-10">
        Pourquoi rejoindre ECOLAB?
    </h2>

    <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">

        <!-- FORMATION -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
           <img src="{{ asset('images/Formations_pratiques.png') }}"
            class="h-40 w-full object-cover">
            <div class="p-4 text-center">
                <h3 class="font-bold mb-2">🎓 Formations pratiques</h3>
                <p>En trois mois seulement, apprenez gratuitement des compétences pratiques utiles et directement monetisables.</p>
            </div>
        </div>

        <!-- ARGENT -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <img src="{{ asset('images/Opportunites_revenus.png') }}"
                 class="h-40 w-full object-cover">
            <div class="p-4 text-center">
                <h3 class="font-bold mb-2">💰 Opportunités de revenus</h3>
                <p>Partagez votre experience de formation autour de vous, Gagnez des revenus en aidant d'autres à se former.</p>
            </div>
        </div>

        <!-- COMMUNAUTE -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <img src="{{ asset('images/Communaute_africaine.png') }}"
                 class="h-40 w-full object-cover">
            <div class="p-4 text-center">
                <h3 class="font-bold mb-2">🌍 Communauté africaine</h3>
                <p>Rejoignez un réseau dynamique de jeunes ambitieux, déterminés à impacter positivement leurs localités .</p>
            </div>
        </div>

    </div>
</section>

<!-- COMMENT CA MARCHE -->
<section class="bg-gray-100 py-16 px-6">

    <h2 class="text-2xl font-bold text-center mb-10">
        Comment ça marche ?
    </h2>

    <div class="grid md:grid-cols-2 gap-10 max-w-6xl mx-auto items-center">

        <!-- IMAGE -->
        <img src="{{ asset('images/Comment_ca_marche.png') }}"
             class="rounded-xl shadow">

        <!-- TEXT -->
        <div class="space-y-4">

            <div class="flex gap-3">
                <span class="text-green-600 font-bold">1.</span>
                <p>Inscription via un représentant</p>
            </div>

            <div class="flex gap-3">
                <span class="text-green-600 font-bold">2.</span>
                <p>Paiement sécurisé de votre contribution via Mobile Money</p>
            </div>

            <div class="flex gap-3">
                <span class="text-green-600 font-bold">3.</span>
                <p>Accès immédiat aux formations pratiques</p>
            </div>
            
            <div class="flex gap-3">
                <span class="text-green-600 font-bold">IMPORTANT:</span>
                <p>ECOLAB Network propose des formations pratiques gratuites. Toutefois, les participants contribuent financièrement aux frais liés à la mise en œuvre des activités (notamment les matières premières, le matériel utilisé, la logistique et l'organisation)
</p>
            </div>

            <div class="flex gap-3">
                <span class="text-green-600 font-bold">UNE FICHE D'ENGAGEMENT EST SIGNE PAR CHAQUE BENEFICIAIRE AVANT LE DEMARAGE DE SA FORMATION</span>
            </div>
        </div>

    </div>

</section>

<!-- FOOTER -->
<footer class="bg-gray-900 text-white py-8 px-6">

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