<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Halaman utama
Route::get('/', function () {
    return view('welcome');
})->name('home');


// ===================== 📊 DASHBOARD USER ===================== //
// User biasa akan diarahkan oleh DashboardController
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


// ===================== 🛠 DASHBOARD ADMIN ===================== //
// Admin login akan diarahkan ke sini secara otomatis
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])
        ->name('admin.dashboard');
});


// ===================== 🔒 ROUTE UNTUK USER LOGIN ===================== //
Route::middleware('auth')->group(function () {

    // ✂️ Booking
    Route::get('/bookings', [BookingController::class, 'index'])
        ->name('bookings.index');

    Route::get('/booking', [BookingController::class, 'create'])
        ->name('book.create');

    Route::post('/booking', [BookingController::class, 'store'])
        ->name('book.store');

    Route::get('/booking/available-times', [BookingController::class, 'getAvailableTimes'])
        ->name('booking.available-times');

    // 👤 Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


// ===================== 🔑 GOOGLE AUTH ===================== //
Route::prefix('auth/google')->name('auth.google.')->group(function () {
    Route::get('/', [GoogleController::class, 'redirect'])->name('redirect');
    Route::get('/callback', [GoogleController::class, 'callback'])->name('callback');
});


// Default Breeze/Jetstream routes
require __DIR__ . '/auth.php';
