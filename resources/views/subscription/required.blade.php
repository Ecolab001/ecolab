<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Abonnement requis</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-lg shadow-lg text-center max-w-md">

    <h1 class="text-2xl font-bold text-red-600 mb-4">
        Accès bloqué
    </h1>

    <p class="text-gray-700 mb-6">
        Votre abonnement a expiré.  
        Veuillez renouveler votre abonnement pour continuer.
    </p>

    <div class="text-xl font-semibold mb-4">
        2000 FCFA / 3 mois
    </div>

    {{-- 🔥 Messages --}}
    @if(session('error'))
        <div class="text-red-600 mb-3">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="text-green-600 mb-3">
            {{ session('success') }} <br>
            <span class="text-sm text-gray-500">
                Après validation sur votre téléphone, la page se débloquera automatiquement...
            </span>
        </div>
    @endif

    <form method="POST" action="{{ route('subscription.pay') }}">
        @csrf

        <input 
            type="text" 
            name="phone"
            placeholder="22901XXXXXXXX"
            required
            class="w-full mb-4 px-4 py-2 border rounded-lg"
        >

        <button type="submit"
            class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 w-full">
            Payer maintenant
        </button>
    </form>

</div>

{{-- 🔥 AUTO REFRESH APRÈS PAIEMENT --}}
@if(session('success'))
<script>
    console.log("⏳ Vérification abonnement en cours...");

    setInterval(() => {
        fetch('/dashboard')
            .then(response => {
                if (response.redirected) {
                    console.log("✅ Abonnement actif, redirection...");
                    window.location.href = response.url;
                }
            })
            .catch(() => {
                console.log("⏳ Toujours en attente...");
            });
    }, 5000); // toutes les 5 secondes
</script>
@endif

</body>
</html>