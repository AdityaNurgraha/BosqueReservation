<x-admin-layout>
    <div class="max-w-7xl mx-auto" id="print-area">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 no-print">
            <div class="flex flex-col md:flex-row gap-2 items-start md:items-center">
                <form method="GET" class="flex gap-2 items-center">
                    <label for="range" class="font-semibold text-gray-700 dark:text-gray-200">Filter:</label>
                    <select name="range" onchange="this.form.submit()" class="border rounded p-2 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        <option value="all" {{ $range=='all' ? 'selected' : '' }}>All</option>
                        <option value="daily" {{ $range=='daily' ? 'selected' : '' }}>Daily</option>
                        <option value="weekly" {{ $range=='weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ $range=='monthly' ? 'selected' : '' }}>Monthly</option>
                    </select>
                </form>

                <button onclick="window.print()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow transition mt-2 md:mt-0">
                    Print Report
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 print-grid">
            @forelse($bookings as $booking)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transform hover:scale-105 transition duration-300 print-card">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $booking->service }}</h3>
                    @if($booking->sub_service != '-')
                    <span class="bg-orange-100 text-orange-700 text-xs font-semibold px-2 py-1 rounded-full">{{ $booking->sub_service }}</span>
                    @endif
                </div>

                <div class="space-y-1 text-gray-700 dark:text-gray-300">
                    <p><strong>Nama:</strong> {{ $booking->name ?? '-' }}</p>
                    <p><strong>No HP:</strong> {{ $booking->phone ?? '-' }}</p>
                    <p><strong>Store:</strong> {{ $booking->store }}</p>
                    <p><strong>Barber:</strong> {{ $booking->barber }}</p>
                    <p><strong>Gender:</strong> {{ $booking->gender }}</p>
                    <p>
                        <strong>Date & Time:</strong>
                        {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }} -
                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->time)->format('H:i') }}
                    </p>
                </div>

                <p class="text-orange-600 font-bold text-lg mt-4">Rp {{ number_format($booking->price, 0, ',', '.') }}</p>
            </div>
            @empty
            <p class="text-gray-700 dark:text-gray-200 col-span-3">No bookings found for selected range.</p>
            @endforelse
        </div>

    </div>


    <style>
        /* ==== PRINT MODE ==== */

        @media print {

            /* Sembunyikan semua selain #print-area */
            body * {
                visibility: hidden !important;
            }

            #print-area,
            #print-area * {
                visibility: visible !important;
            }

            /* Hilangkan tombol, form, header, footer, sidebar */
            .no-print,
            .no-print * {
                display: none !important;
            }

            /* Layout print full halaman */
            #print-area {
                position: static !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            /* Hapus shadow, border, efek hover */
            .print-card {
                box-shadow: none !important;
                transform: none !important;
                border: 1px solid #000 !important;
                page-break-inside: avoid;
            }

            /* Grid jadi 1 kolom agar rapi di kertas */
            .print-grid {
                display: block !important;
            }

            .print-grid > * {
                margin-bottom: 20px !important;
            }

            /* Background putih saja */
            .dark\:bg-gray-800,
            .bg-white {
                background: #fff !important;
                color: #000 !important;
            }

            /* Hapus warna teks yang tidak perlu */
            .text-orange-600 {
                color: #000 !important;
            }

            /* Hapus border radius */
            .rounded-2xl {
                border-radius: 0 !important;
            }
        }
    </style>

</x-admin-layout>
