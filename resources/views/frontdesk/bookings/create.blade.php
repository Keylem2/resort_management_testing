@extends('layouts.frontdesk')

@section('title', 'Create Booking')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-100">Create New Booking</h2>

        <form action="{{ route('frontdesk.bookings.store') }}" method="POST" id="bookingForm" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Guest Selection Card -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user-circle text-amber-500 mr-2"></i>
                        Guest Information
                    </h3>
                    <div class="mt-4">
                        <label for="guest_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" name="guest_name" id="guest_name" class="w-full form-input" required>
                    </div>
                    <div class="mt-4">
                        <label for="guest_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="guest_email" id="guest_email" class="w-full form-input" required>
                    </div>
                    <div>
                        <label for="guest_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="text" name="guest_phone" id="guest_phone" class="w-full form-input" required>
                    </div>

                    <div class="mt-4">
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Select Registered Guest (Optional)</label>
                        <select name="user_id" id="user_id" class="w-full form-select">
                            <option value="">Select Registered User (Optional)</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Room Selection Card -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-bed text-blue-500 mr-2"></i>
                        Room Information
                    </h3>
                    <div class="mb-4">
                        <button type="button" onclick="openRoomModal()" class="btn btn-blue">
                            <i class="fas fa-search mr-2"></i> Browse Rooms
                        </button>
                        <input type="hidden" name="room_id" id="selected_room_id" required>
                        <input type="hidden" id="room_capacity" value="2">
                        <input type="hidden" name="nights" id="nights">
                        <div id="selected-room-display" class="mt-3 hidden">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>

                    <!-- Guest Count -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Number of Guests</label>
                        <div class="flex items-center">
                            <button type="button" onclick="adjustGuests(-1)" id="decrement-btn" class="bg-gray-200 px-3 py-1 rounded-l-lg" disabled>
                                -
                            </button>
                            <input type="number" name="guests" id="guests" class="w-16 text-center border-t border-b border-gray-300 py-1" value="2" min="2" readonly>
                            <button type="button" onclick="adjustGuests(1)" id="increment-btn" class="bg-gray-200 px-3 py-1 rounded-r-lg" disabled>
                                +
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Dates Card -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-calendar-alt text-amber-500 mr-2"></i>
                        Booking Dates
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="check_in" class="block text-sm font-medium text-gray-700 mb-2">Check-in Date</label>
                            <input type="date" name="check_in" id="check_in" class="w-full form-input" min="{{ date('Y-m-d') }}" required>
                            <div class="mt-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Check-in Time</label>
                                <select name="check_in_time" class="w-full form-select">
                                    <option value="14:00:00" selected>2:00 PM (Standard Check-in)</option>
                                    <option value="16:00:00">4:00 PM</option>
                                    <option value="18:00:00">6:00 PM</option>
                                    <option value="20:00:00">8:00 PM</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="check_out" class="block text-sm font-medium text-gray-700 mb-2">Check-out Date</label>
                            <input type="date" name="check_out" id="check_out" class="w-full form-input" disabled required>
                            <div class="mt-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Check-out Time</label>
                                <select name="check_out_time" class="w-full form-select" disabled>
                                    <option value="10:00:00">10:00 AM</option>
                                    <option value="12:00:00" selected>12:00 PM (Standard Check-out)</option>
                                    <option value="14:00:00">2:00 PM (Late Check-out)</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Late check-out after 12:00 PM may incur additional charges</p>
                            </div>
                        </div>
                    </div>
                    <p id="check_in_error" class="text-red-500 text-sm hidden">Please select a check-in date first.</p>
                </div>

                <!-- Payment Card -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-peso-sign text-green-500 mr-2"></i>
                        Payment Summary
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span>Room Rate:</span>
                            <span id="room-rate">₱0.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Additional Guests (₱180 each):</span>
                            <span id="guest-charge">₱0.00</span>
                        </div>
                        <div id="late-checkout-row" class="flex justify-between hidden">
                            <span>Late Check-out Charge:</span>
                            <span id="late-checkout-charge">₱0.00</span>
                        </div>
                        <div class="border-t pt-2 font-bold flex justify-between">
                            <span>Total:</span>
                            <span id="total-amount">₱0.00</span>
                        </div>
                        <input type="hidden" name="total_amount" id="total_amount_input">
                    </div>
                </div>

                <!-- Payment Method Card -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-credit-card text-blue-500 mr-2"></i>
                        Payment Method
                    </h3>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="cash" class="form-radio" checked>
                            <span class="ml-2">Cash (At Front Desk)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="gcash" class="form-radio">
                            <span class="ml-2">GCash</span>
                        </label>
                    </div>

                    <!-- GCash Receipt Upload (shown only when GCash is selected) -->
                    <div id="gcash-receipt-container" class="mt-4 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">GCash Receipt</label>
                        <input type="file" name="gcash_receipt" id="gcash_receipt" class="w-full form-input" accept="image/*,.pdf">
                        <p class="text-xs text-gray-500 mt-1">Upload screenshot or PDF of your GCash payment receipt</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('frontdesk.bookings.index') }}" class="btn btn-gray">
                    <i class="fas fa-times mr-2"></i> Cancel
                </a>
                <button type="submit" class="btn btn-amber">
                    <i class="fas fa-calendar-plus mr-2"></i> Submit Booking
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Room Modal -->
<div id="roomModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
    <div class="relative mx-auto p-4 w-full max-w-4xl top-20">
        <div class="bg-white rounded-lg shadow-xl">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-xl font-bold">Available Rooms</h3>
                <button onclick="closeRoomModal()" class="text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </div>
            <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4" id="roomModalContent">
                @foreach($rooms as $room)
                <div class="border rounded-lg overflow-hidden cursor-pointer hover:shadow-md transition"
                     onclick="selectRoom({{ $room->id }}, '{{ $room->room_type }}', {{ $room->price_per_night }}, '{{ $room->image ? asset('storage/'.$room->image) : '' }}', {{ $room->capacity }})">
                    <div class="h-48 bg-gray-100 flex items-center justify-center">
                        @if($room->image)
                            <img src="{{ asset('storage/'.$room->image) }}" alt="{{ $room->room_type }}" class="h-full w-full object-cover">
                        @else
                            <span class="text-gray-400">No Image Available</span>
                        @endif
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold">{{ $room->room_type }}</h4>
                        <p class="text-gray-600">₱{{ number_format($room->price_per_night, 2) }}/night</p>
                        <p class="text-sm text-gray-500">Capacity: {{ $room->capacity }} guests</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Room Modal -->
<script>
    function openRoomModal() {
        document.getElementById('roomModal').classList.remove('hidden');
    }

    function closeRoomModal() {
        document.getElementById('roomModal').classList.add('hidden');
    }

    function selectRoom(roomId, roomType, price, imageUrl, capacity) {
        document.getElementById('selected_room_id').value = roomId;
        document.getElementById('room_capacity').value = capacity;
        
        // Enable guest selection after room selection
        document.getElementById('increment-btn').disabled = false;
        document.getElementById('decrement-btn').disabled = false;

        // Update guest count based on room capacity
        document.getElementById('guests').value = capacity;
        document.getElementById('guests').min = capacity;
        
        const displayDiv = document.getElementById('selected-room-display');
        displayDiv.classList.remove('hidden');
        displayDiv.innerHTML = `
            <div class="flex items-start">
                ${imageUrl ? `<img src="${imageUrl}" class="w-24 h-24 object-cover rounded-md mr-4">` : ''}
                <div>
                    <h4 class="font-bold">${roomType}</h4>
                    <p>₱${price.toFixed(2)} per night</p>
                    <p class="text-sm text-gray-600">Capacity: ${capacity} guests</p>
                </div>
            </div>
        `;
        
        // Update pricing
        document.getElementById('room-rate').textContent = `₱${price.toFixed(2)}`;
        calculateTotal();
        closeRoomModal();
    }
</script>

<script>
    function adjustGuests(change) {
        const guestInput = document.getElementById('guests');
        const roomCapacity = parseInt(document.getElementById('room_capacity').value);
        const maxGuests = roomCapacity + 2;  // Allow max 2 extra guests beyond capacity
        
        let newValue = parseInt(guestInput.value) + change;
        newValue = Math.max(roomCapacity, Math.min(maxGuests, newValue));  // Restrict guests to max and min limits
        
        guestInput.value = newValue;
        calculateTotal();
    }

    function calculateTotal() {
        const roomId = document.getElementById('selected_room_id').value;
        const guests = parseInt(document.getElementById('guests').value);
        const roomCapacity = parseInt(document.getElementById('room_capacity').value);
        const checkIn = document.getElementById('check_in').value;
        const checkOut = document.getElementById('check_out').value;
        
        if (!roomId || !checkIn || !checkOut) return;

        // Calculate nights
        const nights = Math.floor((new Date(checkOut) - new Date(checkIn)) / (1000 * 60 * 60 * 24));
        document.getElementById('nights').value = nights;
        
        // Get base price from selected room display
        const roomPriceText = document.getElementById('room-rate').textContent;
        const roomPrice = parseFloat(roomPriceText.replace(/[^\d.]/g, '')) || 0;
        
        // Calculate additional guest charge (₱180 for each guest beyond room capacity)
        const additionalGuestPrice = Math.max(0, guests - roomCapacity) * 180;
        
        // Late check-out charge (if after 12:00 PM)
        const checkOutTime = document.querySelector('select[name="check_out_time"]').value;
        const lateCheckOutCharge = checkOutTime > '12:00:00' ? 500 : 0;
        
        // Calculate total
        let total = (roomPrice * nights) + additionalGuestPrice + lateCheckOutCharge;
        
        // Update display
        document.getElementById('guest-charge').textContent = `₱${additionalGuestPrice.toFixed(2)}`;
        if (lateCheckOutCharge > 0) {
            document.getElementById('late-checkout-charge').textContent = `₱${lateCheckOutCharge.toFixed(2)}`;
            document.getElementById('late-checkout-row').classList.remove('hidden');
        } else {
            document.getElementById('late-checkout-row').classList.add('hidden');
        }
        document.getElementById('total-amount').textContent = `₱${total.toFixed(2)}`;
        document.getElementById('total_amount_input').value = total.toFixed(2);
    }

    document.getElementById('check_in').addEventListener('change', function() {
        if (this.value) {
            document.getElementById('check_out').disabled = false;
            document.getElementById('check_out').setAttribute('min', this.value);
            document.getElementById('check_in_error').classList.add('hidden');
            calculateTotal();
        }
    });

    document.getElementById('check_out').addEventListener('change', function() {
        calculateTotal();
    });
</script>

@endsection
