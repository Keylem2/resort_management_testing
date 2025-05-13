@extends('layouts.user')

@section('title', 'Create Booking')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Progress Bar -->
        <div class="bg-gray-50 px-6 py-4 border-b">
            <div class="flex items-center">
                <div class="flex-1">
                    <div class="flex justify-between text-sm font-medium text-gray-500">
                        <span id="step1-indicator" class="flex items-center text-amber-600">
                            <span class="flex items-center justify-center w-6 h-6 bg-amber-500 rounded-full text-white mr-2">1</span>
                            Room Selection
                        </span>
                        <span id="step2-indicator" class="flex items-center">
                            <span class="flex items-center justify-center w-6 h-6 bg-gray-200 rounded-full text-gray-600 mr-2">2</span>
                            Dates
                        </span>
                        <span id="step3-indicator" class="flex items-center">
                            <span class="flex items-center justify-center w-6 h-6 bg-gray-200 rounded-full text-gray-600 mr-2">3</span>
                            Payment
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <form id="bookingForm" action="{{ route('booking.store') }}" method="POST">
            @csrf
            <input type="hidden" name="form_token" value="{{ $formToken }}">
            <input type="hidden" name="room_id" id="selected_room_id">
            <input type="hidden" name="check_in" id="hidden_check_in">
            <input type="hidden" name="check_out" id="hidden_check_out">
            <input type="hidden" name="guests" id="hidden_guests" value="2">
            <input type="hidden" name="total_amount" id="total_amount_input">
            <input type="hidden" name="deposit_amount" id="deposit_amount_input">
            <input type="hidden" name="payment_method" id="payment_method" value="gcash">
            <input type="hidden" name="payment_status" id="payment_status" value="pending">
            <input type="hidden" name="check_in_time" value="14:00:00">
            <input type="hidden" name="check_out_time" value="12:00:00">
            <input type="hidden" name="status" value="pending">
            <input type="hidden" name="nights" id="hidden_nights">

            <!-- Step 1: Room Selection -->
            <div id="step1" class="px-6 py-4">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Select Your Room</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($rooms as $room)
                    <div class="room-option cursor-pointer border rounded-lg p-4 hover:border-amber-400 transition-colors duration-200"
                        data-room-id="{{ $room->id }}"
                        data-price="{{ $room->price_per_night }}"
                        data-capacity="{{ $room->capacity }}"
                        data-room-type="{{ $room->room_type }}"
                        data-room-number="{{ $room->room_number }}">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ $room->room_type }}</h3>
                                <p class="text-gray-600">Room #{{ $room->room_number }}</p>
                            </div>
                            <span class="text-lg font-bold text-amber-600"
                                data-price="{{ number_format($room->price_per_night, 2, '.', '') }}">
                                ₱{{ number_format($room->price_per_night, 2) }}/night
                            </span>
                        </div>
                        <div class="mt-4">
                            <p class="text-sm text-gray-500">{{ $room->description }}</p>
                            <div class="mt-3 flex items-center text-sm text-gray-500">
                                <i class="fas fa-users mr-1"></i>
                                Base guests: {{ $room->capacity }} (Max {{ $room->capacity + 2 }} with additional charge)
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @error('room_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div class="mt-8 flex justify-end">
                    <button type="button" id="nextToStep2"
                        class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-lg font-semibold text-white hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        Continue to Dates
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>

            <!-- Step 2: Dates & Guests -->

            <div id="step2" class="px-6 py-4 hidden">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Select Dates & Guests</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Dates Selection -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-calendar-alt text-amber-500 mr-2"></i>
                            Booking Dates
                        </h3>
                        <div>
                            <label for="check_in_date" class="block text-sm font-medium text-gray-700 mb-2">Check-in Date</label>
                            <input type="date"
                                id="check_in_date"
                                class="w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500"
                                min="{{ date('Y-m-d', strtotime('+3 days')) }}"
                                max="{{ date('Y-m-d', strtotime('+30 days')) }}"
                                required>
                            <p class="mt-1 text-xs text-gray-500">Check-in time: 2:00 PM</p>
                            @error('check_in')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="check_out_date" class="block text-sm font-medium text-gray-700 mb-2">Check-out Date</label>
                            <input type="date"
                                id="check_out_date"
                                class="w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500"
                                required>
                            <p class="mt-1 text-xs text-gray-500">Check-out time: 12:00 PM</p>
                            @error('check_out')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Guest Details -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-users text-blue-500 mr-2"></i>
                            Guest Details
                        </h3>
                        <div>
                            <label for="guests_display" class="block text-sm font-medium text-gray-700 mb-2">Number of Guests</label>
                            <div class="flex items-center">
                                <button type="button" id="decreaseGuests" class="px-3 py-1 bg-gray-200 rounded-l-lg hover:bg-gray-300 disabled:opacity-50" disabled>
                                    -
                                </button>
                                <input type="text" id="guests_display" class="w-1/3 text-center rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500" value="2" readonly>
                                <button type="button" id="increaseGuests" class="px-3 py-1 bg-gray-200 rounded-r-lg hover:bg-gray-300">
                                    +
                                </button>
                            </div>
                            <p class="mt-1 text-xs text-gray-500" id="maxGuestsText">Select a room to see guest capacity</p>
                            <p class="mt-1 text-sm text-red-600 hidden" id="maxGuestsWarning">
                                Exceeds maximum room capacity
                            </p>
                            @error('guests')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="mt-8 flex justify-between">
                    <button type="button" id="backToStep1"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-lg font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back
                    </button>
                    <button type="button" id="nextToStep3"
                        class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-lg font-semibold text-white hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        Continue to Payment
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </div>

            <!-- Step 3: Payment Method -->
            <div id="step3" class="px-6 py-4 hidden">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Payment Method</h2>

                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <div class="space-y-6">
                        <!-- Booking Summary -->
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Booking Details</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Room:</span>
                                    <span class="font-medium" id="paymentRoomType">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Dates:</span>
                                    <span class="font-medium" id="paymentDates">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Nights:</span>
                                    <span class="font-medium" id="paymentNights">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Guests:</span>
                                    <span class="font-medium" id="paymentGuests">-</span>
                                </div>
                                <div class="border-t border-gray-200 pt-2 mt-2">
                                    <div class="flex justify-between font-semibold">
                                        <span>Total Amount:</span>
                                        <span class="text-lg" id="paymentTotalAmount">₱0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Options -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800">Choose Payment Option</h3>
                            <!-- Option 1: Deposit Only -->
                            <div class="relative">
                                <input class="sr-only peer" id="payment_option1" type="radio" name="payment_option" value="deposit" checked>
                                <label class="flex p-4 bg-white border border-gray-300 rounded-lg cursor-pointer focus:outline-none hover:bg-gray-50 peer-checked:border-amber-500 peer-checked:ring-1 peer-checked:ring-amber-500" for="payment_option1">
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center mr-3 peer-checked:border-amber-500 peer-checked:bg-amber-500">
                                            <div class="w-3 h-3 rounded-full bg-white"></div>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900">Pay 20% Reservation Fee (GCash)</h4>
                                            <p class="text-sm text-gray-500">Secure your booking with ₱<span id="reservationFeeAmount">0.00</span>. Pay remaining balance at check-in.</p>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- Option 2: Full Payment -->
                            <div class="relative">
                                <input class="sr-only peer" id="payment_option2" type="radio" name="payment_option" value="full">
                                <label class="flex p-4 bg-white border border-gray-300 rounded-lg cursor-pointer focus:outline-none hover:bg-gray-50 peer-checked:border-amber-500 peer-checked:ring-1 peer-checked:ring-amber-500" for="payment_option2">
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center mr-3 peer-checked:border-amber-500 peer-checked:bg-amber-500">
                                            <div class="w-3 h-3 rounded-full bg-white"></div>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900">Pay Full Amount Now (GCash)</h4>
                                            <p class="text-sm text-gray-500">Complete payment of ₱<span id="fullPaymentAmount">0.00</span> and enjoy hassle-free check-in.</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- GCash Payment Instructions -->
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200 mt-4">
                            <h4 class="font-medium text-blue-800 mb-2">
                                <i class="fas fa-mobile-alt text-blue-500 mr-2"></i>
                                GCash Payment Instructions
                            </h4>
                            <ol class="list-decimal list-inside text-sm text-blue-700 space-y-1">
                                <li>You'll be redirected to GCash payment page</li>
                                <li>Complete the payment using your GCash account</li>
                                <li>Wait for payment confirmation (usually instant)</li>
                                <li>Your booking will be confirmed after finance verification</li>
                            </ol>
                        </div>

                        <!-- Special Requests -->
                        <div class="mt-4 space-y-2">
                            <label for="special_requests" class="block text-sm font-medium text-gray-700">Special Requests</label>
                            <textarea name="special_requests" id="special_requests" class="w-full rounded-lg border-gray-300 focus:border-amber-500 focus:ring-amber-500" rows="3" placeholder="Any special requests or notes...">{{ old('special_requests') }}</textarea>
                            @error('special_requests')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mt-4">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms" name="terms" type="checkbox" class="focus:ring-amber-500 h-4 w-4 text-amber-600 border-gray-300 rounded" required>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="font-medium text-gray-700">I agree to the <a href="#" class="text-amber-600 hover:text-amber-500">terms and conditions</a></label>
                                    <p class="text-gray-500">By proceeding, you agree to our cancellation policy and understand that payments are non-refundable.</p>
                                </div>
                            </div>
                            @error('terms')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="mt-8 flex justify-between">
                    <button type="button" id="backToStep2"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-lg font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back
                    </button>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-lg font-semibold text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-lock mr-2"></i>
                        Confirm Booking
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form elements
        const form = document.getElementById('bookingForm');
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step3 = document.getElementById('step3');
        const nextToStep2 = document.getElementById('nextToStep2');
        const nextToStep3 = document.getElementById('nextToStep3');
        const backToStep1 = document.getElementById('backToStep1');
        const backToStep2 = document.getElementById('backToStep2');
        const checkInInput = document.getElementById('check_in_date');
        const checkOutInput = document.getElementById('check_out_date');
        const guestsDisplay = document.getElementById('guests_display');
        const increaseGuests = document.getElementById('increaseGuests');
        const decreaseGuests = document.getElementById('decreaseGuests');
        const maxGuestsText = document.getElementById('maxGuestsText');
        const maxGuestsWarning = document.getElementById('maxGuestsWarning');
        const roomOptions = document.querySelectorAll('.room-option');
        const selectedRoomId = document.getElementById('selected_room_id');
        const hiddenGuests = document.getElementById('hidden_guests');
        const hiddenCheckIn = document.getElementById('hidden_check_in');
        const hiddenCheckOut = document.getElementById('hidden_check_out');
        const hiddenNights = document.getElementById('hidden_nights');

        // Progress indicators
        const step1Indicator = document.getElementById('step1-indicator');
        const step2Indicator = document.getElementById('step2-indicator');
        const step3Indicator = document.getElementById('step3-indicator');

        // Booking data
        let currentMaxGuests = 1;
        let selectedRoomPrice = 0;
        let selectedRoomType = '';
        let selectedRoomNumber = '';
        let baseGuests = 2;
        const additionalGuestCharge = 180;

        // Update progress steps
        function updateProgressSteps(currentStep) {
            // Reset all indicators
            [step1Indicator, step2Indicator, step3Indicator].forEach(indicator => {
                indicator.classList.remove('text-amber-600');
                const numberSpan = indicator.querySelector('span');
                numberSpan.classList.remove('bg-amber-500', 'text-white');
                numberSpan.classList.add('bg-gray-200', 'text-gray-600');
            });

            // Highlight current and previous steps
            for (let i = 1; i <= currentStep; i++) {
                const indicator = document.getElementById(`step${i}-indicator`);
                indicator.classList.add('text-amber-600');
                const numberSpan = indicator.querySelector('span');
                numberSpan.classList.remove('bg-gray-200', 'text-gray-600');
                numberSpan.classList.add('bg-amber-500', 'text-white');
            }
        }

        // Update payment summary display
        function updateSummary() {
            const selectedRoom = document.querySelector('.room-option.selected');
            if (!selectedRoom || !checkInInput.value || !checkOutInput.value) {
                return;
            }

            const checkInDate = new Date(checkInInput.value);
            const checkOutDate = new Date(checkOutInput.value);
            const oneDay = 24 * 60 * 60 * 1000;
            const nights = Math.max(1, Math.ceil((checkOutDate - checkInDate) / oneDay));

            const guests = parseInt(guestsDisplay.value);
            const roomPrice = parseFloat(selectedRoom.dataset.price).toFixed(2);
            const roomCapacity = parseInt(selectedRoom.dataset.capacity);
            const additionalGuestRate = 180.00;

            const additionalGuests = Math.max(0, guests - roomCapacity);
            const additionalCharges = (additionalGuests * additionalGuestRate).toFixed(2);
            const roomTotal = (parseFloat(roomPrice) * nights).toFixed(2);
            const totalAmount = (parseFloat(roomTotal) + parseFloat(additionalCharges)).toFixed(2);
            const depositAmount = (totalAmount * 0.2).toFixed(2);

            // Update UI
            document.getElementById('paymentRoomType').textContent = `${selectedRoom.dataset.roomType} (Room ${selectedRoom.dataset.roomNumber})`;
            document.getElementById('paymentDates').textContent = `${checkInInput.value} to ${checkOutInput.value}`;
            document.getElementById('paymentNights').textContent = `${nights} night${nights !== 1 ? 's' : ''}`;
            document.getElementById('paymentGuests').textContent = guests;
            document.getElementById('paymentTotalAmount').textContent = `₱${totalAmount}`;
            document.getElementById('reservationFeeAmount').textContent = depositAmount;
            document.getElementById('fullPaymentAmount').textContent = totalAmount;

            // Set hidden form values
            document.getElementById('total_amount_input').value = totalAmount;
            document.getElementById('deposit_amount_input').value = depositAmount;
            hiddenCheckIn.value = checkInInput.value;
            hiddenCheckOut.value = checkOutInput.value;
            hiddenNights.value = nights.toString();

            console.log("Booking Summary (Frontend):", {
                nights: nights,
                roomPrice: roomPrice,
                additionalGuests: additionalGuests,
                additionalCharges: additionalCharges,
                roomTotal: roomTotal,
                totalAmount: totalAmount
            });
        }


        // Guest controls handlers
        function handleIncreaseGuests() {
            let current = parseInt(guestsDisplay.value);
            if (current < currentMaxGuests) {
                guestsDisplay.value = current + 1;
                hiddenGuests.value = current + 1;
                decreaseGuests.disabled = false;
                if (current + 1 >= currentMaxGuests) {
                    increaseGuests.disabled = true;
                    maxGuestsWarning.classList.remove('hidden');
                } else {
                    maxGuestsWarning.classList.add('hidden');
                }
                updateSummary();
            }
        }

        function handleDecreaseGuests() {
            let current = parseInt(guestsDisplay.value);
            if (current > baseGuests) {
                guestsDisplay.value = current - 1;
                hiddenGuests.value = current - 1;
                increaseGuests.disabled = false;
                maxGuestsWarning.classList.add('hidden');
                if (current - 1 <= baseGuests) {
                    decreaseGuests.disabled = true;
                }
                updateSummary();
            }
        }

        // Initialize guest controls
        increaseGuests.addEventListener('click', handleIncreaseGuests);
        decreaseGuests.addEventListener('click', handleDecreaseGuests);

        // Room selection handler
        roomOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remove selection from all options first
                roomOptions.forEach(opt => {
                    opt.classList.remove('selected', 'border-amber-400', 'bg-amber-50', 'ring-2', 'ring-amber-500');
                });

                // Add to clicked element
                this.classList.add('selected', 'border-amber-400', 'bg-amber-50', 'ring-2', 'ring-amber-500');

                // Set room data
                selectedRoomId.value = this.dataset.roomId;
                selectedRoomPrice = parseFloat(this.dataset.price);
                selectedRoomType = this.dataset.roomType;
                selectedRoomNumber = this.dataset.roomNumber;

                // Get capacity
                baseGuests = parseInt(this.dataset.capacity) || 2;
                currentMaxGuests = baseGuests + 2;

                // Set UI values
                guestsDisplay.value = baseGuests;
                hiddenGuests.value = baseGuests;
                maxGuestsText.textContent = `Base guests: ${baseGuests} (Max ${currentMaxGuests} with ₱${additionalGuestCharge} per additional guest)`;

                // Update button states
                decreaseGuests.disabled = (baseGuests <= 1);
                increaseGuests.disabled = (baseGuests >= currentMaxGuests);
                maxGuestsWarning.classList.add('hidden');

                // Enable next button
                nextToStep2.disabled = false;

                updateSummary();
            });
        });

        // Date handling
        checkInInput.addEventListener('change', function() {
            const checkInDate = new Date(this.value);
            const nextDay = new Date(checkInDate);
            nextDay.setDate(checkInDate.getDate() + 1);

            // Format as YYYY-MM-DD
            const minCheckout = nextDay.toISOString().split('T')[0];

            // Set minimum check-out date to next day
            checkOutInput.min = minCheckout;

            // If current check-out is invalid, clear it and disable next button
            if (checkOutInput.value && new Date(checkOutInput.value) <= checkInDate) {
                checkOutInput.value = '';
                nextToStep3.disabled = true;
            }

            updateSummary();
            validateStep2();
        });

        checkOutInput.addEventListener('change', function() {
            if (checkInInput.value) {
                const checkInDate = new Date(checkInInput.value);
                const checkOutDate = new Date(this.value);

                if (checkOutDate <= checkInDate) {
                    alert('Check-out date must be after check-in date');
                    this.value = '';
                    nextToStep3.disabled = true;
                    return;
                }
            }

            updateSummary();
            validateStep2();
        });

        // Validate step 2 with additional date check
        function validateStep2() {
            const checkInDate = new Date(checkInInput.value);
            const checkOutDate = new Date(checkOutInput.value);

            // Ensure check-in and check-out dates are set
            if (!checkInInput.value || !checkOutInput.value) {
                nextToStep3.disabled = true;
                return false;
            }

            // Ensure check-out date is after check-in date
            if (checkOutDate <= checkInDate) {
                nextToStep3.disabled = true;
                return false;
            }

            // Ensure a room is selected
            if (!selectedRoomId.value) {
                nextToStep3.disabled = true;
                return false;
            }

            // If all validations pass, enable the button
            nextToStep3.disabled = false;
            return true;
        }


        // Navigation between steps
        nextToStep2.addEventListener('click', function(e) {
            e.preventDefault();
            if (!selectedRoomId.value) {
                alert('Please select a room before proceeding.');
                return;
            }

            step1.classList.add('hidden');
            step2.classList.remove('hidden');
            updateProgressSteps(2);
            validateStep2();
            window.scrollTo(0, 0);
        });

        nextToStep3.addEventListener('click', function(e) {
            e.preventDefault();
            if (!validateStep2()) {
                alert('Please ensure your check-out date is after the check-in date and all fields are filled correctly.');
                return;
            }

            updateSummary();
            step2.classList.add('hidden');
            step3.classList.remove('hidden');
            updateProgressSteps(3);
            window.scrollTo(0, 0);
        });


        backToStep1.addEventListener('click', function() {
            step2.classList.add('hidden');
            step1.classList.remove('hidden');
            updateProgressSteps(1);
            window.scrollTo(0, 0);
        });

        backToStep2.addEventListener('click', function() {
            step3.classList.add('hidden');
            step2.classList.remove('hidden');
            updateProgressSteps(2);
            window.scrollTo(0, 0);
        });

        // Form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';

            // Validate dates
            const checkInDate = new Date(checkInInput.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (checkInDate <= today) {
                alert('Check-in date must be after today');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-lock mr-2"></i> Confirm Booking';
                return;
            }

            if (!checkOutInput.value || new Date(checkOutInput.value) <= checkInDate) {
                alert('Check-out date must be after check-in date');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-lock mr-2"></i> Confirm Booking';
                return;
            }

            // Ensure all required fields are filled
            if (!selectedRoomId.value || !checkInInput.value || !checkOutInput.value) {
                alert('Please complete all required fields');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-lock mr-2"></i> Confirm Booking';
                return;
            }

            // Set payment method and status based on selected option
            const paymentOption = document.querySelector('input[name="payment_option"]:checked').value;
            document.getElementById('payment_method').value = paymentOption === 'full' ? 'gcash_full' : 'gcash_deposit';
            document.getElementById('payment_status').value = paymentOption === 'full' ? 'paid' : 'pending';

            // Submit the form
            form.submit();
        });

        // Initialize
        updateProgressSteps(1);
        nextToStep2.disabled = true;

        // Set minimum check-in date (72 hours from now)
        const today = new Date();
        today.setDate(today.getDate() + 3);
        checkInInput.min = today.toISOString().split('T')[0];
    });
</script>

<style>
    .room-option {
        transition: all 0.2s ease;
    }

    .room-option:hover {
        transform: translateY(-2px);
    }

    .room-option.selected {
        border-color: rgb(217, 119, 6);
        /* amber-600 */
        background-color: rgb(255, 251, 235);
        /* amber-50 */
        box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.5);
        /* amber-500 with opacity */
        transform: translateY(-2px);
    }

    input[type="date"] {
        color: #374151 !important;
        /* Match your text-gray-700 color */
    }

    input[type="date"]::-webkit-datetime-edit-year-field {
        color: #374151 !important;
    }

    /* Style for guest count buttons */
    #increaseGuests,
    #decreaseGuests {
        transition: background-color 0.2s ease;
    }
</style>
@endsection