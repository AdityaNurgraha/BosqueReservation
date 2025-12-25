<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // ============================
    // DASHBOARD USER
    // ============================
    public function index(Request $request)
    {
        $user = auth()->user();

        // Jika admin login → arahkan ke admin dashboard, bukan ke user
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // USER DASHBOARD (atau redirect ke booking)
        return redirect()->route('book.create');
    }


    // ============================
    // DASHBOARD ADMIN
    // ============================
    public function adminDashboard(Request $request)
    {
        $range = $request->get('range', 'all');
        $bookings = Booking::query();

        switch ($range) {
            case 'daily':
                $bookings->whereDate('date', Carbon::today());
                break;

            case 'weekly':
                $bookings->whereBetween('date', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
                break;

            case 'monthly':
                $bookings->whereMonth('date', Carbon::now()->month)
                    ->whereYear('date', Carbon::now()->year);
                break;
        }

        $bookings = $bookings->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        return view('dashboard', compact('bookings', 'range'));
    }
}
