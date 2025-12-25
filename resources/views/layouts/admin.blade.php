<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bosque Barbershop</title>

    <!-- Stylish & readable font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        .stylish-font {
            font-family: 'Poppins', sans-serif;
        }
        .stylish-title {
            font-family: 'Poppins', sans-serif;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900 bg-cover bg-center bg-no-repeat stylish-font"
      style="background-image: url('/images/bg-booking.jpg')">

    <!-- Navbar -->
    <nav class="bg-white shadow p-4 flex justify-between items-center stylish-font">
        <div class="font-bold text-xl stylish-title text-black">Bosque Admin</div>

        <div class="flex items-center gap-4">
            {{-- Username --}}
            <span class="text-black font-medium">{{ auth()->user()->name }}</span>

            {{-- Logout Button --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition font-semibold">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-10 px-6 stylish-font">
        <h1 class="text-4xl text-black stylish-title font-extrabold tracking-wide mb-6 text-center">
            Booking Dashboard
        </h1>

        {{ $slot }}
    </main>

</body>

</html>
