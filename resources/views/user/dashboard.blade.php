@extends('layouts.user')

@section('title', 'My Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Welcome, {{ Auth::user()->name }}!</h2>
                <p class="text-gray-600 mt-1">Here's your booking overview at Blue Belle Resort.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    <i class="fas fa-user mr-1"></i> Member
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Upcoming Stays Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Upcoming Stays</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $upcomingBookings->count() }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-amber-100 text-amber-600">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('booking.create') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                    <i class="fas fa-plus mr-1"></i> Book a room
                </a>
            </div>
        </div>

        <!-- Past Stays Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Past Stays</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $pastBookings->count() }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-green-100 text-green-600">
                    <i class="fas fa-history text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('booking.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                    <i class="fas fa-list mr-1"></i> View all bookings
                </a>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Quick Actions</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">&nbsp;</h3>
                </div>
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                    <i class="fas fa-bolt text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex space-x-3">
                <a href="{{ route('booking.create') }}" class="text-sm font-medium text-white bg-amber-600 px-3 py-1 rounded-md hover:bg-amber-700">
                    New Booking
                </a>
                <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-gray-600 bg-gray-100 px-3 py-1 rounded-md hover:bg-gray-200">
                    My Profile
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Bookings Section -->
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-800">Your Recent Bookings</h3>
            <a href="{{ route('booking.index') }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium">View All</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentBookings as $booking)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $booking->room->room_type }}</div>
                            <div class="text-sm text-gray-500">#{{ $booking->room->room_number }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $booking->check_in->format('M d, Y') }}</div>
                            <div class="text-sm text-gray-500">{{ $booking->check_out->diffInDays($booking->check_in) }} nights</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'confirmed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                    'completed' => 'bg-blue-100 text-blue-800',
                                ];
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('booking.show', $booking) }}" class="text-amber-600 hover:text-amber-900">View</a>
                            @if($booking->status == 'pending' && $booking->check_in > now()->addDays(1))
                                <a href="{{ route('booking.edit', $booking) }}" class="text-blue-600 hover:text-blue-900 ml-3">Edit</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            No bookings found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
