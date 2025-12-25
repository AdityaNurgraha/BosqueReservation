<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bosque Barbershop</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&display=swap');

        .stylish-font {
            font-family: 'Playfair Display', serif;
        }

        .stylish-title {
            font-family: 'Playfair Display', serif;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900 bg-cover bg-center bg-no-repeat stylish-font"
    style="background-image: url('/images/bg-booking.jpg'); background-attachment: fixed;"> <nav class="bg-white shadow p-4 flex justify-between items-center !text-black stylish-font">
        <div class="font-bold text-xl !text-black stylish-font">Bosque Admin</div>

        <div class="!text-black stylish-font">
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition stylish-font">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <main class="py-10 px-6 stylish-font">

        <h1 class="text-4xl text-black stylish-title font-extrabold tracking-wide mb-6 text-center">
            Booking Dashboard
        </h1>

        {{ $slot }}

    </main>

</body>

</html>