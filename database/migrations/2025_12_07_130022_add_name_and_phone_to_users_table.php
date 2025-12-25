<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kolom 'name' dihapus karena sudah ada secara default di tabel 'users'
            // $table->string('name')->nullable(); 
            
            // Hanya tambahkan kolom 'phone' yang diperlukan
            $table->string('phone')->nullable()->after('email'); // Kolom no hp, diletakkan setelah 'email'
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Karena kita hanya menambahkan 'phone' di up(), kita hanya menghapus 'phone' di down()
            $table->dropColumn('phone'); 
        });
    }
};