@extends('layouts.finance')

@section('title', 'Pending Bookings Approval')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex justify-between items-center mb-6 pb-2 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800">Pending Bookings</h2>
            <div class="flex space-x-3">
                <a href="{{ route('finance.dashboard') }}" class="btn btn-gray">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                </a>
            </div>
        </div>

        @if($bookings->isEmpty())
            <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-lg">
                <i class="fas fa-info-circle mr-2"></i> No pending bookings requiring approval.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guest</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($bookings as $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $booking->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->user->name }}
                                <div class="text-xs text-gray-400">{{ $booking->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->room->room_type }}
                                <div class="text-xs text-gray-400">Capacity: {{ $booking->room->capacity }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $booking->check_in->format('M d, Y') }} - {{ $booking->check_out->format('M d, Y') }}
                                <div class="text-xs text-gray-400">{{ $booking->nights }} night(s)</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                ₱{{ number_format($booking->total_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('finance.bookings.review', $booking) }}" class="text-green-600 hover:text-green-900 mr-3">
                                    <i class="fas fa-eye mr-1"></i> Review
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection