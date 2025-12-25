<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center relative"
         style="background-image: url('{{ asset('images/bg-login.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>

        <div class="z-10 bg-white/80 backdrop-blur-md rounded-xl shadow-xl p-8 w-full max-w-md text-center">
            
            <div class="mb-6">
                <div class="flex items-center justify-center mb-4">
                    <img src="{{ asset('images/logomini.png') }}" alt="Bosque" class="h-8 mx-auto">
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Sign In</h2>
                <p class="text-gray-600 text-sm">Enter your email and password</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4 text-left">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full"
                                     type="email" name="email"
                                     required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-4 text-left">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full"
                                     type="password" name="password"
                                     required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" name="remember"
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <x-primary-button class="w-full justify-center">
                     {{ __('Sign In') }}
                </x-primary-button>

                <div class="mt-6">
                    <a href="{{ route('auth.google.redirect') }}"
                       class="flex items-center justify-center gap-2 w-full border border-gray-300 rounded-lg py-2 hover:bg-gray-100 transition">
                        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" class="w-5 h-5">
                        <span class="text-gray-700">Sign in with Google</span>
                    </a>
                </div>

                <p class="text-sm text-gray-600 mt-6">
                    Don't have an account yet?
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Sign Up!</a>
                </p>

                <p class="text-xs text-gray-500 mt-4">© 2025 Bosque</p>
            </form>
        </div>
    </div>
</x-guest-layout>
