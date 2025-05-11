<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        // Get all pending bookings for approval
        $pendingBookings = Booking::where('status', 'pending')->get();

        return view('finance.dashboard', compact('pendingBookings'));
    }

    public function approve(Booking $booking)
    {
        // Approve booking
        $booking->update(['status' => 'confirmed']);

        // Deduct inventory based on the booking's amenities
        $booking->deductInventory();

        return redirect()->route('finance.dashboard')->with('success', 'Booking approved and inventory updated.');
    }
}
