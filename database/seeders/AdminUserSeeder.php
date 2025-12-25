<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        if (!User::where('email', 'admin@bosque.com')->exists()) {
            User::create([
                'name' => 'Administrator',
                'email' => 'bosquebarbershop1@gmail.com',
                'password' => Hash::make('barbershop_bosque1'), // password default
                'role' => 'admin', // pastikan kolom role ada di tabel users
            ]);
        }
    }
}
