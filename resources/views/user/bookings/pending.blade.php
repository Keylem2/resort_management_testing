@extends('layouts.user')

@section('title', 'Pending Payment')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b">
            <h2 class="text-2xl font-bold text-gray-800">Payment Pending</h2>
        </div>
        
        <div class="p-6">
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-500 text-2xl mr-3"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-blue-800">Your booking is pending payment</h3>
                        <p class="text-blue-700">Please complete your GCash payment to confirm your reservation.</p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Booking Details</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Room:</span>
                            <span class="font-medium">{{ $booking->room->room_type }} #{{ $booking->room->room_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dates:</span>
                            <span class="font-medium">{{ $booking->check_in->format('M d, Y') }} to {{ $booking->check_out->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nights:</span>
                            <span class="font-medium">{{ $booking->nights }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Guests:</span>
                            <span class="font-medium">{{ $booking->guests }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Details</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Amount:</span>
                            <span class="font-medium">₱{{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Payment Method:</span>
                            <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $booking->payment_method)) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium text-amber-600">Pending Payment</span>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <a href="{{ route('gcash.payment') }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-500 border border-transparent rounded-lg font-semibold text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-money-bill-wave mr-2"></i>
                            Complete GCash Payment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection