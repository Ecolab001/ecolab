@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">Liste des candidats</h1>

    <!-- 🔍 FILTRES -->
    <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">

        <input type="text" name="code" 
       value="{{ request('code') }}"
       placeholder="Rechercher par ID (ex: CAND-XXXX)"
       class="border p-2 rounded">
       
       <input type="text" name="status" placeholder="Statut"
               value="{{ request('status') }}"
               class="border p-2 rounded">

        <input type="text" name="event_id" placeholder="Event ID"
               value="{{ request('event_id') }}"
               class="border p-2 rounded">

        <input type="text" name="module_id" placeholder="Module ID"
               value="{{ request('module_id') }}"
               class="border p-2 rounded">

        <input type="text" name="user_id" placeholder="Représentant ID"
               value="{{ request('user_id') }}"
               class="border p-2 rounded">

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded col-span-1 md:col-span-4">
            Filtrer
        </button>

    </form>

    <!-- 📋 TABLE -->
    <div class="bg-white shadow rounded overflow-x-auto">

        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3">Nom</th>
                    <th class="p-3">ID</th>
                    <th class="p-3">Téléphone</th>
                    <th class="p-3">Statut</th>
                    <th class="p-3">Module</th>
                    <th class="p-3">Événement</th>
                    <th class="p-3">Représentant</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($candidates as $c)
                    <tr class="border-t">
                        <td class="p-3">
                            {{ $c->first_name }} {{ $c->last_name }}
                        </td>
                        
                        <td class="p-3 font-mono text-sm text-blue-600">
                            {{ $c->code }}
                        </td>
                        
                        <td class="p-3">
                            {{ $c->phone }}
                        </td>

                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-white
                                @if($c->status == 'paid') bg-green-500
                                @elseif($c->status == 'pending') bg-yellow-500
                                @elseif($c->status == 'rejected') bg-red-500
                                @else bg-gray-500
                                @endif">
                                {{ $c->status }}
                            </span>
                        </td>

                        <td class="p-3">
                            {{ $c->module->name ?? '-' }}
                        </td>

                        <td class="p-3">
                            {{ $c->event->name ?? '-' }}
                        </td>

                        <td class="p-3">
                            {{ $c->user->name ?? '-' }}
                        </td>

                        <td class="p-3 space-y-2">

                            <!-- 👁️ Voir -->
                            <a href="{{ route('candidates.show', $c->id) }}"
                               class="text-blue-600 underline">
                                Voir
                            </a>

                            <!-- 🔄 Changer statut -->
                            <form method="POST" action="{{ route('candidates.update', $c->id) }}">
                                @csrf
                                @method('PUT')

                                <select name="status" class="border p-1">
                                    <option value="pending">pending</option>
                                    <option value="paid">paid</option>
                                    <option value="validated">validated</option>
                                    <option value="rejected">rejected</option>
                                    <option value="completed">completed</option>
                                </select>

                                <button class="bg-green-500 text-white px-2 py-1 rounded">
                                    OK
                                </button>
                            </form>

                            <!-- ❌ Rejeter -->
                            <form method="POST" action="{{ route('candidates.destroy', $c->id) }}">
                                @csrf
                                @method('DELETE')

                                <button class="bg-red-600 text-white px-2 py-1 rounded">
                                    Rejeter
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center">
                            Aucun candidat trouvé
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    <!-- 📄 PAGINATION -->
    <div class="mt-6">
        {{ $candidates->links() }}
    </div>

</div>

@endsection