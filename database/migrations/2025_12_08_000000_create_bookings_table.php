<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key ke tabel users
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Kolom-kolom Booking
            $table->string('name')->nullable(); // Ditambahkan dari user update
            $table->string('phone')->nullable(); // Ditambahkan dari user update
            $table->string('store');
            $table->date('date');
            $table->time('time');
            $table->string('gender');
            $table->string('service');
            $table->string('sub_service')->nullable();
            $table->string('barber');
            $table->decimal('price', 8, 0)->default(0); // Total Price
            $table->string('status')->default('Upcoming'); // Status: Upcoming, Completed, Cancelled

            $table->timestamps();

            // Unique Constraint (Mencegah double booking untuk barber dan slot waktu yang sama)
            $table->unique(['date', 'time', 'barber']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};