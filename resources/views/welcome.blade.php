<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bosque Barbershop</title>
    <!-- Stylish Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;800&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="font-sans antialiased bg-white text-gray-800">

    <header class="fixed top-0 left-0 w-full bg-white shadow z-50">
        <div class="container mx-auto flex justify-between items-center px-6 py-4">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <img src="{{ asset('images/bosque.jpg') }}" alt="Logo" class="h-16 w-auto">
            </a>

            <!-- NAV MENU -->
            <nav class="hidden md:flex space-x-8 text-lg font-medium tracking-wide"
                style="font-family: 'Montserrat', sans-serif;">

                <a href="{{ route('home') }}"
                    class="relative pb-1 hover:text-blue-600 transition
                      after:content-[''] after:absolute after:left-0 after:bottom-0 
                      after:h-[2px] after:w-0 after:bg-blue-600 after:transition-all after:duration-300
                      hover:after:w-full">
                    Home
                </a>

                @guest
                <a href="{{ route('login') }}"
                    class="relative pb-1 hover:text-blue-600 transition
                      after:content-[''] after:absolute after:left-0 after:bottom-0 
                      after:h-[2px] after:w-0 after:bg-blue-600 after:transition-all after:duration-300
                      hover:after:w-full">
                    Book
                </a>
                @else
                <a href="{{ route('book.create') }}"
                    class="relative pb-1 hover:text-blue-600 transition
                      after:content-[''] after:absolute after:left-0 after:bottom-0 
                      after:h-[2px] after:w-0 after:bg-blue-600 after:transition-all after:duration-300
                      hover:after:w-full">
                    Book
                </a>
                @endguest

                <a href="#services"
                    class="relative pb-1 hover:text-blue-600 transition
                      after:content-[''] after:absolute after:left-0 after:bottom-0 
                      after:h-[2px] after:w-0 after:bg-blue-600 after:transition-all after:duration-300
                      hover:after:w-full">
                    Services
                </a>

                <a href="#about"
                    class="relative pb-1 hover:text-blue-600 transition
                      after:content-[''] after:absolute after:left-0 after:bottom-0 
                      after:h-[2px] after:w-0 after:bg-blue-600 after:transition-all after:duration-300
                      hover:after:w-full">
                    About Us
                </a>

                <a href="#contact"
                    class="relative pb-1 hover:text-blue-600 transition
                      after:content-[''] after:absolute after:left-0 after:bottom-0 
                      after:h-[2px] after:w-0 after:bg-blue-600 after:transition-all after:duration-300
                      hover:after:w-full">
                    Contact
                </a>
            </nav>

            <!-- Login/Register OR Dashboard/Logout -->
            <div class="hidden md:flex space-x-2 items-center" style="font-family: 'Montserrat', sans-serif;">
                @auth
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                        Logout
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                    Login
                </a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                    Register
                </a>
                @endauth
            </div>

            <!-- MOBILE MENU BUTTON -->
            <button id="mobileMenuBtn" class="md:hidden focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-700" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- MOBILE MENU DROPDOWN -->
        <div id="mobileMenu" class="hidden md:hidden bg-white pb-6 px-6 space-y-4 shadow"
            style="font-family: 'Montserrat', sans-serif;">

            <a href="{{ route('home') }}" class="block text-lg">Home</a>

            @guest
            <a href="{{ route('login') }}" class="block text-lg">Book</a>
            @else
            <a href="{{ route('book.create') }}" class="block text-lg">Book</a>
            @endguest

            <a href="#services" class="block text-lg">Services</a>
            <a href="#about" class="block text-lg">About Us</a>
            <a href="#contact" class="block text-lg">Contact</a>

            @auth
            <a href="{{ route('dashboard') }}" class="block text-lg">Dashboard</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="mt-2 text-left w-full text-lg">Logout</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="block text-lg">Sign In</a>
            <a href="{{ route('register') }}" class="block text-lg">Sign Up</a>
            @endauth
        </div>
    </header>

    <!-- Simple JS for Mobile Menu -->
    <script>
        const btn = document.getElementById('mobileMenuBtn');
        const menu = document.getElementById('mobileMenu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>

    <!-- Hero Section -->
    <section class="h-screen flex items-center justify-center bg-cover bg-center relative"
        style="background-image:url('{{ asset('images/bgwelcome.png') }}')">

        <div class="absolute inset-0 bg-black bg-opacity-0"></div>

        <div class="relative container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-8 items-center z-10">
            <div></div>

            <div class="relative w-full max-w-lg mx-auto h-[500px] overflow-hidden rounded-2xl"
                x-data="{ 
        active: 0, 
        slides: [
            '{{ asset('images/slideshow/fery.png') }}',
            '{{ asset('images/slideshow/ajay.png') }}',
            '{{ asset('images/slideshow/bangdul.png') }}',
            '{{ asset('images/slideshow/sidik.png') }}',
            '{{ asset('images/slideshow/anjas.png') }}'
        ] 
    }"
                x-init="setInterval(() => { active = (active + 1) % slides.length }, 1500)">

                <template x-for="(slide, index) in slides" :key="index">
                    <img
                        :src="slide"
                        x-show="active === index"
                        x-transition.opacity
                        class="absolute inset-0 w-full h-full object-contain transition-opacity duration-700 bg-transparent pointer-events-none">
                </template>
            </div>


        </div>

        <div class="absolute bottom-12 left-1/2 transform -translate-x-1/2 z-20">
            @guest
            <a href="{{ route('login') }}"
                class="px-10 py-4 bg-blue-500 rounded-lg text-white text-xl font-semibold hover:bg-blue-600 shadow-lg">
                Book Now
            </a>
            @else
            <a href="{{ route('book.create') }}"
                class="px-10 py-4 bg-blue-500 rounded-lg text-white text-xl font-semibold hover:bg-blue-600 shadow-lg">
                Book Now
            </a>
            @endguest
        </div>
    </section>
    <section id="services"
        class="py-20 bg-cover bg-center bg-no-repeat relative"
        style="background-image: url('{{ asset('images/bgservices.jpg') }}')">

        <div class="relative container mx-auto px-6 text-center z-10">

            <h2 class="text-4xl md:text-4xl font-extrabold mb-12 text-black tracking-wide"
                style="font-family: 'Cinzel', serif;">
                OUR SERVICES
            </h2>


            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                {{-- Background diubah menjadi putih solid (bg-white) --}}
                <div class="p-6 bg-white rounded-xl shadow hover:shadow-xl transition duration-300">
                    <img src="{{ asset('images/ourservices/haircut.png') }}"
                        alt="Haircut"
                        class="h-40 w-full object-cover rounded-lg mb-4">

                    <h3 class="text-xl font-semibold mb-2 tracking-wide"
                        style="font-family: 'Montserrat', sans-serif;">
                        Haircut
                    </h3>

                    <p class="text-gray-700 leading-relaxed tracking-wide"
                        style="font-family: 'Montserrat', sans-serif; font-weight: 400;">
                        Premium cut, kids haircut, dan long haircut sesuai gaya kamu.
                    </p>
                </div>

                {{-- Background diubah menjadi putih solid (bg-white) --}}
                <div class="p-6 bg-white rounded-xl shadow hover:shadow-xl transition duration-300">
                    <img src="{{ asset('images/ourservices/chemical.png') }}"
                        alt="Chemical"
                        class="h-40 w-full object-cover rounded-lg mb-4">

                    <h3 class="text-xl font-semibold mb-2 tracking-wide"
                        style="font-family: 'Montserrat', sans-serif;">
                        Chemical
                    </h3>

                    <p class="text-gray-700 leading-relaxed tracking-wide"
                        style="font-family: 'Montserrat', sans-serif; font-weight: 400;">
                        Perawatan chemical seperti smoothing, perm, dan lainnya.
                    </p>
                </div>

                {{-- Background diubah menjadi putih solid (bg-white) --}}
                <div class="p-6 bg-white rounded-xl shadow hover:shadow-xl transition duration-300">
                    <img src="{{ asset('images/ourservices/haircare.png') }}"
                        alt="Haircare"
                        class="h-40 w-full object-cover rounded-lg mb-4">

                    <h3 class="text-xl font-semibold mb-2 tracking-wide"
                        style="font-family: 'Montserrat', sans-serif;">
                        Haircare & Extras
                    </h3>

                    <p class="text-gray-700 leading-relaxed tracking-wide"
                        style="font-family: 'Montserrat', sans-serif; font-weight: 400;">
                        Perawatan kesehatan rambut serta layanan tambahan.
                    </p>
                </div>

                {{-- Background diubah menjadi putih solid (bg-white) --}}
                <div class="p-6 bg-white rounded-xl shadow hover:shadow-xl transition duration-300">
                    <img src="{{ asset('images/ourservices/coloring.png') }}"
                        alt="Colouring"
                        class="h-40 w-full object-cover rounded-lg mb-4">

                    <h3 class="text-xl font-semibold mb-2 tracking-wide"
                        style="font-family: 'Montserrat', sans-serif;">
                        Colouring
                    </h3>

                    <p class="text-gray-700 leading-relaxed tracking-wide"
                        style="font-family: 'Montserrat', sans-serif; font-weight: 400;">
                        Pewarnaan rambut profesional untuk tampilan baru yang fresh.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- About Us -->
    <section id="about" class="relative min-h-[550px] bg-cover bg-center flex items-center justify-center"
        style="background-image: url('{{ asset('images/bosque2.png') }}')">

        <div class="absolute inset-0 bg-black bg-opacity-60"></div>

        <div class="relative container mx-auto px-6 text-center text-white max-w-4xl">
            <h2 class="text-4xl md:text-4xl font-extrabold mb-6 tracking-[0.25em] drop-shadow-2xl"
                style="font-family: 'Cinzel', serif;">
                ABOUT US
            </h2>


            <p class="text-xl md:text-2xl font-semibold leading-relaxed tracking-wide drop-shadow-xl"
                style="font-family: 'Montserrat', sans-serif;">
                Bosque Barbershop adalah barbershop modern dengan tim hairstylist berpengalaman.
                Kami berkomitmen memberikan layanan grooming terbaik, presisi potongan, dan kenyamanan premium agar setiap
                pelanggan tampil rapi, stylish, dan penuh percaya diri setiap hari.
            </p>
        </div>
    </section>



    <!-- Contact (Solid Dark Blue Background) -->
    <section id="contact"
        class="py-20 bg-center bg-cover relative"
        style="background-color: #213545;">


        <div class="absolute inset-0 bg-black/40"></div>

        <div class="container mx-auto px-6 relative z-10">

            <!-- ⭐ Stylish Title -->
            <h2 class="text-4xl md:text-4xl font-extrabold text-center mb-12 text-white drop-shadow-lg tracking-wide"
                style="font-family: 'Cinzel', serif;">
                CONTACT
            </h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-6xl mx-auto">

                <!-- MAP -->
                <div class="w-full h-96 rounded-2xl overflow-hidden shadow-2xl">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.130379031481!2d108.22083517592671!3d-7.339252172194017!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f572401e4d7fd%3A0x4c182bcf3a813613!2sBosque%20Barbershop!5e0!3m2!1sid!2sid!4v1756646781837!5m2!1sid!2sid"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <!-- CONTACT CARD -->
                <div class="bg-white/85 backdrop-blur-lg shadow-xl rounded-2xl p-8">

                    <h3 class="text-2xl font-semibold mb-4 text-gray-900 tracking-wide"
                        style="font-family: 'Montserrat', sans-serif;">
                        Alamat & Kontak
                    </h3>

                    <p class="text-gray-700 mb-2">🏠 Jl. Cikalang Girang No.48 G, Kahuripan, Tasikmalaya</p>

                    <p class="text-gray-700 mb-2">
                        📞 WhatsApp:
                        <a href="https://wa.me/628157123448" class="text-blue-600 hover:underline font-medium">
                            +62 815-7123-448
                        </a>
                    </p>

                    <p class="text-gray-700 mb-6">✉️ Email: bosquebarbershop@gmail.com</p>

                    <h3 class="text-2xl font-semibold mb-4 text-gray-900 tracking-wide"
                        style="font-family: 'Montserrat', sans-serif;">
                        Jam Operasional
                    </h3>

                    <ul class="text-gray-700 space-y-2">
                        <li>Senin – Kamis: 10:00 – 21:00</li>
                        <li>Jumat: 13:00 – 21:00</li>
                        <li>Sabtu – Minggu: 10:00 – 21:00</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>





    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 text-center py-10">
        <div class="container mx-auto px-6">
            <p class="mb-4">&copy; {{ date('Y') }} Bosque Barbershop. All rights reserved.</p>

            <div class="mt-4">
                <h3 class="text-lg font-semibold mb-3">Our Socials</h3>
                <div class="flex justify-center space-x-6">
                    <!-- TikTok -->
                    <a href="https://www.tiktok.com/@bosquebarbershop" target="_blank" class="hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-6 h-6">
                            <path d="M12.9 2c.4 2.4 2.3 4.3 4.7 4.7V9c-1.7 0-3.2-.6-4.7-1.5V14c0 3.5-2.8 6.3-6.3 6.3S.3 17.5.3 14 3.1 7.7 6.6 7.7c.6 0 1.2.1 1.7.2v2.6c-.6-.2-1.1-.3-1.7-.3-2.1 0-3.8 1.7-3.8 3.8s1.7 3.8 3.8 3.8 3.8-1.7 3.8-3.8V2h2.5z" />
                        </svg>
                    </a>

                    <!-- YouTube -->
                    <a href="https://www.youtube.com/@barbershoptv703" target="_blank" class="hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-6 h-6">
                            <path d="M23.5 6.2s-.2-1.7-.8-2.4c-.8-.9-1.7-.9-2.1-1C17.4 2.5 12 2.5 12 2.5h0s-5.4 0-8.6.3c-.5.1-1.3.1-2.1 1-.6.7-.8 2.4-.8 2.4S0 8.1 0 10v1.9c0 1.9.2 3.8.2 3.8s.2 1.7.8 2.4c.8.9 1.9.8 2.4.9 1.7.2 7 .3 7 .3s5.4 0 8.6-.3c.5-.1 1.3-.1 2.1-1 .6-.7.8-2.4.8-2.4s.2-1.9.2-3.8V10c0-1.9-.2-3.8-.2-3.8zM9.6 14.7V8.7l6.1 3-6.1 3z" />
                        </svg>
                    </a>

                    <!-- Instagram -->
                    <a href="https://www.instagram.com/bosque.barbershop" target="_blank" class="hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-6 h-6">
                            <path d="M12 2.2c3.2 0 3.6 0 4.9.1 1.2.1 1.9.2 2.4.4.6.2 1 .4 1.5.9.4.4.7.9.9 1.5.2.5.3 1.2.4 2.4.1 1.3.1 1.7.1 4.9s0 3.6-.1 4.9c-.1 1.2-.2 1.9-.4 2.4-.2.6-.4 1-.9 1.5-.4.4-.9.7-1.5.9-.5.2-1.2.3-2.4.4-1.3.1-1.7.1-4.9.1s-3.6 0-4.9-.1c-1.2-.1-1.9-.2-2.4-.4-.6-.2-1-.4-1.5-.9-.4-.4-.7-.9-.9-1.5-.2-.5-.3-1.2-.4-2.4-.1-1.3-.1-1.7-.1-4.9s0-3.6.1-4.9c.1-1.2.2-1.9.4-2.4.2-.6.4-1 .9-1.5.4-.4.9-.7 1.5-.9.5-.2 1.2-.3 2.4-.4 1.3-.1 1.7-.1 4.9-.1zm0 1.8c-3.1 0-3.5 0-4.7.1-1 .1-1.5.2-1.8.3-.4.1-.6.3-.9.6-.3.3-.5.5-.6.9-.1.3-.3.8-.3 1.8-.1 1.2-.1 1.6-.1 4.7s0 3.5.1 4.7c.1 1 .2 1.5.3 1.8.1.4.3.6.6.9.3.3.5.5.9.6.3.1.8.3 1.8.3 1.2.1 1.6.1 4.7.1s3.5 0 4.7-.1c1-.1 1.5-.2 1.8-.3.4-.1.6-.3.9-.6.3-.3.5-.5.6-.9.1-.3.3-.8.3-1.8.1-1.2.1-1.6.1-4.7s0-3.5-.1-4.7c-.1-1-.2-1.5-.3-1.8-.1-.4-.3-.6-.6-.9-.3-.3-.5-.5-.9-.6-.3-.1-.8-.3-1.8-.3-1.2-.1-1.6-.1-4.7-.1zm0 3.4a5.6 5.6 0 1 1 0 11.2 5.6 5.6 0 0 1 0-11.2zm0 9.2a3.6 3.6 0 1 0 0-7.2 3.6 3.6 0 0 0 0 7.2zm5.7-9.4a1.3 1.3 0 1 1 0-2.6 1.3 1.3 0 0 1 0 2.6z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>


</body>

</html>