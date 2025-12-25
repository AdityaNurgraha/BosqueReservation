<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center relative"
         style="background-image: url('{{ asset('images/bg-login.jpg') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>

        <div class="z-10 bg-white/80 backdrop-blur-md rounded-xl shadow-xl p-8 w-full max-w-md text-center">

            <div class="mb-6">
                <div class="flex items-center justify-center mb-4">
                    <img src="{{ asset('images/logomini.png') }}" alt="Bosque" class="h-8 mx-auto">
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Sign Up</h2>
                <p class="text-gray-600 text-sm">Create your account to get started</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- NAME --}}
                <div class="mb-4 text-left">
                    <x-input-label for="name" :value="__('Full Name')" />
                    <x-text-input id="name" class="block mt-1 w-full"
                        type="text" name="name"
                        value="{{ old('name') }}"
                        required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- EMAIL --}}
                <div class="mb-4 text-left">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full"
                        type="text" name="email"
                        value="{{ old('email') }}"
                        required autocomplete="username"
                        pattern=".+@.+\..+"
                        oninvalid="this.setCustomValidity('Masukkan email yang valid, contoh: nama@email.com')"
                        oninput="this.setCustomValidity('')"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- PASSWORD --}}
                <div class="mb-4 text-left">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full"
                        type="password" name="password"
                        required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- CONFIRM PASSWORD --}}
                <div class="mb-6 text-left">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                        type="password" name="password_confirmation"
                        required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                {{-- BUTTON REGISTER --}}
                <x-primary-button class="w-full justify-center">
                    {{ __('Sign Up') }}
                </x-primary-button>

                {{-- GOOGLE --}}
                <div class="mt-6">
                    <a href="{{ route('auth.google.redirect') }}"
                        class="flex items-center justify-center gap-2 w-full border border-gray-300 rounded-lg py-2 hover:bg-gray-100 transition">
                        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" class="w-5 h-5">
                        <span class="text-gray-700">Sign up with Google</span>
                    </a>
                </div>

                {{-- LINK LOGIN --}}
                <p class="text-sm text-gray-600 mt-6">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Sign In!</a>
                </p>

                <p class="text-xs text-gray-500 mt-4">© 2025 Bosque</p>
            </form>
        </div>
    </div>
</x-guest-layout>
