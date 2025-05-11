@extends('layouts.admin')

@section('title', 'Booking Details')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Booking #{{ $booking->id }}</h2>
                <p class="text-gray-600">Created on {{ $booking->created_at->format('M d, Y h:i A') }}</p>
            </div>
            <div class="flex space-x-2">
                <span class="px-3 py-1 rounded-full text-sm font-medium 
                    {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                       ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                       ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                    {{ ucfirst($booking->status) }}
                </span>
                <span class="px-3 py-1 rounded-full text-sm font-medium 
                    {{ $booking->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 
                       ($booking->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                       ($booking->payment_status === 'refunded' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                    {{ ucfirst($booking->payment_status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Guest Information -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user-circle text-amber-500 mr-2"></i>
                    Guest Information
                </h3>
                <div class="space-y-2">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="font-medium">{{ $booking->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium">{{ $booking->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Phone</p>
                        <p class="font-medium">{{ $booking->user->phone ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Booking Details -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                    Booking Details
                </h3>
                <div class="space-y-2">
                    <div>
                        <p class="text-sm text-gray-500">Check-in</p>
                        <p class="font-medium">{{ $booking->check_in->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Check-out</p>
                        <p class="font-medium">{{ $booking->check_out->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Duration</p>
                        <p class="font-medium">{{ $booking->check_in->diffInDays($booking->check_out) }} nights</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Guests</p>
                        <p class="font-medium">{{ $booking->guests }}</p>
                    </div>
                </div>
            </div>

            <!-- Room Information -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-bed text-purple-500 mr-2"></i>
                    Room Information
                </h3>
                <div class="flex items-start">
                    @if($booking->room->image)
                        <img src="{{ asset('storage/'.$booking->room->image) }}" class="w-16 h-16 object-cover rounded-md mr-3">
                    @endif
                    <div>
                        <p class="font-medium">{{ $booking->room->room_type }}</p>
                        <p class="text-sm text-gray-600">₱{{ number_format($booking->room->price_per_night, 2) }} per night</p>
                        <p class="text-xs text-gray-500">Capacity: {{ $booking->room->capacity }} guests</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
            <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                <i class="fas fa-peso-sign text-green-500 mr-2"></i>
                Payment Information
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Payment Summary -->
                <div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span>Room Rate ({{ $booking->check_in->diffInDays($booking->check_out) }} nights):</span>
                            <span>₱{{ number_format($booking->room->price_per_night * $booking->check_in->diffInDays($booking->check_out), 2) }}</span>
                        </div>
                        @if($booking->guests > $booking->room->capacity)
                        <div class="flex justify-between">
                            <span>Additional Guests ({{ $booking->guests - $booking->room->capacity }} × ₱180):</span>
                            <span>₱{{ number_format(($booking->guests - $booking->room->capacity) * 180, 2) }}</span>
                        </div>
                        @endif
                        <div class="border-t pt-2 font-bold flex justify-between">
                            <span>Total Amount:</span>
                            <span>₱{{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Payment Method:</span>
                            <span class="font-medium">{{ strtoupper($booking->payment_method) }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Details -->
                <div>
                    <h4 class="font-medium text-gray-800 mb-2">Payment Records</h4>
                    @forelse($booking->payments as $payment)
                    <div class="border rounded-lg p-3 mb-2">
                        <div class="flex justify-between">
                            <span class="font-medium">Payment #{{ $loop->iteration }}</span>
                            <span class="text-sm {{ $payment->status === 'completed' ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-600 mt-1">
                            <div>Amount: ₱{{ number_format($payment->amount, 2) }}</div>
                            <div>Method: {{ strtoupper($payment->payment_method) }}</div>
                            @if($payment->reference_number)
                            <div>Reference: {{ $payment->reference_number }}</div>
                            @endif
                            @if($payment->receipt_path)
                            <div class="mt-1">
                                <a href="{{ $payment->receipt_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                                    <i class="fas fa-receipt mr-1"></i> View Receipt
                                </a>
                            </div>
                            @endif
                            @if($payment->notes)
                            <div class="mt-1 text-xs text-gray-500">Note: {{ $payment->notes }}</div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-gray-500 text-sm">No payment records found</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-gray">
                <i class="fas fa-arrow-left mr-2"></i> Back to List
            </a>
            <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-blue">
                <i class="fas fa-edit mr-2"></i> Edit Booking
            </a>
        </div>
    </div>
</div>
@endsection