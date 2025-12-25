<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Log;
use Throwable;

class BookingController extends Controller
{
    // =========================
    // Daftar booking user
    // =========================
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $bookings = Booking::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        return view('customer.my-booking', compact('bookings'));
    }

    // =========================
    // Halaman booking
    // =========================
    public function create()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        return view('customer.booking', compact('user'));
    }

    // =========================
    // Simpan booking
    // =========================
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // 1️⃣ VALIDASI
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'phone'       => 'required|string|max:20',
            'store'       => 'required|string',
            'date'        => 'required|date',
            'time'        => 'required|string',
            'gender'      => 'required|string',
            'service'     => 'required|string',
            'sub_service' => 'required|string',
            'barber'      => 'required|string',
            'price'       => 'required|numeric',
        ]);

        // 2️⃣ UPDATE DATA USER
        $user->update([
            'name'  => $validated['name'],
            'phone' => $validated['phone'],
        ]);

        // 3️⃣ CEK DOUBLE BOOKING
        $alreadyBooked = Booking::where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->where('barber', $validated['barber'])
            ->exists();

        if ($alreadyBooked) {
            return back()->with('error', 'Slot jam tersebut sudah dibooking untuk barber yang dipilih.');
        }

        // 4️⃣ SIMPAN BOOKING (WAJIB BERHASIL)
        try {
            $booking = Booking::create([
                'user_id'     => $user->id,
                'name'        => $validated['name'],
                'phone'       => $validated['phone'],
                'store'       => $validated['store'],
                'date'        => $validated['date'],
                'time'        => $validated['time'],
                'gender'      => $validated['gender'],
                'service'     => $validated['service'],
                'sub_service' => $validated['sub_service'],
                'barber'      => $validated['barber'],
                'price'       => $validated['price'],
                'status'      => 'Upcoming',
            ]);
        } catch (Throwable $e) {
            Log::error('Booking create failed', [
                'user_id' => $user->id,
                'error'   => $e->getMessage(),
            ]);

            return back()->with('error', 'Booking gagal dibuat. Silakan coba lagi.');
        }

        // 5️⃣ KIRIM EMAIL (TIDAK BOLEH MEMBUNUH REQUEST)
        try {
            Mail::to($user->email)
                ->send(new BookingConfirmationMail($booking));
        } catch (Throwable $e) {
            Log::warning('Booking email failed', [
                'booking_id' => $booking->id,
                'email'      => $user->email,
                'error'      => $e->getMessage(),
            ]);
        }

        // 6️⃣ PASTI REDIRECT
        return redirect()
            ->route('bookings.index')
            ->with('success', 'Booking berhasil dibuat!');
    }

    // =========================
    // AJAX: Ambil slot terbooking
    // =========================
    public function getAvailableTimes(Request $request)
    {
        $validated = $request->validate([
            'date'   => 'required|date',
            'barber' => 'required|string',
        ]);

        $bookedSlots = Booking::where('date', $validated['date'])
            ->where('barber', $validated['barber'])
            ->pluck('time')
            ->map(fn($t) => substr($t, 0, 5))
            ->toArray();

        return response()->json($bookedSlots);
    }
}
