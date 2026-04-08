<div class="w-64 bg-white border-r min-h-screen p-4">

    <!-- LOGO -->
    <div class="mb-8 text-xl font-bold text-green-600">
        ECOLAB
    </div>

    <!-- MENU -->
    <nav class="space-y-2 text-sm">

        <!-- DASHBOARD -->
        <a href="/dashboard"
           class="block px-3 py-2 rounded hover:bg-gray-100">
            🏠 Dashboard
        </a>

        <!-- ADMIN -->
       
        @if(auth()->user()->role === 'admin')

            <a href="/admin/events" class="block px-3 py-2 rounded hover:bg-gray-100">
                📅 Événements
            </a>

            <a href="/admin/modules" class="block px-3 py-2 rounded hover:bg-gray-100">
                📚 Modules
            </a>

            <a href="/admin/centers" class="block px-3 py-2 rounded hover:bg-gray-100">
                🏫 Centres
            </a>

            <a href="/admin/representatives" class="block px-3 py-2 rounded hover:bg-gray-100">
                👤 Représentants
            </a>

            <a href="/admin/candidates" class="block px-3 py-2 rounded hover:bg-gray-100">
                👥 Candidats
            </a>

            <a href="/admin/commissions" class="block px-3 py-2 rounded hover:bg-gray-100">
                💰 Commissions
            </a>

            <a href="/admin/reports" class="block px-3 py-2 rounded hover:bg-gray-100">
                📊 Rapports
            </a>
            
           <a href="{{ route('admin.contacts') }}"
            class="flex justify-between items-center text-gray-700 hover:text-green-600">

                <span>📩 Messages</span>

                @isset($contactsCount)
                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                        {{ $contactsCount }}
                    </span>
                @endisset

            </a>

        @endif

        <!-- REPRESENTANT -->
        @if(auth()->user()->role === 'representative')

            <a href="{{ route('representative.rep.dashboard') }}"
               class="block px-3 py-2 rounded hover:bg-gray-100">
                📊 Mon activité
            </a>

            <a href="{{ route('representative.candidates.create') }}"
               class="block px-3 py-2 rounded hover:bg-gray-100">
                ➕ Inscrire candidat
            </a>

        @endif

    </nav>

    <!-- LOGOUT -->
    <div class="mt-10 border-t pt-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-red-600 text-sm">
                🚪 Déconnexion
            </button>
        </form>
    </div>

</div>