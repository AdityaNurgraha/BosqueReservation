<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Log;
use Exception;

class BookingController extends Controller
{
    // Daftar booking user
    public function index()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $bookings = Booking::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        return view('customer.my-booking', compact('bookings'));
    }

    // Halaman booking interaktif
    public function create()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        return view('customer.booking', compact('user'));
    }

    // Simpan booking ke database
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        // Validasi input
        $request->validate([
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

        // Update data user di tabel 'users'
        $user->update([
            'name'  => $request->name,
            'phone' => $request->phone,
        ]);

        // Cek double booking untuk barber & slot
        $alreadyBooked = Booking::where('date', $request->date)
            ->where('time', $request->time)
            ->where('barber', $request->barber)
            ->exists();

        if ($alreadyBooked) {
            return back()->with('error', 'Slot jam tersebut sudah dibooking untuk barber yang dipilih.');
        }

        try {
            // Simpan booking baru
            $booking = Booking::create([
                'user_id'     => $user->id,
                'name'        => $request->name,
                'phone'       => $request->phone,
                'store'       => $request->store,
                'date'        => $request->date,
                'time'        => $request->time,
                'gender'      => $request->gender,
                'service'     => $request->service,
                'sub_service' => $request->sub_service,
                'barber'      => $request->barber,
                'price'       => $request->price,
                'status'      => 'Upcoming',
            ]);
        } catch (Exception $e) {
            Log::error('Booking create error: ' . $e->getMessage());
            return back()->with('error', 'Booking gagal dibuat, silakan coba lagi.');
        }

        // Kirim email konfirmasi secara async (queue)
        try {
            Mail::to($user->email)->queue(new BookingConfirmationMail($booking));
        } catch (Exception $e) {
            Log::error('Email queue error: ' . $e->getMessage());
        }

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dibuat!');
    }

    // AJAX: Ambil booked slots
    public function getAvailableTimes(Request $request)
    {
        $request->validate([
            'date'   => 'required|date',
            'barber' => 'required|string',
        ]);

        $bookedSlots = Booking::where('date', $request->date)
            ->where('barber', $request->barber)
            ->pluck('time')
            ->map(fn($t) => substr($t, 0, 5)) // ambil HH:MM
            ->toArray();

        return response()->json($bookedSlots);
    }
}
