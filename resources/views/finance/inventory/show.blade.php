@extends('layouts.finance')

@section('title', 'Inventory Request #' . $request->id)

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex justify-between items-center mb-6 pb-2 border-b border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800">Inventory Request #{{ $request->id }}</h2>
            <a href="{{ route('finance.inventory.index') }}" class="btn btn-gray">
                <i class="fas fa-arrow-left mr-2"></i> Back to Requests
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Request Details -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-green-500 mr-2"></i>
                    Request Details
                </h3>
                <div class="space-y-3">
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Status</span>
                        <span>
                            @if($request->status == 'pending')
                                <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($request->status == 'approved')
                                <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Approved</span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">Rejected</span>
                            @endif
                        </span>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Request Date</span>
                        <span>{{ $request->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Purpose</span>
                        <span>{{ $request->purpose }}</span>
                    </div>
                </div>
            </div>

            <!-- Item Details -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-box text-green-500 mr-2"></i>
                    Item Information
                </h3>
                <div class="space-y-3">
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Item Name</span>
                        <span>{{ $request->inventoryItem->name }}</span>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Category</span>
                        <span class="capitalize">{{ $request->inventoryItem->category }}</span>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Current Stock</span>
                        <span>{{ $request->inventoryItem->stock_quantity }}</span>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Requested Quantity</span>
                        <span class="font-bold">{{ $request->quantity_requested }}</span>
                    </div>
                </div>
            </div>

            <!-- Requester Details -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user text-green-500 mr-2"></i>
                    Requester Information
                </h3>
                <div class="space-y-3">
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Name</span>
                        <span>{{ $request->user->name }}</span>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Role</span>
                        <span class="capitalize">{{ str_replace('_', ' ', $request->user->usertype) }}</span>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Department</span>
                        <span>
                            @if($request->user->usertype === 'housekeeping')
                                Housekeeping
                            @elseif($request->user->usertype === 'lifeguard')
                                Pool Area
                            @else
                                Other
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if($request->status === 'pending')
        <!-- Approval Form -->
        <div class="bg-white p-6 rounded-lg border border-gray-200 mt-6">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Request Approval</h3>
            <form action="{{ route('finance.inventory.approve', $request) }}" method="POST" class="mb-4">
                @csrf
                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Approval Notes (Optional)</label>
                    <textarea name="notes" id="notes" rows="3" class="w-full form-textarea" placeholder="Any notes for the requester..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="submit" class="btn btn-green">
                        <i class="fas fa-check mr-2"></i> Approve Request
                    </button>
                </div>
            </form>

            <form action="{{ route('finance.inventory.reject', $request) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason (Required)</label>
                    <textarea name="rejection_reason" id="rejection_reason" rows="3" class="w-full form-textarea" placeholder="Reason for rejecting this request..." required></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="submit" class="btn btn-red">
                        <i class="fas fa-times mr-2"></i> Reject Request
                    </button>
                </div>
            </form>
        </div>
        @else
        <!-- Approval Details -->
        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mt-6">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Decision Details</h3>
            <div class="space-y-4">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    <span class="font-medium">
                        @if($request->status == 'approved')
                            <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">Approved</span>
                        @else
                            <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">Rejected</span>
                        @endif
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Decision By</span>
                    <span>{{ $request->approvedBy->name ?? 'System' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Decision Date</span>
                    <span>{{ $request->approved_at?->format('M d, Y h:i A') ?? 'N/A' }}</span>
                </div>
                @if($request->status == 'approved' && $request->notes)
                <div>
                    <span class="block text-sm font-medium text-gray-500">Approval Notes</span>
                    <span>{{ $request->notes }}</span>
                </div>
                @endif
                @if($request->status == 'rejected')
                <div>
                    <span class="block text-sm font-medium text-gray-500">Rejection Reason</span>
                    <span>{{ $request->rejection_reason }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection