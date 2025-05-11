<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AdminBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'admin']);
    }

    public function index()
    {
        $bookings = Booking::with(['user', 'room', 'payments'])
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
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'check_in_time' => 'required',
            'check_out_time' => 'required',
            'guests' => 'required|integer|min:1',
            'nights' => 'required|integer|min:1',
            'total_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:gcash,cash',
            'gcash_receipt' => 'required_if:payment_method,gcash|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', ['errors' => $validator->errors()->all()]);
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check room availability
        $checkIn = Carbon::parse($request->check_in . ' ' . $request->check_in_time);
        $checkOut = Carbon::parse($request->check_out . ' ' . $request->check_out_time);

        $existingBooking = Booking::where('room_id', $request->room_id)
            ->where(function($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                      ->orWhereBetween('check_out', [$checkIn, $checkOut])
                      ->orWhere(function($q) use ($checkIn, $checkOut) {
                          $q->where('check_in', '<', $checkIn)
                            ->where('check_out', '>', $checkOut);
                      });
            })
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($existingBooking) {
            return back()->withErrors([
                'room_id' => 'The selected room is not available for the chosen dates'
            ])->withInput();
        }

        try {
            DB::beginTransaction();

            $room = Room::findOrFail($request->room_id);
            $booking = Booking::create([
                'user_id' => $request->user_id,
                'room_id' => $request->room_id,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'check_in_time' => $request->check_in_time,
                'check_out_time' => $request->check_out_time,
                'nights' => $request->nights,
                'guests' => $request->guests,
                'total_amount' => $request->total_amount,
                'status' => 'confirmed',
                'payment_status' => $request->payment_method === 'cash' ? 'pending' : 'paid',
                'payment_method' => $request->payment_method
            ]);

            $receiptPath = null;
            if ($request->hasFile('gcash_receipt')) {
                $receiptPath = $request->file('gcash_receipt')->store('payment-receipts', 'public');
            }

            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $request->total_amount,
                'payment_method' => $request->payment_method,
                'reference_number' => $request->payment_method === 'gcash' 
                    ? 'GCASH-'.strtoupper(uniqid()) 
                    : 'CASH-'.strtoupper(uniqid()),
                'receipt_path' => $receiptPath,
                'status' => $request->payment_method === 'gcash' ? 'completed' : 'pending',
                'notes' => 'Full payment'
            ]);

            // Deduct inventory
            $booking->deductInventory();

            // Update room status
            $room->update(['status' => 'occupied']);

            DB::commit();

            return redirect()->route('admin.bookings.show', $booking)
                ->with('success', 'Booking created successfully! Inventory updated.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Booking creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'Error creating booking: '.$e->getMessage())
                ->withInput();
        }
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'room', 'payments']);
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
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'check_in_time' => 'required',
            'check_out_time' => 'required',
            'guests' => 'required|integer|min:1',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'payment_status' => 'required|in:pending,paid,refunded,failed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        $oldRoom = $booking->room;
        $newRoom = Room::findOrFail($validated['room_id']);

        try {
            DB::beginTransaction();

            // Calculate nights
            $checkIn = Carbon::parse($validated['check_in'] . ' ' . $validated['check_in_time']);
            $checkOut = Carbon::parse($validated['check_out'] . ' ' . $validated['check_out_time']);
            $nights = $checkIn->diffInDays($checkOut);

            $booking->update([
                'user_id' => $validated['user_id'],
                'room_id' => $validated['room_id'],
                'check_in' => $validated['check_in'],
                'check_out' => $validated['check_out'],
                'check_in_time' => $validated['check_in_time'],
                'check_out_time' => $validated['check_out_time'],
                'nights' => $nights,
                'guests' => $validated['guests'],
                'status' => $validated['status'],
                'payment_status' => $validated['payment_status']
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

            DB::commit();

            return redirect()->route('admin.bookings.index')
                ->with('success', 'Booking updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating booking: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Booking $booking)
    {
        try {
            DB::beginTransaction();

            $room = $booking->room;
            $booking->payments()->delete();
            $booking->delete();
            
            $room->update(['status' => 'available']);

            DB::commit();

            return redirect()->route('admin.bookings.index')
                ->with('success', 'Booking deleted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error deleting booking: ' . $e->getMessage());
        }
    }
}