<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Details') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Booking #{{ $booking->id }}</h3>
                            <p class="text-gray-600">Created on {{ $booking->created_at->format('M j, Y') }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold 
                            @if($booking->status == 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($booking->status == 'cancelled') bg-red-100 text-red-800
                            @elseif($booking->status == 'completed') bg-blue-100 text-blue-800
                            @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Room Information -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-medium text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-bed text-blue-500 mr-2"></i>
                                Room Information
                            </h4>
                            <div class="flex items-center mb-3">
                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                                    <i class="fas fa-door-open"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium">{{ $booking->room->room_type }}</p>
                                    <p class="text-sm text-gray-600">Room #{{ $booking->room->room_number }}</p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm">
                                    <span class="text-gray-600">Rate:</span>
                                    <span class="font-medium">₱{{ number_format($booking->room->price_per_night, 2) }} per night</span>
                                </p>
                                <p class="text-sm">
                                    <span class="text-gray-600">Capacity:</span>
                                    <span class="font-medium">{{ $booking->room->capacity }} guests</span>
                                </p>
                            </div>
                        </div>

                        <!-- Booking Dates -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-medium text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-calendar-alt text-amber-500 mr-2"></i>
                                Booking Dates
                            </h4>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-600">Check-in</p>
                                    <p class="font-medium">{{ $booking->check_in->format('l, F j, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Check-out</p>
                                    <p class="font-medium">{{ $booking->check_out->format('l, F j, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Duration</p>
                                    <p class="font-medium">{{ $booking->check_out->diffInDays($booking->check_in) }} nights</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="border border-gray-200 rounded-lg p-4 mb-6">
                        <h4 class="font-medium text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-receipt text-green-500 mr-2"></i>
                            Payment Summary
                        </h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Room Rate ({{ $booking->check_out->diffInDays($booking->check_in) }} nights)</span>
                                <span>₱{{ number_format($booking->room->price_per_night * $booking->check_out->diffInDays($booking->check_in), 2) }}</span>
                            </div>
                            <div class="border-t pt-2 flex justify-between font-medium">
                                <span>Total Amount</span>
                                <span>₱{{ number_format($booking->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Special Requests -->
                    @if($booking->special_requests)
                    <div class="border border-gray-200 rounded-lg p-4 mb-6">
                        <h4 class="font-medium text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-clipboard-list text-amber-500 mr-2"></i>
                            Special Requests
                        </h4>
                        <p class="text-gray-700 whitespace-pre-line">{{ $booking->special_requests }}</p>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row justify-end gap-3">
                        @if($booking->status == 'pending' || $booking->status == 'confirmed')
                            @if($booking->status == 'pending' && $booking->check_in > now())
                            <form method="POST" action="{{ route('booking.destroy', $booking) }}">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" class="bg-red-600 hover:bg-red-700">
                                    {{ __('Cancel Booking') }}
                                </x-button>
                            </form>
                            @endif
                            
                            @if($booking->status == 'pending' && $booking->check_in > now()->addDays(1))
                            <a href="{{ route('booking.edit', $booking) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                                {{ __('Modify Booking') }}
                            </a>
                            @endif
                        @endif
                        
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            {{ __('Back to Dashboard') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>