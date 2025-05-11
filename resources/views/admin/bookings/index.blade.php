@extends('layouts.admin')

@section('title', 'Manage Bookings')

@section('content')
<div class="space-y-6">
    <!-- Add New Booking Button (similar to dashboard) -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <a href="{{ route('admin.bookings.create') }}" class="flex items-center p-4 bg-amber-50 rounded-lg hover:bg-amber-100 transition">
            <div class="p-3 rounded-lg bg-white text-amber-600 shadow-sm mr-4">
                <i class="fas fa-plus"></i>
            </div>
            <div>
                <h4 class="font-medium text-gray-800">Add New Booking</h4>
                <p class="text-sm text-gray-500">Manual reservation</p>
            </div>
        </a>
    </div>

    <!-- Bookings Table -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Bookings List</h2>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search bookings..." class="pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-200">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <!-- Table Headers -->
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guest</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Room</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dates</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <!-- Table Body -->
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($bookings as $booking)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-amber-100 rounded-full flex items-center justify-center text-amber-600 font-medium">
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
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($booking->status == 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->status == 'cancelled') bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="text-amber-600 hover:text-amber-800 mr-3">View</a>
                            <a href="{{ route('admin.bookings.edit', $booking) }}" class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>
                            <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No bookings found. 
                            <a href="{{ route('admin.bookings.create') }}" class="text-amber-600 hover:text-amber-800">Create your first booking</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->count())
        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>
</div>
@endsection