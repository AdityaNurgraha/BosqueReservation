<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Mail\BookingConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    /**
     * Simpan booking dan kirim email konfirmasi
     */
    public function store(Request $request)
    {
        // 1️⃣ Validasi input
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email',
            'phone'         => 'required|string|max:20',
            'store'         => 'required|string|max:255',
            'gender'        => 'nullable|string|max:50',
            'service'       => 'required|string|max:255',
            'barber'        => 'nullable|string|max:255',
            'booking_date'  => 'required|date',
            'booking_time'  => 'required',
        ]);

        DB::beginTransaction();

        try {
            // 2️⃣ Simpan ke database
            $booking = Booking::create([
                'name'          => $validated['name'],
                'email'         => $validated['email'],
                'phone'         => $validated['phone'],
                'store'         => $validated['store'],
                'gender'        => $validated['gender'] ?? null,
                'service'       => $validated['service'],
                'barber'        => $validated['barber'] ?? null,
                'booking_date'  => $validated['booking_date'],
                'booking_time'  => $validated['booking_time'],
            ]);

            // 3️⃣ Kirim email (TANPA QUEUE)
            Mail::to($booking->email)
                ->send(new BookingConfirmationMail($booking));

            DB::commit();

            // 4️⃣ Response sukses
            return redirect()
                ->back()
                ->with('success', 'Booking berhasil. Konfirmasi telah dikirim ke email Anda.');
        } catch (\Throwable $e) {
            DB::rollBack();

            // 5️⃣ Log error untuk Railway
            Log::error('Booking confirmation email failed', [
                'error'   => $e->getMessage(),
                'booking' => $validated,
            ]);

            return redirect()
                ->back()
                ->with('error', 'Booking berhasil disimpan, tetapi email gagal dikirim.');
        }
    }
}
