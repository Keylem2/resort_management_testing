<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function paymentPage(Request $request)
    {
        // Get booking ID from session
        $bookingId = session('booking_id');
        
        // Check if booking ID exists in session
        if (!$bookingId) {
            return redirect()->route('booking.create')->with('error', 'Please create a booking first');
        }

        // Find the booking
        $booking = Booking::find($bookingId);
        
        // Check if booking exists in database
        if (!$booking || $booking->user_id !== auth()->id()) {
            session()->forget('booking_id'); // Clean up invalid session data
            return redirect()->route('booking.create')->with('error', 'Booking not found. Please create a new booking.');
        }

        return view('user.payments.gcash', [
            'amount' => $booking->total_amount,
            'booking' => $booking
        ]);
    }
}

