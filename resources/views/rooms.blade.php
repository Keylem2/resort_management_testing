@extends('layouts.admin') {{-- Using admin layout for consistent styling --}}

@section('title', 'Available Rooms - Blue Belle Resort')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Our Rooms</h2>
                <p class="text-gray-600 mt-1">Find your perfect stay at Blue Belle Resort</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('dashboard') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Rooms Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($rooms as $room)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
            <!-- Room Image -->
            <div class="h-48 bg-gray-100 flex items-center justify-center relative">
                @if($room->upcoming_bookings > 0)
                <span class="absolute top-2 right-2 bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                    Booked
                </span>
                @else
                <span class="absolute top-2 right-2 bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                    Available
                </span>
                @endif
                <img src="{{ asset('images/'.$room->room_type_slug.'-room.jpg') }}" alt="{{ $room->room_type }}" class="h-full w-full object-cover">
            </div>
            
            <!-- Room Details -->
            <div class="p-4">
                <h3 class="text-xl font-bold text-gray-800">{{ $room->room_type }}</h3>
                <div class="flex items-center mt-2 text-gray-600">
                    <i class="fas fa-ruler-combined text-sm mr-2"></i>
                    <span class="text-sm">{{ $room->size }} sqm</span>
                    <i class="fas fa-users text-sm ml-4 mr-2"></i>
                    <span class="text-sm">Max {{ $room->capacity }} guests</span>
                </div>
                
                <!-- Amenities -->
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach(explode(',', $room->amenities) as $amenity)
                    <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">
                        {{ trim($amenity) }}
                    </span>
                    @endforeach
                </div>
                
                <!-- Price and Book Button -->
                <div class="mt-4 flex justify-between items-center">
                    <div>
                        <span class="font-bold text-amber-600">₱{{ number_format($room->price_per_night, 2) }}</span>
                        <span class="text-gray-500 text-sm">/night</span>
                    </div>
                    @if($room->upcoming_bookings == 0)
                    <a href="{{ route('booking.create') }}?room_id={{ $room->id }}" 
                       class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded text-sm font-medium transition">
                        Book Now
                    </a>
                    @else
                    <span class="text-gray-500 text-sm">Not available</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection