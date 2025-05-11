@extends('layouts.user')

@section('title', 'Family Rooms')

@section('content')
<div class="space-y-8">
    <h3 class="text-2xl font-bold text-gray-800 mb-4">Family Rooms</h3>
    
    <!-- Rooms Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($rooms as $room)
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-xl transition-transform transform hover:scale-105">
            <!-- Room Status Badge -->
            <div class="p-4">
                <span class="px-2 py-1 text-xs font-medium rounded-full 
                          {{ $room->status == 'available' ? 'bg-green-100 text-green-800' : 
                             ($room->status == 'occupied' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                    {{ ucfirst($room->status) }}
                </span>
            </div>

            <!-- Room Details -->
            <div class="p-4">
                <h4 class="font-bold text-gray-800">{{ $room->room_type }}</h4>
                <p class="text-sm text-gray-600">Room #{{ $room->room_number }}</p>
                
                <!-- Room Price -->
                <div class="flex justify-between items-center mt-3">
                    <span class="text-primary-600 font-bold">₱{{ number_format($room->price_per_night, 2) }}</span>
                </div>
            </div>

            <!-- Book Now Button -->
            @if($room->status == 'available')
            <div class="p-4">
                <a href="{{ route('booking.create', ['room_id' => $room->id]) }}" class="btn btn-lg btn-primary w-full mt-4">
                    <i class="fas fa-check-circle mr-2"></i> Book Now
                </a>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection
