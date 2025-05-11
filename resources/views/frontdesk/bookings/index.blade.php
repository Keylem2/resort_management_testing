@extends('layouts.frontdesk')

@section('title', 'Manage Bookings')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <h1 class="text-2xl font-bold text-gray-800">
            @if(request()->has('status'))
                {{ ucfirst(request()->status) }} Bookings
            @else
                All Bookings
            @endif
        </h1>
        <a href="{{ route('frontdesk.bookings.create') }}" class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fas fa-plus mr-2"></i> New Booking
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Status Filters -->
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('frontdesk.bookings.index') }}" class="px-3 py-1 rounded-full text-sm font-medium {{ !request()->has('status') ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
            All
        </a>
        <a href="{{ route('frontdesk.bookings.index', ['status' => 'pending']) }}" class="px-3 py-1 rounded-full text-sm font-medium {{ request()->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
            Pending
        </a>
        <a href="{{ route('frontdesk.bookings.index', ['status' => 'confirmed']) }}" class="px-3 py-1 rounded-full text-sm font-medium {{ request()->status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
            Confirmed
        </a>
        <a href="{{ route('frontdesk.bookings.index', ['status' => 'checked_in']) }}" class="px-3 py-1 rounded-full text-sm font-medium {{ request()->status === 'checked_in' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
            Checked In
        </a>
        <a href="{{ route('frontdesk.bookings.index', ['status' => 'checked_out']) }}" class="px-3 py-1 rounded-full text-sm font-medium {{ request()->status === 'checked_out' ? 'bg-gray-100 text-gray-800' : 'bg-gray-100 text-gray-800' }}">
            Checked Out
        </a>
        <a href="{{ route('frontdesk.bookings.index', ['status' => 'cancelled']) }}" class="px-3 py-1 rounded-full text-sm font-medium {{ request()->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
            Cancelled
        </a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guest</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($bookings as $booking)
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
                            <div class="text-sm text-gray-500">to {{ $booking->check_out->format('M d, Y') }}</div>
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
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $booking->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($booking->payment_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('frontdesk.bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('frontdesk.bookings.edit', $booking) }}" class="text-yellow-600 hover:text-yellow-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($booking->status === 'confirmed')
                                    <form action="{{ route('frontdesk.bookings.checkin', $booking) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900">
                                            <i class="fas fa-sign-in-alt"></i>
                                        </button>
                                    </form>
                                @elseif($booking->status === 'checked_in')
                                    <form action="{{ route('frontdesk.bookings.checkout', $booking) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No bookings found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection