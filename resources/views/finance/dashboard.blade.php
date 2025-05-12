@extends('layouts.finance')

@section('title', 'Finance Dashboard')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Pending Bookings Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Pending Bookings</h3>
                <a href="{{ route('finance.bookings.index') }}" class="text-blue-500 hover:text-blue-700 text-sm font-medium">View All</a>
            </div>
            @php
                $pendingBookings = App\Models\Booking::where('status', 'pending')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            @endphp
            @if($pendingBookings->isEmpty())
                <p class="text-gray-500">No pending bookings</p>
            @else
                <ul class="space-y-3">
                    @foreach($pendingBookings as $booking)
                    <li class="border-b pb-2 last:border-0 last:pb-0">
                        <a href="{{ route('finance.bookings.show', $booking) }}" class="block hover:bg-gray-50 p-2 rounded">
                            <div class="flex justify-between">
                                <span class="font-medium">#{{ $booking->id }} - {{ $booking->room->room_type }}</span>
                                <span class="text-gray-500">{{ $booking->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ $booking->user->name }} • {{ $booking->nights }} night(s)
                            </div>
                            <div class="text-sm font-bold">
                                ₱{{ number_format($booking->total_amount, 2) }}
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <!-- Pending Inventory Requests -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-800">Pending Inventory Requests</h3>
               <a href="{{ route('finance.inventory-requests.index') }}" class="text-blue-500 hover:text-blue-700 text-sm font-medium">View All</a>
            </div>
            @php
                $pendingRequests = App\Models\InventoryRequest::where('status', 'pending')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            @endphp
            @if($pendingRequests->isEmpty())
                <p class="text-gray-500">No pending requests</p>
            @else
                <ul class="space-y-3">
                    @foreach($pendingRequests as $request)
                    <li class="border-b pb-2 last:border-0 last:pb-0">
                        <a href="{{ route('finance.inventory-requests.show', $request) }}" class="block hover:bg-gray-50 p-2 rounded">
                            <div class="flex justify-between">
                                <span class="font-medium">{{ $request->inventoryItem->name }}</span>
                                <span class="text-gray-500">{{ $request->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="text-sm text-gray-600">
                                Requested by: {{ $request->user->name }}
                            </div>
                            <div class="text-sm">
                                Qty: {{ $request->quantity_requested }} • 
                                <span class="font-bold">{{ $request->inventoryItem->stock_quantity }} available</span>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection