@extends('layouts.finance')

@section('title', 'Review Booking #' . $booking->id)

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex justify-between items-center mb-6 pb-2 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800">Review Booking #{{ $booking->id }}</h2>
            <a href="{{ route('finance.bookings.pending') }}" class="btn btn-gray">
                <i class="fas fa-arrow-left mr-2"></i> Back to Pending
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Booking Details -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-calendar-check text-green-500 mr-2"></i>
                    Booking Details
                </h3>
                <div class="space-y-3">
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Status</span>
                        <span class="font-medium">
                            <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">Pending Approval</span>
                        </span>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Booking Date</span>
                        <span>{{ $booking->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Check-in</span>
                        <span>{{ $booking->check_in->format('M d, Y') }} at {{ $booking->check_in_time }}</span>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Check-out</span>
                        <span>{{ $booking->check_out->format('M d, Y') }} at {{ $booking->check_out_time }}</span>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Duration</span>
                        <span>{{ $booking->nights }} night(s)</span>
                    </div>
                </div>
            </div>

            <!-- Guest Details -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user text-green-500 mr-2"></i>
                    Guest Information
                </h3>
                <div class="space-y-3">
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Name</span>
                        <span>{{ $booking->user->name }}</span>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Email</span>
                        <span>{{ $booking->user->email }}</span>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Phone</span>
                        <span>{{ $booking->user->phone ?? 'Not provided' }}</span>
                    </div>
                </div>
            </div>

            <!-- Room Details -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-bed text-green-500 mr-2"></i>
                    Room Information
                </h3>
                <div class="flex items-start">
                    @if($booking->room->image)
                        <img src="{{ asset('storage/'.$booking->room->image) }}" class="w-24 h-24 object-cover rounded-md mr-4">
                    @endif
                    <div>
                        <h4 class="font-bold">{{ $booking->room->room_type }}</h4>
                        <p>₱{{ number_format($booking->room->price_per_night, 2) }} per night</p>
                        <p class="text-sm text-gray-600">Capacity: {{ $booking->room->capacity }} guests</p>
                    </div>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-money-bill-wave text-green-500 mr-2"></i>
                    Payment Information
                </h3>
                <div class="space-y-3">
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Payment Method</span>
                        <span class="capitalize">{{ $booking->payment_method }}</span>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Payment Status</span>
                        <span class="capitalize">
                            <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">Pending</span>
                        </span>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Total Amount</span>
                        <span class="font-bold text-lg">₱{{ number_format($booking->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approval Form -->
        <div class="bg-white p-6 rounded-lg border border-gray-200 mt-6">
    <h3 class="text-lg font-medium text-gray-800 mb-4">Booking Approval</h3>
    <form action="{{ route('finance.bookings.approve', $booking) }}" method="POST" class="mb-4">
        @csrf
        <div class="flex justify-end space-x-3">
            <button type="submit" class="btn btn-green">
                <i class="fas fa-check mr-2"></i> Approve Booking
            </button>
        </div>
    </form>


            <form action="{{ route('finance.bookings.reject', $booking) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason (Required)</label>
                    <textarea name="rejection_reason" id="rejection_reason" rows="3" class="w-full form-textarea" placeholder="Reason for rejecting this booking..." required></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="submit" class="btn btn-red">
                        <i class="fas fa-times mr-2"></i> Reject Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection