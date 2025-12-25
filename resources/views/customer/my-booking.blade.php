<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Booking - Bosque Barbershop</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background-image: url("{{ asset('images/bg-booking.jpg') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>

<body class="text-gray-800 backdrop-blur-sm">

    <div class="min-h-screen bg-black/40 backdrop-blur-md">

        <header class="bg-black/30 backdrop-blur-xl border-b border-white/10">
            <div class="max-w-5xl mx-auto flex justify-between items-center py-6 px-4">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-wide text-white">
                        My Booking
                    </h1>
                    <p class="text-gray-300 text-sm">Hi,
                        <span class="font-medium text-blue-400">{{ Auth::user()->name }}</span>
                    </p>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('book.create') }}"
                        class="text-blue-400 font-semibold hover:text-blue-300 transition">
                        + New Booking
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="bg-blue-500 text-white px-5 py-2 rounded-xl font-semibold shadow-md hover:bg-blue-600 transition">
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </header>

        @if (session('success'))
        <div class="max-w-5xl mx-auto px-4 mt-6">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded-lg shadow-md transition duration-500 ease-in-out" role="alert">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3 fill-current text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M0 11l2-2 5 5L18 3l2 2L7 18z"/>
                    </svg>
                    <div>
                        <p class="font-semibold">Pemesanan Berhasil Dibuat</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="max-w-5xl mx-auto px-4 space-y-8 py-10">

            @if($bookings->isEmpty())
            <p class="text-gray-200 text-center py-10 text-lg">
                You don’t have any bookings yet.
            </p>
            @endif

            @php $tz = 'Asia/Jakarta'; @endphp

            @foreach ($bookings as $booking)
            @php
                try { $date = \Carbon\Carbon::parse($booking->date)->format('Y-m-d'); } catch (\Exception $e) { $date = $booking->date; }
                try { $time = \Carbon\Carbon::parse($booking->time)->format('H:i'); } catch (\Exception $e) { $time = substr($booking->time,0,5); }

                $bookingDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $date." ".$time, $tz);
                $now = \Carbon\Carbon::now($tz);

                $status = $bookingDateTime->lte($now) ? 'Completed' : 'Upcoming';
                $statusColor = $status === 'Completed'
                    ? 'bg-gray-500'
                    : 'bg-green-500';
            @endphp

            <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-2xl overflow-hidden border border-gray-200">

                <div class="flex justify-between items-center p-5 border-b border-gray-200 bg-gray-50/70">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Booking Receipt</h2>
                        <p class="text-sm text-gray-500">Bosque Barbershop</p>
                    </div>

                    <span class="px-3 py-1 rounded-full text-white text-sm {{ $statusColor }} shadow">
                        {{ $status }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 text-sm">

                    <div class="space-y-3">
                        <div>
                            <p class="text-gray-500">Nama</p>
                            <p class="font-semibold capitalize text-gray-900">{{ $booking->name ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">No HP</p>
                            <p class="font-semibold text-gray-900">{{ $booking->phone ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">Store</p>
                            <p class="font-semibold capitalize text-gray-900">{{ $booking->store }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">Gender</p>
                            <p class="font-semibold capitalize text-gray-900">{{ $booking->gender }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">Service</p>
                            <p class="font-semibold capitalize text-gray-900">{{ $booking->service }}</p>
                        </div>

                        @if ($booking->sub_service)
                        <div>
                            <p class="text-gray-500">Sub Service</p>
                            <p class="font-semibold capitalize text-gray-900">{{ $booking->sub_service }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="space-y-3">
                        <div>
                            <p class="text-gray-500">Barber</p>
                            <p class="font-semibold capitalize text-gray-900">{{ $booking->barber }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">Date</p>
                            <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">Time</p>
                            <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($booking->time)->format('H:i') }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">Total Price</p>
                            <p class="text-blue-600 font-bold text-lg">
                                Rp {{ number_format($booking->price ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                </div>

                <div class="p-4 border-t bg-white/60 flex justify-center">
                    @if($status === 'Upcoming')
                    <button 
                        id="reschedule-btn-{{ $booking->id }}"
                        onclick="openNotif('{{ $booking->id }}')"
                        class="bg-blue-500 text-white px-6 py-2 rounded-lg text-sm font-semibold hover:bg-blue-600 shadow transition">
                        Reschedule
                    </button>
                    @endif
                </div>

                <div class="bg-gray-100/80 text-xs text-gray-500 border-t border-gray-300 p-4 text-center">
                    Booking ID: <span class="font-semibold">{{ $booking->id }}</span><br>
                    <span class="text-gray-400">
                        Server time ({{ $tz }}): {{ \Carbon\Carbon::now($tz)->format('d M Y H:i') }}
                    </span>
                </div>

            </div>

            @endforeach
        </div>
    </div>

    <div id="notifPopup"
    class="hidden fixed inset-0 flex items-center justify-center bg-black/20 z-50">
    <div class="bg-white rounded-xl shadow-xl p-6 text-center w-64 border border-gray-200">
        <h3 class="text-lg font-bold mb-1">Reschedule Booking</h3>
        <p class="text-gray-600 text-sm">
            Untuk perubahan jadwal booking, hubungi admin:
        </p>

        <p class="text-lg font-semibold text-blue-600 mt-2">
            📞 0812-3456-7890
        </p>

        <button onclick="closeNotif()"
            class="mt-4 bg-gray-700 text-white w-full py-2 rounded-lg hover:bg-gray-800 transition">
            Mengerti
        </button>
    </div>
</div>

<script>
    function openNotif() {
        const popup = document.getElementById("notifPopup");
        popup.classList.remove("hidden");
    }

    function closeNotif() {
        const popup = document.getElementById("notifPopup");
        popup.classList.add("hidden");
    }
</script>

<footer class="text-center text-white-300 py-6 bg-black/30 backdrop-blur-xl border-t border-white/10">
    &copy; {{ date('Y') }} Bosque Barbershop. All rights reserved.
</footer>

</body>

</html>