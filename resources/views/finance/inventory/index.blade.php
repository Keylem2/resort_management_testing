@extends('layouts.finance')

@section('title', 'Inventory Requests')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex justify-between items-center mb-6 pb-2 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800">Inventory Requests</h2>
            <div class="flex space-x-3">
                <a href="{{ route('finance.dashboard') }}" class="btn btn-gray">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                </a>
            </div>
        </div>

        @if($requests->isEmpty())
            <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-lg">
                <i class="fas fa-info-circle mr-2"></i> No pending inventory requests.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requested By</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Available</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($requests as $request)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $request->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $request->inventoryItem->name }}
                                <div class="text-xs text-gray-400">{{ $request->inventoryItem->category }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $request->user->name }}
                                <div class="text-xs text-gray-400">{{ $request->user->usertype }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $request->quantity_requested }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $request->inventoryItem->stock_quantity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($request->status == 'pending')
                                    <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">Pending</span>
                                @elseif($request->status == 'approved')
                                    <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Approved</span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">Rejected</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('finance.inventory.show', $request) }}" class="text-green-600 hover:text-green-900 mr-3">
                                    <i class="fas fa-eye mr-1"></i> Review
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</div>
@endsection