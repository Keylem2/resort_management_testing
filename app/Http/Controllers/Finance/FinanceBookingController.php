<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class FinanceBookingController extends Controller
{
    public function pending()
    {
        $bookings = Booking::with(['user', 'room'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('finance.bookings.pending', compact('bookings'));
    }

    public function review(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return redirect()->route('finance.bookings.pending')
                ->with('error', 'This booking is not pending approval.');
        }

        return view('finance.bookings.review', compact('booking'));
    }

    public function approve(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $booking->update([
            'status' => 'confirmed',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('finance.bookings.pending')
            ->with('success', 'Booking approved successfully!');
    }

    public function reject(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $booking->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'rejected_by' => auth()->id(),
            'rejected_at' => now(),
        ]);

        // Free up the room
        $booking->room()->update(['status' => 'available']);

        return redirect()->route('finance.bookings.pending')
            ->with('success', 'Booking rejected successfully!');
    }
}