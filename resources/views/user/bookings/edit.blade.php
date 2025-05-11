@extends('layouts.user')

@section('title', 'Edit Booking')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-100">Edit Booking</h2>

        <form action="{{ route('booking.update', $booking) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Room Selection Card -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-bed text-blue-500 mr-2"></i>
                        Room Information
                    </h3>
                    <div>
                        <label for="room_id" class="block text-sm font-medium text-gray-700 mb-2">Select Room</label>
                        <select name="room_id" id="room_id" class="w-full form-select" required>
                            <option value="">Select Room</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" data-price="{{ $room->price_per_night }}" {{ old('room_id', $booking->room_id) == $room->id ? 'selected' : '' }}>
                                    {{ $room->room_type }} (#{{ $room->room_number }}) - ₱{{ number_format($room->price_per_night, 2) }}/night
                                </option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Booking Dates Card -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-calendar-alt text-amber-500 mr-2"></i>
                        Booking Dates
                    </h3>
                    <div class="space-y-4">
                        <!-- Check-in Date -->
                        <div>
                            <label for="check_in" class="block text-sm font-medium text-gray-700 mb-2">Check-in Date</label>
                            <input type="date" name="check_in" id="check_in" class="w-full form-input" value="{{ old('check_in', $booking->check_in->format('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                            @error('check_in')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Check-out Date -->
                        <div>
                            <label for="check_out" class="block text-sm font-medium text-gray-700 mb-2">Check-out Date</label>
                            <input type="date" name="check_out" id="check_out" class="w-full form-input" value="{{ old('check_out', $booking->check_out->format('Y-m-d')) }}" required>
                            @error('check_out')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Guest Details Card -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-users text-blue-500 mr-2"></i>
                        Guest Details
                    </h3>
                    <div>
                        <label for="guests" class="block text-sm font-medium text-gray-700 mb-2">Number of Guests</label>
                        <input type="number" name="guests" id="guests" class="w-full form-input" value="{{ old('guests', $booking->guests) }}" min="1" required>
                        @error('guests')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Payment Card -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-peso-sign text-green-500 mr-2"></i>
                        Payment Information
                    </h3>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Amount</label>
                        <div class="w-full p-2 bg-white border border-gray-300 rounded-md text-gray-800 font-medium" id="total_amount_display">₱{{ number_format($booking->total_amount, 2) }}</div>
                        <input type="hidden" name="total_amount" id="total_amount" value="{{ $booking->total_amount }}">
                    </div>
                </div>

                <!-- Special Requests Card -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-clipboard-list text-amber-500 mr-2"></i>
                        Special Requests
                    </h3>
                    <textarea name="special_requests" id="special_requests" class="w-full form-textarea" rows="3" placeholder="Any special requests or notes...">{{ old('special_requests', $booking->special_requests) }}</textarea>
                    @error('special_requests')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-actions flex justify-end space-x-3 mt-6">
                <a href="{{ route('booking.show', $booking) }}" class="btn btn-gray">
                    <i class="fas fa-times mr-2"></i> Cancel
                </a>
                <button type="submit" class="btn btn-amber">
                    <i class="fas fa-save mr-2"></i> Update Booking
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roomSelect = document.getElementById('room_id');
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');
        const totalAmountDisplay = document.getElementById('total_amount_display');
        const totalAmountInput = document.getElementById('total_amount');

        // Set minimum check-out date based on check-in date
        checkInInput.addEventListener('change', function() {
            if (this.value) {
                checkOutInput.min = this.value;
                if (checkOutInput.value && new Date(checkOutInput.value) < new Date(this.value)) {
                    checkOutInput.value = '';
                }
            }
            calculateTotal();
        });

        function calculateTotal() {
            const roomOption = roomSelect.options[roomSelect.selectedIndex];
            const pricePerNight = roomOption ? parseFloat(roomOption.dataset.price) : 0;
            
            const checkIn = new Date(checkInInput.value);
            const checkOut = new Date(checkOutInput.value);
            
            if (checkIn && checkOut && checkOut > checkIn) {
                const nights = (checkOut - checkIn) / (1000 * 60 * 60 * 24);
                const total = pricePerNight * nights;
                
                totalAmountDisplay.textContent = '₱' + total.toFixed(2);
                totalAmountInput.value = total.toFixed(2);
            } else {
                totalAmountDisplay.textContent = '₱0.00';
                totalAmountInput.value = '0';
            }
        }

        roomSelect.addEventListener('change', calculateTotal);
        checkInInput.addEventListener('change', calculateTotal);
        checkOutInput.addEventListener('change', calculateTotal);
    });
</script>
@endsection