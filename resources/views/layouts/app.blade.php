<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bosque Barbershop') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white text-gray-800">

    <!-- Navbar -->
    <header class="fixed top-0 left-0 w-full bg-white shadow z-50">
        <div class="container mx-auto flex justify-between items-center px-6 py-4">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <img src="{{ asset('images/bosque.jpeg') }}" alt="Logo" class="h-16 w-auto">
            </a>

            <!-- Menu -->
            <nav class="space-x-6">
                <a href="{{ route('home') }}" class="hover:text-blue-500">Home</a>
                <a href="{{ route('book.create') }}" class="hover:text-blue-500"
                    @guest onclick="alert('Login dulu untuk booking'); return false;" @endguest>
                    Book
                </a>
                <a href="#about" class="hover:text-blue-500">About Us</a>
                <a href="#contact" class="hover:text-blue-500">Contact</a>
            </nav>

            <!-- Login/Register -->
            <div class="flex space-x-2">
                @auth
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Login</a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Register</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <main class="pt-24"> {{-- tambah padding top biar ga ketutup navbar --}}
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 text-center py-6 mt-10">
        <p>&copy; {{ date('Y') }} Bosque Barbershop. All rights reserved.</p>
    </footer>

    <!-- Alpine.js for slideshow -->
    <script src="//unpkg.com/alpinejs" defer></script>
</body>

</html>