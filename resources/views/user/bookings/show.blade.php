@extends('layouts.user')

@section('title', 'Booking Details')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800">Booking Details</h2>
            <div>
                @php
                    $statusClasses = [
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'confirmed' => 'bg-green-100 text-green-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                        'completed' => 'bg-blue-100 text-blue-800',
                    ];
                @endphp
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusClasses[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($booking->status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Booking Information -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-calendar-check text-amber-500 mr-2"></i>
                    Booking Information
                </h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Booking Reference</p>
                        <p class="font-medium">#{{ $booking->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Booking Date</p>
                        <p class="font-medium">{{ $booking->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Check-in Date</p>
                        <p class="font-medium">{{ $booking->check_in->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Check-out Date</p>
                        <p class="font-medium">{{ $booking->check_out->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Duration</p>
                        <p class="font-medium">{{ $booking->check_out->diffInDays($booking->check_in) }} nights</p>
                    </div>
                </div>
            </div>

            <!-- Room Information -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-bed text-blue-500 mr-2"></i>
                    Room Information
                </h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Room Type</p>
                        <p class="font-medium">{{ $booking->room->room_type }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Room Number</p>
                        <p class="font-medium">#{{ $booking->room->room_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Price Per Night</p>
                        <p class="font-medium">₱{{ number_format($booking->room->price_per_night, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Amount</p>
                        <p class="font-medium">₱{{ number_format($booking->total_amount, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Guest Information -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user-circle text-green-500 mr-2"></i>
                    Guest Information
                </h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="font-medium">{{ $booking->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium">{{ $booking->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Number of Guests</p>
                        <p class="font-medium">{{ $booking->guests }}</p>
                    </div>
                </div>
            </div>

            <!-- Special Requests -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-clipboard-list text-purple-500 mr-2"></i>
                    Special Requests
                </h3>
                <div>
                    @if($booking->special_requests)
                        <p class="font-medium">{{ $booking->special_requests }}</p>
                    @else
                        <p class="text-gray-500">No special requests</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('booking.index') }}" class="btn btn-gray">
                <i class="fas fa-arrow-left mr-2"></i> Back to Bookings
            </a>
            @if($booking->status == 'pending' && $booking->check_in > now()->addDays(1))
                <a href="{{ route('booking.edit', $booking) }}" class="btn btn-blue">
                    <i class="fas fa-edit mr-2"></i> Edit Booking
                </a>
            @endif
        </div>
    </div>
</div>
@endsection