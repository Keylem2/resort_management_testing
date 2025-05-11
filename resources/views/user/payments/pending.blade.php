@extends('layouts.user')

@section('title', 'Pending Payments')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Pending Payments</h1>

        @forelse($pendingBookings as $booking)
            <div class="mb-4 border-b pb-4">
                <p class="text-gray-700 mb-2">Booking ID: <strong>#{{ $booking->id }}</strong></p>
                <p class="text-gray-700 mb-2">Room: <strong>{{ $booking->room->room_type }} (Room #{{ $booking->room->room_number }})</strong></p>
                <p class="text-gray-700 mb-2">Check-in: <strong>{{ $booking->check_in->format('F d, Y') }}</strong></p>
                <p class="text-gray-700 mb-2">Check-out: <strong>{{ $booking->check_out->format('F d, Y') }}</strong></p>
                <p class="text-gray-700 mb-2">Total Amount: <strong>₱{{ number_format($booking->total_amount, 2) }}</strong></p>
                <p class="text-gray-700 mb-4">Deposit Amount: <strong>₱{{ number_format($booking->deposit_amount, 2) }}</strong></p>

                <form method="GET" action="{{ route('gcash.payment', ['booking_id' => $booking->id]) }}">
                    @csrf
                    <button type="submit" class="inline-block bg-amber-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-amber-700 transition">
                        Proceed to GCash Payment
                    </button>
                </form>
            </div>
        @empty
            <p class="text-gray-600">No pending payments found.</p>
        @endforelse
    </div>
</div>
@endsection
