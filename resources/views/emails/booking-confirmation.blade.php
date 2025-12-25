@component('mail::message')
# Booking Confirmation

Hi {{ $booking->name ?? 'Customer' }},

Terima kasih, booking Anda telah berhasil. Berikut detailnya:

- **Store:** {{ $booking->store ?? '-' }}
- **Gender:** {{ $booking->gender ?? '-' }}
- **Service:** {{ $booking->service ?? '-' }}
- **Barber:** {{ $booking->barber ?? '-' }}
- **Date:** {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
- **Time:** {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent