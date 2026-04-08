@extends('layouts.app')

@section('content')

<div class="p-6">

    <h1 class="text-xl font-bold mb-4">Mes candidats</h1>

    <!-- ✅ BOUTON CREATION -->
    <a href="{{ route('rep.candidates.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded inline-block mb-4">
        + Inscrire un candidat
    </a>

    <!-- 📋 LISTE -->
    <div class="bg-white shadow rounded overflow-x-auto">

        <table class="w-full border">

            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2">Nom</th>
                    <th class="p-2">Téléphone</th>
                    <th class="p-2">Statut</th>
                    <th class="p-2">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($candidates as $c)
                    <tr class="border-t">

                        <td class="p-2">
                            {{ $c->first_name }} {{ $c->last_name }}
                        </td>

                        <td class="p-2">
                            {{ $c->phone }}
                        </td>

                        <td class="p-2">
                            {{ $c->status }}
                        </td>

                        <td class="p-2">

                            <div class="flex flex-col gap-2">

                                {{-- 💳 PAIEMENT --}}
                                @if($c->status === 'pending')

                                    <a href="{{ url('/representative/candidates/'.$c->id) }}"
                                       class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-center">
                                        💳 Faire payer
                                    </a>

                                @elseif($c->status === 'processing')

                                    <span class="text-orange-500 text-center">
                                        ⏳ Paiement en cours
                                    </span>

                                @elseif($c->status === 'paid')

                                    <span class="text-green-600 text-center">
                                        ✅ Payé
                                    </span>

                                @endif

                                {{-- 🔍 VOIR --}}
                                <a href="{{ url('/representative/candidates/'.$c->id) }}"
                                   class="text-blue-600 underline text-center">
                                    Voir
                                </a>

                            </div>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center">
                            Aucun candidat
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    <div class="mt-4">
        {{ $candidates->links() }}
    </div>

</div>

@endsection