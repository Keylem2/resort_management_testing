@extends('layouts.frontdesk')

@section('title', 'Front Desk Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="text-gray-600 mt-1">Here's what's happening at Blue Belle Resort today.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    <i class="fas fa-desktop mr-1"></i> Front Desk
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Today's Check-ins Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Today's Check-ins</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $todaysCheckins ?? 0 }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                    <i class="fas fa-sign-in-alt text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm font-medium text-gray-600 flex items-center">
                    <i class="fas fa-clock mr-1"></i> To be processed
                </span>
            </div>
        </div>

        <!-- Today's Check-outs Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Today's Check-outs</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $todaysCheckouts ?? 0 }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                    <i class="fas fa-sign-out-alt text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm font-medium text-gray-600 flex items-center">
                    <i class="fas fa-clock mr-1"></i> To be processed
                </span>
            </div>
        </div>

        <!-- Bookings Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Today's Bookings</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $todaysBookings }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-amber-100 text-amber-600">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm font-medium {{ $bookingChange >= 0 ? 'text-green-600' : 'text-red-600' }} flex items-center">
                    <i class="fas fa-arrow-{{ $bookingChange >= 0 ? 'up' : 'down' }} mr-1"></i> {{ abs($bookingChange) }}%
                </span>
                <span class="text-xs text-gray-500 ml-2">vs yesterday</span>
            </div>
        </div>

        <!-- Available Rooms Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Available Rooms</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $availableRooms ?? 0 }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-green-100 text-green-600">
                    <i class="fas fa-bed text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm font-medium text-gray-600 flex items-center">
                    <i class="fas fa-info-circle mr-1"></i> {{ $occupiedRooms ?? 0 }} occupied
                </span>
            </div>
        </div>
    </div>

    <!-- Recent Bookings & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Bookings -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800">Recent Bookings</h3>
                <a href="{{ route('frontdesk.bookings.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guest</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check-In</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentBookings as $booking)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-medium">
                                        {{ substr($booking->user->name, 0, 2) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $booking->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $booking->room->room_type }}</div>
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
                                        'checked_in' => 'bg-blue-100 text-blue-800',
                                        'checked_out' => 'bg-gray-100 text-gray-800',
                                    ];
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('frontdesk.bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-800">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No recent bookings found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Quick Actions</h3>
            
            <div class="space-y-4">
                <a href="{{ route('frontdesk.bookings.create') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    <div class="p-3 rounded-lg bg-white text-blue-600 shadow-sm mr-4">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">New Booking</h4>
                        <p class="text-sm text-gray-500">Create reservation</p>
                    </div>
                </a>
                
                <a href="{{ route('frontdesk.bookings.index', ['status' => 'checked_in']) }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                    <div class="p-3 rounded-lg bg-white text-green-600 shadow-sm mr-4">
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">Check-ins</h4>
                        <p class="text-sm text-gray-500">Process arrivals</p>
                    </div>
                </a>
                
                <a href="{{ route('frontdesk.bookings.index', ['status' => 'checked_out']) }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                    <div class="p-3 rounded-lg bg-white text-purple-600 shadow-sm mr-4">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">Check-outs</h4>
                        <p class="text-sm text-gray-500">Process departures</p>
                    </div>
                </a>
                
                <a href="{{ route('frontdesk.bookings.index', ['status' => 'pending']) }}" class="flex items-center p-4 bg-amber-50 rounded-lg hover:bg-amber-100 transition">
                    <div class="p-3 rounded-lg bg-white text-amber-600 shadow-sm mr-4">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">Pending Bookings</h4>
                        <p class="text-sm text-gray-500">Review reservations</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection