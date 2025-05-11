<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Booking') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('booking.update', $booking) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Room Selection -->
                            <div class="md:col-span-2">
                                <x-label for="room_id" :value="__('Room Type')" />
                                <select id="room_id" name="room_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                                    @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" 
                                        data-price="{{ $room->price_per_night }}"
                                        {{ $booking->room_id == $room->id ? 'selected' : '' }}>
                                        {{ $room->room_type }} (₱{{ number_format($room->price_per_night, 2) }}/night)
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Number of Guests -->
                            <div>
                                <x-label for="guests" :value="__('Number of Guests')" />
                                <x-input id="guests" class="block mt-1 w-full" type="number" name="guests" 
                                    :value="old('guests', $booking->guests)" min="1" required />
                            </div>

                            <!-- Total Amount (calculated) -->
                            <div>
                                <x-label :value="__('Estimated Total')" />
                                <div id="total-display" class="block mt-1 w-full p-2 bg-gray-50 border border-gray-300 rounded-md">
                                    ₱{{ number_format($booking->total_amount, 2) }}
                                </div>
                                <input type="hidden" id="total-amount" name="total_amount" value="{{ $booking->total_amount }}">
                            </div>

                            <!-- Check-in Date -->
                            <div>
                                <x-label for="check_in" :value="__('Check-in Date')" />
                                <x-input id="check_in" class="block mt-1 w-full" type="date" name="check_in" 
                                    :value="old('check_in', $booking->check_in->format('Y-m-d'))" 
                                    min="{{ date('Y-m-d') }}" required />
                            </div>

                            <!-- Check-out Date -->
                            <div>
                                <x-label for="check_out" :value="__('Check-out Date')" />
                                <x-input id="check_out" class="block mt-1 w-full" type="date" name="check_out" 
                                    :value="old('check_out', $booking->check_out->format('Y-m-d'))" 
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}" required />
                            </div>

                            <!-- Special Requests -->
                            <div class="md:col-span-2">
                                <x-label for="special_requests" :value="__('Special Requests')" />
                                <textarea id="special_requests" name="special_requests" rows="3" 
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('special_requests', $booking->special_requests) }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-4">
                            <a href="{{ route('booking.show', $booking) }}" class="text-gray-600 hover:text-gray-900">
                                {{ __('Cancel') }}
                            </a>
                            <x-button class="ml-4 bg-amber-600 hover:bg-amber-700">
                                {{ __('Update Booking') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roomSelect = document.getElementById('room_id');
            const checkInInput = document.getElementById('check_in');
            const checkOutInput = document.getElementById('check_out');
            const totalDisplay = document.getElementById('total-display');
            const totalInput = document.getElementById('total-amount');

            // Calculate total when any field changes
            function calculateTotal() {
                const roomOption = roomSelect.options[roomSelect.selectedIndex];
                const pricePerNight = roomOption ? parseFloat(roomOption.dataset.price) : 0;
                
                const checkIn = new Date(checkInInput.value);
                const checkOut = new Date(checkOutInput.value);
                
                if (checkIn && checkOut && checkOut > checkIn) {
                    const nights = (checkOut - checkIn) / (1000 * 60 * 60 * 24);
                    const total = pricePerNight * nights;
                    
                    totalDisplay.textContent = '₱' + total.toFixed(2);
                    totalInput.value = total.toFixed(2);
                } else {
                    totalDisplay.textContent = '₱0.00';
                    totalInput.value = '0';
                }
            }

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

            roomSelect.addEventListener('change', calculateTotal);
            checkInInput.addEventListener('change', calculateTotal);
            checkOutInput.addEventListener('change', calculateTotal);
        });
    </script>
</x-app-layout>