<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Mail\BookingConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // 1️⃣ Validasi input
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email',
            'phone'       => 'required|string|max:20',
            'service'     => 'required|string|max:255',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
        ]);

        DB::beginTransaction();

        try {
            // 2️⃣ Simpan booking
            $booking = Booking::create([
                'name'         => $validated['name'],
                'email'        => $validated['email'],
                'phone'        => $validated['phone'],
                'service'      => $validated['service'],
                'booking_date' => $validated['booking_date'],
                'booking_time' => $validated['booking_time'],
            ]);

            // 3️⃣ KIRIM EMAIL (TANPA QUEUE)
            Mail::to($booking->email)
                ->send(new BookingConfirmationMail($booking));

            DB::commit();

            // 4️⃣ Response sukses
            return redirect()
                ->back()
                ->with('success', 'Booking berhasil. Konfirmasi telah dikirim ke email Anda.');
        } catch (\Throwable $e) {
            DB::rollBack();

            // 5️⃣ LOG ERROR (penting di Railway)
            \Log::error('Booking email error', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Booking berhasil, tetapi email gagal dikirim.');
        }
    }
}
