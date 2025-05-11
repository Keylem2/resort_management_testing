@extends('layouts.user')

@section('content')

@if(!isset($booking) || !$booking)
    <div class="alert alert-danger">
        Booking information not available. Please create a new booking.
    </div>
    @php return; @endphp
@endif

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">GCash Payment</h1>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <p class="text-lg mb-2">Amount to pay: <strong>₱{{ number_format($booking->deposit_amount, 2) }}</strong></p>

        <!-- Simulated GCash payment form -->
        <form id="gcashForm" method="POST" action="{{ route('gcash.payment', ['booking_id' => $booking->id]) }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">GCash Mobile Number</label>
                <input type="text" name="gcash_number" class="w-full p-2 border rounded" placeholder="09XXXXXXXXX" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">GCash Name</label>
                <input type="text" name="gcash_name" class="w-full p-2 border rounded" placeholder="Juan Dela Cruz" required>
            </div>
            
            <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
                Confirm Payment
            </button>
        </form>
    </div>
</div>

@endsection
