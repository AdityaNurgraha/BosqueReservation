<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue; // <- tambahkan ini
use App\Models\Booking;

class BookingConfirmationMail extends Mailable implements ShouldQueue // <- implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Booking $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('Booking Confirmation - ' . config('app.name'))
            ->markdown('emails.booking-confirmation');
    }
}
