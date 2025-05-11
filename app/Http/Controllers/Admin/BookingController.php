<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminBookingController extends Controller  // Changed class name to avoid conflict
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'admin']);
    }

    public function index()
    {
        $bookings = Booking::with(['user', 'room'])
            ->latest()
            ->paginate(10);
            
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $rooms = Room::where('status', 'available')->get();
        $users = User::where('usertype', 'user')->get();
        return view('admin.bookings.create', compact('rooms', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $room = Room::findOrFail($validated['room_id']);
        $checkIn = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);
        $nights = $checkOut->diffInDays($checkIn);

        $booking = Booking::create([
            'user_id' => $validated['user_id'],
            'room_id' => $validated['room_id'],
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'guests' => $validated['guests'],
            'total_amount' => $room->price_per_night * $nights,
            'status' => $validated['status'],
            'special_requests' => $validated['special_requests']
        ]);

        if ($validated['status'] === 'confirmed') {
            $room->update(['status' => 'occupied']);
        }

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking created successfully!');
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'room']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $rooms = Room::where('status', 'available')
            ->orWhere('id', $booking->room_id)
            ->get();
            
        $users = User::where('usertype', 'user')->get();
        
        return view('admin.bookings.edit', compact('booking', 'rooms', 'users'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'special_requests' => 'nullable|string'
        ]);

        $oldRoom = $booking->room;
        $newRoom = Room::findOrFail($validated['room_id']);

        $checkIn = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);
        $nights = $checkOut->diffInDays($checkIn);

        $booking->update([
            'user_id' => $validated['user_id'],
            'room_id' => $validated['room_id'],
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'guests' => $validated['guests'],
            'total_amount' => $newRoom->price_per_night * $nights,
            'status' => $validated['status'],
            'special_requests' => $validated['special_requests']
        ]);

        // Update room statuses based on booking status
        if ($validated['status'] === 'confirmed') {
            $newRoom->update(['status' => 'occupied']);
            if ($oldRoom->id !== $newRoom->id) {
                $oldRoom->update(['status' => 'available']);
            }
        } elseif (in_array($validated['status'], ['cancelled', 'completed'])) {
            $newRoom->update(['status' => 'available']);
            if ($oldRoom->id !== $newRoom->id) {
                $oldRoom->update(['status' => 'available']);
            }
        }

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking updated successfully!');
    }

    public function destroy(Booking $booking)
    {
        $room = $booking->room;
        $booking->delete();
        
        $room->update(['status' => 'available']);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully!');
    }
}