@extends('layouts.app')

@section('content')

<div class="p-6">

    <h1 class="text-xl font-bold mb-4">Messages reçus</h1>

    <table class="w-full border">
        <tr class="bg-gray-100">
            <th class="p-2">Nom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Sujet</th>
            <th>Message</th>
            <th>Date</th>
            <th>Action</th>
        </tr>

        @foreach($contacts as $c)
        <tr class="border-t">
            <td class="p-2">{{ $c->name }}</td>
            <td>{{ $c->email }}</td>
            <td>{{ $c->phone }}</td>
            <td>{{ $c->subject }}</td>

            <!-- Message raccourci -->
            <td>{{ \Illuminate\Support\Str::limit($c->message, 30) }}</td>

            <td>{{ $c->created_at }}</td>

            <!-- Bouton voir -->
            <td>
            <button 
                class="bg-blue-500 text-white px-2 py-1 rounded text-sm view-btn"
                data-email="{{ $c->email }}"
                data-message="{{ $c->message }}">
                👁 Voir
            </button>
            </td>
        </tr>
        @endforeach

    </table>

</div>

<!-- 🔥 MODAL -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">

    <div class="bg-white p-6 rounded w-96 relative">

        <h2 class="font-bold mb-3 text-lg">Détails du message</h2>

        <p class="font-semibold">Email :</p>
        <p id="modalEmail" class="mb-3 text-gray-700"></p>

        <p class="font-semibold">Message :</p>
        <div class="max-h-60 overflow-y-auto">
    <p id="modalMessage" class="text-gray-700 whitespace-pre-line break-words"></p>
</div>

        <button onclick="closeModal()" 
            class="mt-4 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
            Fermer
        </button>

    </div>

</div>

<!-- 🔥 SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.view-btn').forEach(button => {
        button.addEventListener('click', function () {

            const email = this.dataset.email;
            const message = this.dataset.message;

            document.getElementById('modalEmail').innerText = email;
            document.getElementById('modalMessage').innerText = message;

            document.getElementById('modal').classList.remove('hidden');
        });
    });

});

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}
</script>

@endsection