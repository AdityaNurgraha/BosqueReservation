<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    /**
     * Redirect user ke halaman login Google.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Pastikan email ada
            if (!$googleUser->getEmail()) {
                return redirect('/login')->withErrors([
                    'google' => 'Email Google tidak dapat ditemukan.'
                ]);
            }

            // Cari user berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if (!$user) {
                // Buat user baru
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(16)), // password acak
                    'role' => 'customer', // default customer
                ]);
            } else {
                // Update google_id jika belum ada
                if (!$user->google_id) {
                    $user->google_id = $googleUser->getId();
                    $user->save();
                }
            }

            // Login user
            Auth::login($user);

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('dashboard'); // admin dashboard
            } else {
                return redirect()->route('book.create'); // customer booking page
            }

        } catch (Exception $e) {
            \Log::error('Google Login Error: ' . $e->getMessage());

            return redirect('/login')->withErrors([
                'google' => 'Login dengan Google gagal. Silakan coba lagi.'
            ]);
        }
    }
}
