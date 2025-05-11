@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Booking Details</h1>
        <div>
            <a href="{{ route('frontdesk.bookings.edit', $booking) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>
            @if($booking->status == 'confirmed')
                <form action="{{ route('frontdesk.bookings.checkin', $booking) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-2">
                        Check In
                    </button>
                </form>
            @elseif($booking->status == 'checked_in')
                <form action="{{ route('frontdesk.bookings.checkout', $booking) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2">
                        Check Out
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Guest Information -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-semibold mb-4">Guest Information</h2>
            <div class="mb-2">
                <span class="font-semibold">Name:</span> {{ $booking->user->name }}
            </div>
            <div class="mb-2">
                <span class="font-semibold">Email:</span> {{ $booking->user->email }}
            </div>
            <div class="mb-2">
                <span class="font-semibold">Phone:</span> {{ $booking->user->phone ?? 'N/A' }}
            </div>
        </div>

        <!-- Booking Details -->
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-semibold mb-4">Booking Details</h2>
            <div class="mb-2">
                <span class="font-semibold">Room:</span> {{ $booking->room->room_type }} (#{{ $booking->room->room_number }})
            </div>
            <div class="mb-2">
                <span class="font-semibold">Check In:</span> {{ $booking->check_in->format('M d, Y') }}
                @if($booking->check_in_time)
                    at {{ $booking->check_in_time->format('h:i A') }}
                @endif
            </div>
            <div class="mb-2">
                <span class="font-semibold">Check Out:</span> {{ $booking->check_out->format('M d, Y') }}
                @if($booking->check_out_time)
                    at {{ $booking->check_out_time->format('h:i A') }}
                @endif
            </div>
            <div class="mb-2">
                <span class="font-semibold">Nights:</span> {{ $booking->nights }}
            </div>
            <div class="mb-2">
                <span class="font-semibold">Guests:</span> {{ $booking->guests }}
            </div>
            <div class="mb-2">
                <span class="font-semibold">Status:</span> {{ ucfirst($booking->status) }}
            </div>
            <div class="mb-2">
                <span class="font-semibold">Payment Status:</span> {{ ucfirst($booking->payment_status) }}
            </div>
            <div class="mb-2">
                <span class="font-semibold">Payment Method:</span> {{ ucfirst(str_replace('_', ' ', $booking->payment_method)) }}
            </div>
            <div class="mt-4 pt-4 border-t">
                <span class="font-semibold text-lg">Total Amount:</span> 
                <span class="text-xl">₱{{ number_format($booking->total_amount, 2) }}</span>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('frontdesk.bookings.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back to List
        </a>
    </div>
</div>
@endsection