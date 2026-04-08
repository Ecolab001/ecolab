@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <h1 class="text-xl font-bold">Rapports</h1>

    <!-- 🔍 FILTRE PAR DATE -->
    <form method="GET" class="flex flex-wrap gap-4 items-end">

        <div>
            <label class="block text-sm">Date début</label>
            <input type="date" name="start_date"
                   value="{{ request('start_date') }}"
                   class="border p-2 rounded">
        </div>

        <div>
            <label class="block text-sm">Date fin</label>
            <input type="date" name="end_date"
                   value="{{ request('end_date') }}"
                   class="border p-2 rounded">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Filtrer
        </button>

    </form>

    <!-- 📊 GLOBAL -->
    <div class="bg-white shadow rounded p-4 space-y-2">

        <h2 class="font-bold text-lg mb-2">Résumé global</h2>

        <p><b>Candidats total :</b> {{ $totalCandidates }}</p>
        <p><b>Candidats payés :</b> {{ $paidCandidates }}</p>

        <p><b>Revenus abonnements :</b> {{ $subscriptionRevenue }} FCFA</p>
        <p><b>Revenus inscriptions :</b> {{ $candidateRevenue }} FCFA</p>

        <p><b>Commissions total :</b> {{ $commissions }} FCFA</p>
        <p><b>Commissions payées :</b> {{ $paidCommissions }} FCFA</p>

    </div>

    <!-- 👥 REPRESENTANTS -->
    <div class="bg-white shadow rounded p-4">

        <h2 class="font-bold text-lg mb-4">Performance des représentants</h2>

        <div class="overflow-x-auto">
            <table class="w-full border">

                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 text-left">Nom</th>
                        <th class="p-2 text-left">Téléphone</th>
                        <th class="p-2 text-left">Inscriptions</th>
                        <th class="p-2 text-left">Revenus</th>
                        <th class="p-2 text-left">Commissions</th>
                        <th class="p-2 text-left">Payées</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($representatives as $r)
                        <tr class="border-t">
                            <td class="p-2">{{ $r['name'] }}</td>
                            <td class="p-2">{{ $r['phone'] }}</td>
                            <td class="p-2">{{ $r['candidates'] }}</td>

                            <td class="p-2 font-bold">
                                {{ $r['subscriptionRevenue'] + $r['candidateRevenue'] }} FCFA
                            </td>

                            <td class="p-2">{{ $r['commissions'] }} FCFA</td>
                            <td class="p-2 text-green-600">
                                {{ $r['paidCommissions'] }} FCFA
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center">
                                Aucun représentant trouvé
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection