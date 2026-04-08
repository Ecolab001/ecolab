<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">

<div class="bg-white p-8 rounded shadow text-center">

    <h1 class="text-xl font-bold mb-4">
        Redirection vers le paiement...
    </h1>

    <p class="mb-4">
        Référence : <strong>{{ $payment->transaction_id }}</strong>
    </p>

    <p class="text-gray-600">
        (Simulation FedaPay / FeexPay)
    </p>

</div>

</body>
</html>