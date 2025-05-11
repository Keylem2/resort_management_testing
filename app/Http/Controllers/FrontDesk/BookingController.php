<?php

namespace App\Http\Controllers\FrontDesk;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index(Request $request)
{
    $status = $request->query('status');
    
    $bookings = Booking::with(['user', 'room'])
        ->when($status, function ($query) use ($status) {
            return $query->where('status', $status);
        })
        ->orderBy('check_in', 'desc')
        ->paginate(10);

    return view('frontdesk.bookings.index', compact('bookings'));
}

public function create()
{
    // Fetch available rooms
    $rooms = Room::where('status', 'available')->get();
    
    // Fetch all users who are customers (those with 'user' role)
    $users = User::where('usertype', 'user')->get();

    return view('frontdesk.bookings.create', compact('rooms', 'users'));
}

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        // Validation rules
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $room = Room::findOrFail($request->room_id);
    $checkIn = Carbon::parse($request->check_in);
    $checkOut = Carbon::parse($request->check_out);
    $nights = $checkIn->diffInDays($checkOut);
    $totalAmount = $nights * $room->price_per_night;

    // Create or find user (customer)
    $user = User::firstOrCreate(
        ['email' => $request->guest_email],
        ['name' => $request->guest_name, 'password' => bcrypt(Str::random(10)), 'usertype' => 'user']
    );

    $booking = Booking::create([
        'user_id' => $user->id,
        'room_id' => $request->room_id,
        'check_in' => $checkIn,
        'check_out' => $checkOut,
        'nights' => $nights,
        'guests' => $request->guests,
        'total_amount' => $totalAmount,
        'status' => 'pending', // Set to pending for approval
        'payment_status' => 'pending',
        'payment_method' => $request->payment_method,
    ]);

    // Update room status
    $room->update(['status' => 'booked']);

    return redirect()->route('frontdesk.bookings.show', $booking)->with('success', 'Booking created successfully, awaiting approval.');
}

    public function show(Booking $booking)
    {
        return view('frontdesk.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $rooms = Room::where('status', 'available')
            ->orWhere('id', $booking->room_id)
            ->get();
            
        return view('frontdesk.bookings.edit', compact('booking', 'rooms'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'status' => 'required|in:pending,confirmed,cancelled,checked_in,checked_out',
            'payment_status' => 'required|in:pending,paid,partially_paid,refunded',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $room = Room::findOrFail($request->room_id);
        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $nights = $checkIn->diffInDays($checkOut);
        $totalAmount = $nights * $room->price_per_night;

        // If room changed, update old room status
        if ($booking->room_id != $request->room_id) {
            Room::where('id', $booking->room_id)->update(['status' => 'available']);
            $room->update(['status' => 'booked']);
        }

        $booking->update([
            'room_id' => $request->room_id,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'nights' => $nights,
            'guests' => $request->guests,
            'total_amount' => $totalAmount,
            'status' => $request->status,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->route('frontdesk.bookings.show', $booking)
            ->with('success', 'Booking updated successfully!');
    }

    public function destroy(Booking $booking)
    {
        // Update room status back to available
        Room::where('id', $booking->room_id)->update(['status' => 'available']);
        
        $booking->delete();
        
        return redirect()->route('frontdesk.bookings.index')
            ->with('success', 'Booking deleted successfully!');
    }

    public function checkIn(Booking $booking)
    {
        $booking->update([
            'status' => 'checked_in',
            'check_in_time' => now(),
        ]);
        
        Room::where('id', $booking->room_id)->update(['status' => 'occupied']);
        
        return redirect()->back()->with('success', 'Guest checked in successfully!');
    }

    public function checkOut(Booking $booking)
    {
        $booking->update([
            'status' => 'checked_out',
            'check_out_time' => now(),
        ]);
        
        Room::where('id', $booking->room_id)->update(['status' => 'available']);
        
        return redirect()->back()->with('success', 'Guest checked out successfully!');
    }
}