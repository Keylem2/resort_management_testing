<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('room')
            ->where('user_id', Auth::id())
            ->orderBy('check_in', 'desc')
            ->paginate(10);

        return view('user.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $room = null;
        if (request()->has('room_id')) {
            $room = Room::find(request('room_id'));
        }

        // Generate form token to prevent duplicate submissions
        $formToken = Str::random(32);
        session(['form_token' => $formToken]);

        $rooms = Room::where('status', 'available')->get();
        // $bookingss = Booking::all();
        // dd($checkInDate);
        return view('user.bookings.create', compact('rooms', 'room', 'formToken'));
    }

    public function store(Request $request)
    {
        \Log::debug('Booking submission received', $request->all());

        // Form token verification (existing code remains the same)
        if (!session()->has('form_token') || session('form_token') !== $request->input('form_token')) {
            return redirect()->back()->withErrors(['form' => 'Invalid form submission.']);
        }
        // dd($reserved);
        // Validation (existing rules remain the same)
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after:today|unique:'.Booking::class.'',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'payment_method' => 'required|in:gcash_deposit,gcash_full',
            'payment_status' => 'required|in:pending,paid',
            'terms' => 'accepted',
            'total_amount' => 'required|numeric|min:0',
            'deposit_amount' => 'required|numeric|min:0',
            'form_token' => 'required|string'
        ]);

        // Get room details
        $room = Room::find($validated['room_id']);

        // Correct night calculation to match frontend logic
        $checkInDate = Carbon::parse($validated['check_in'])->setTime(14, 0, 0);
        $checkOutDate = Carbon::parse($validated['check_out'])->setTime(12, 0, 0);
        $nights = max(1, ceil($checkInDate->floatDiffInHours($checkOutDate) / 24));

        // Calculate pricing
        $additionalGuests = max(0, $validated['guests'] - $room->capacity);
        $additionalCharges = $additionalGuests * 180;
        $roomTotal = $room->price_per_night * $nights;
        $calculatedTotal = $roomTotal + $additionalCharges;

        // Verify calculated amount matches submitted amount
        if (abs($calculatedTotal - $validated['total_amount']) > 0.01) {
            \Log::error('Price mismatch', [
                'calculated' => $calculatedTotal,
                'submitted' => $validated['total_amount'],
                'nights' => $nights,
                'room_price' => $room->price_per_night
            ]);
            return redirect()->back()->withErrors([
                'total_amount' => 'Price calculation mismatch. Please refresh and try again.'
            ]);
        }

        // Create booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $validated['room_id'],
            'check_in' => $checkInDate,
            'check_out' => $checkOutDate,
            'guests' => $validated['guests'],
            'total_amount' => $calculatedTotal,
            'deposit_amount' => $validated['deposit_amount'],
            'payment_method' => $validated['payment_method'],
            'status' => 'pending_approval',
            'nights' => $nights
        ]);

        // Clear form token
        session()->forget('form_token');

        // Redirect to pending payment page with booking ID
        return redirect()->route('user.payments.pending', $booking->id);
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        if ($booking->user_id !== Auth::id() || $booking->status !== 'pending') {
            abort(403, 'You can only edit pending bookings.');
        }

        $rooms = Room::where('status', 'available')->get();
        return view('user.bookings.edit', compact('booking', 'rooms'));
    }

    public function update(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id() || $booking->status !== 'pending') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'special_requests' => 'nullable|string'
        ]);

        // Get room details for capacity validation
        $room = Room::find($validated['room_id']);
        $maxGuests = $room->capacity + 2;

        if ($validated['guests'] > $maxGuests) {
            return redirect()->back()->withErrors(['guests' => "This room can accommodate maximum {$maxGuests} guests"]);
        }

        $validated['total_amount'] = $this->calculateTotalAmount(
            $validated['room_id'],
            $validated['check_in'],
            $validated['check_out'],
            $validated['guests']
        );

        $booking->update($validated);
        return redirect()->route('user.bookings.index')->with('success', 'Booking updated successfully!');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== Auth::id() || !in_array($booking->status, ['pending', 'pending_approval'])) {
            abort(403, 'You can only cancel pending bookings.');
        }

        $booking->delete();
        return redirect()->route('user.bookings.index')->with('success', 'Booking cancelled successfully!');
    }

    protected function calculateTotalAmount($roomId, $checkIn, $checkOut, $guests)
    {
        $room = Room::findOrFail($roomId);

        // Set check-in at 2:00 PM and check-out at 12:00 PM
        $checkInDate = Carbon::parse($checkIn)->setTime(14, 0, 0);
        $checkOutDate = Carbon::parse($checkOut)->setTime(12, 0, 0);

        // Calculate nights, making sure partial days count as full nights
        $nights = max(1, $checkInDate->diffInDays($checkOutDate) + 1);

        // Calculate room total
        $roomPrice = number_format($room->price_per_night, 2, '.', '');
        $roomTotal = bcmul($roomPrice, (string) $nights, 2);

        // Calculate additional guest charges
        $baseGuests = $room->capacity;
        $additionalGuestRate = 180.00;
        $additionalGuests = max(0, $guests - $baseGuests);
        $additionalCharges = bcmul((string) $additionalGuests, number_format($additionalGuestRate, 2, '.', ''), 2);

        // Final total amount
        $totalAmount = bcadd($roomTotal, $additionalCharges, 2);

        // Debugging log for precise tracking
        \Log::debug('Total amount calculation details (Backend):', [
            'nights' => $nights,
            'room_price' => $roomPrice,
            'additional_guests' => $additionalGuests,
            'additional_charges' => $additionalCharges,
            'room_total' => $roomTotal,
            'final_total' => $totalAmount,
        ]);

        return $totalAmount;
    }

    public function pendingPayment($booking_id = null)
    {
        if ($booking_id) {
            $pendingBookings = Booking::with('room')
                ->where('user_id', Auth::id())
                ->where('id', $booking_id)
                ->where('status', 'pending_approval')
                ->get();
        } else {
            $pendingBookings = Booking::with('room')
                ->where('user_id', Auth::id())
                ->where('status', 'pending_approval')
                ->get();
        }

        return view('user.payments.pending', compact('pendingBookings'));
    }

    public function gcashPayment($booking_id)
    {
        // Find the booking with the given ID
        $booking = Booking::with('room')->find($booking_id);

        // Check if booking exists and belongs to the logged-in user
        if (!$booking || $booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this booking.');
        }

        // Pass the booking to the GCash payment view
        return view('user.payments.gcash', compact('booking'));
    }

    // end

}
