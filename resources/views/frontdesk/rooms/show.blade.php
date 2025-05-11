@extends('layouts.frontdesk')

@section('title', 'Room Details')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $room->room_type }}</h2>
                <p class="text-gray-600 mt-1">Room details for {{ $room->room_type }}</p>
            </div>
        </div>
    </div>

    <!-- Room Details -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-xl font-bold text-gray-800">Room Information</h3>
        <p class="text-gray-600 mt-1"><strong>Room Number:</strong> {{ $room->room_number }}</p>
        <p class="text-gray-600 mt-1"><strong>Status:</strong> {{ $room->status }}</p>
        <p class="text-gray-600 mt-1"><strong>Price per Night:</strong> ₱{{ number_format($room->price_per_night, 2) }}</p>
        <p class="text-gray-600 mt-1"><strong>Capacity:</strong> {{ $room->capacity }} guests</p>
        <div class="mt-4">
            <a href="{{ route('frontdesk.rooms.index') }}" class="btn btn-primary">Back to Rooms</a>
        </div>
    </div>
</div>
@endsection
