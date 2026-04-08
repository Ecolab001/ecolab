@extends('layouts.app')

@section('content')

<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">Événements</h1>

    <!-- ✅ BOUTON CREATION -->
    <a href="{{ route('events.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
        + Créer un événement
    </a>

    <!-- 📋 TABLE -->
    <div class="bg-white shadow rounded overflow-x-auto mt-4">

        <table class="w-full border-collapse">

            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 text-left">Nom</th>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-left">Statut</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($events as $event)
                    <tr class="border-t">

                        <td class="p-3">
                            {{ $event->name }}
                        </td>

                        <td class="p-3">
                            {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}
                        </td>

                        <td class="p-3">
                            <span class="px-2 py-1 text-white rounded
                                @if($event->status == 'active') bg-green-500
                                @else bg-gray-500
                                @endif">
                                {{ $event->status }}
                            </span>
                        </td>

                        <td class="p-3 space-x-2">

                            <!-- 🔄 Toggle -->
                            <form method="POST" action="{{ route('events.toggle', $event->id) }}" style="display:inline;">
                                @csrf
                                <button class="bg-yellow-500 text-white px-2 py-1 rounded">
                                    Toggle
                                </button>
                            </form>

                            <!-- ✏️ Edit -->
                            <a href="{{ route('events.edit', $event->id) }}"
                               class="bg-blue-500 text-white px-2 py-1 rounded">
                                Edit
                            </a>

                            <!-- ❌ Delete -->
                            <form method="POST" action="{{ route('events.destroy', $event->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button class="bg-red-600 text-white px-2 py-1 rounded">
                                    Supprimer
                                </button>
                            </form>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center">
                            Aucun événement trouvé
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

    <!-- 📄 PAGINATION -->
    <div class="mt-6">
        {{ $events->links() }}
    </div>

</div>

@endsection