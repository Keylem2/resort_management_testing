@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Edit Booking</h1>

    <form action="{{ route('frontdesk.bookings.update', $booking) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Guest Information -->
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-xl font-semibold mb-4">Guest Information</h2>
                <div class="mb-4">
                    <label class="block text-gray-700">Name</label>
                    <p class="p-2 bg-gray-100 rounded">{{ $booking->user->name }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <p class="p-2 bg-gray-100 rounded">{{ $booking->user->email }}</p>
                </div>
            </div>

            <!-- Booking Details -->
            <div class="bg-white p-6 rounded shadow">
                <h2 class="text-xl font-semibold mb-4">Booking Details</h2>
                <div class="mb-4">
                    <label for="room_id" class="block text-gray-700">Room</label>
                    <select name="room_id" id="room_id" class="w-full border rounded p-2" required>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" 
                                {{ $booking->room_id == $room->id ? 'selected' : '' }}
                                data-price="{{ $room->price_per_night }}">
                                {{ $room->room_type }} (#{{ $room->room_number }}) - ₱{{ number_format($room->price_per_night, 2) }}/night
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="check_in" class="block text-gray-700">Check In</label>
                        <input type="date" name="check_in" id="check_in" 
                            value="{{ $booking->check_in->format('Y-m-d') }}" 
                            class="w-full border rounded p-2" required>
                    </div>
                    <div>
                        <label for="check_out" class="block text-gray-700">Check Out</label>
                        <input type="date" name="check_out" id="check_out" 
                            value="{{ $booking->check_out->format('Y-m-d') }}" 
                            class="w-full border rounded p-2" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="guests" class="block text-gray-700">Number of Guests</label>
                    <input type="number" name="guests" id="guests" min="1" max="10" 
                        value="{{ $booking->guests }}" 
                        class="w-full border rounded p-2" required>
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-gray-700">Status</label>
                    <select name="status" id="status" class="w-full border rounded p-2" required>
                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="checked_in" {{ $booking->status == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                        <option value="checked_out" {{ $booking->status == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="payment_status" class="block text-gray-700">Payment Status</label>
                    <select name="payment_status" id="payment_status" class="w-full border rounded p-2" required>
                        <option value="pending" {{ $booking->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $booking->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="partially_paid" {{ $booking->payment_status == 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                        <option value="refunded" {{ $booking->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Update Booking
            </button>
            <a href="{{ route('frontdesk.bookings.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection