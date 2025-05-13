@extends('layouts.staff_team')

@section('title', 'Inventory Requests | Blue Belle Resort')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Inventory Requests</h2>
        <a href="{{ route('staff_team.inventory.create') }}" class="btn-primary">
            <i class="fas fa-plus mr-2"></i> New Request
        </a>
    </div>

    <!-- Pending Requests -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Pending Requests</h3>
        
        @forelse($pendingRequests as $request)
            <div class="p-4 border rounded-lg mb-3 hover:bg-gray-50">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-medium text-gray-800">
                            {{ $request->item->name }} (x{{ $request->quantity }})
                        </h4>
                        <p class="text-sm text-gray-500 mt-1">
                            Requested: {{ $request->created_at->format('M j, h:i A') }}
                            • Urgency: <span class="font-medium {{ $request->urgency === 'high' ? 'text-red-500' : ($request->urgency === 'medium' ? 'text-amber-500' : 'text-gray-500') }}">
                                {{ ucfirst($request->urgency) }}
                            </span>
                        </p>
                        @if($request->reason)
                            <p class="text-sm text-gray-600 mt-2">
                                <span class="font-medium">Reason:</span> {{ $request->reason }}
                            </p>
                        @endif
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">
                        Pending
                    </span>
                </div>
            </div>
        @empty
            <p class="text-gray-500">No pending inventory requests</p>
        @endforelse
    </div>

    <!-- Approved Requests -->
    @if($approvedRequests->isNotEmpty())
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Recently Approved</h3>
            <div class="space-y-3">
                @foreach($approvedRequests as $request)
                    <div class="p-3 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-800">
                                {{ $request->item->name }} (x{{ $request->quantity }})
                            </p>
                            <p class="text-sm text-gray-500">
                                Approved: {{ $request->updated_at->format('M j, h:i A') }}
                            </p>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                            Approved
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection