@component('mail::message')
# Booking Confirmation

Hi {{ $booking->user->name }},

Thanks — your booking is confirmed. Details:

- **Store:** {{ $booking->store }}
- **Gender:** {{ $booking->gender }}
- **Service:** {{ $booking->service }}
- **Barber:** {{ $booking->barber }}
- **Date:** {{ $booking->date->format('d M Y') }}
- **Time:** {{ \Carbon\Carbon::parse($booking->time)->format('H:i') }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent