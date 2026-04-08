<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-600 to-green-800 px-4">

    <div class="w-full max-w-md">

        <!-- CARD -->
        <div class="bg-white rounded-2xl shadow-xl p-8">

            <!-- LOGO / TITLE -->
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-green-600">ECOLAB Network</h1>
                <p class="text-gray-500 text-sm">Connexion à votre espace</p>
            </div>

            <!-- SESSION STATUS -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- EMAIL -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- PASSWORD -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        type="password"
                        name="password"
                        required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- REMEMBER -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center">
                        <input type="checkbox"
                               name="remember"
                               class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                        <span class="ml-2 text-gray-600">Se souvenir de moi</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-green-600 hover:underline">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <!-- BUTTON -->
                <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-semibold shadow">
                    Se connecter
                </button>

            </form>

        </div>

        <!-- FOOTER -->
        <p class="text-center text-white text-xs mt-4 opacity-80">
            © {{ date('Y') }} ECOLAB Network
        </p>

    </div>

</div>

</x-guest-layout>