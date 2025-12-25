<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',        // <-- Diperlukan agar data Nama tersimpan
        'phone',       // <-- Diperlukan agar data No HP tersimpan
        'store',
        'gender',
        'service',
        'sub_service',
        'barber',
        'price',
        'date',
        'time',
        'status',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'time' => 'string',
        'price' => 'integer',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk format tanggal
    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->date)->format('d M Y');
    }

    // Accessor untuk format waktu
    public function getFormattedTimeAttribute()
    {
        return Carbon::parse($this->time)->format('H:i');
    }

    // Accessor untuk format harga
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}