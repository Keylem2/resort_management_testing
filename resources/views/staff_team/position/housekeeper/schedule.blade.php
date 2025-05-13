@extends('layouts.staff_team')

@section('title', 'Cleaning Schedule | Blue Belle Resort')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-800">Cleaning Schedule</h2>

    <!-- Current Assignment -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Current Assignment</h3>
        
        @if($currentAssignment)
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="font-medium text-blue-800">{{ $currentAssignment->area_name }}</h4>
                        <p class="text-sm text-blue-600 mt-1">
                            {{ $currentAssignment->start_time->format('h:i A') }} - 
                            {{ $currentAssignment->end_time->format('h:i A') }}
                        </p>
                        <p class="text-sm text-gray-600 mt-2">
                            <span class="font-medium">Tasks:</span> {{ $currentAssignment->tasks }}
                        </p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                        In Progress
                    </span>
                </div>
            </div>
            
            <div class="mt-4">
                <button class="btn-primary">
                    <i class="fas fa-check-circle mr-2"></i> Mark as Completed
                </button>
            </div>
        @else
            <p class="text-gray-500">No current cleaning assignment</p>
        @endif
    </div>

    <!-- Weekly Cleaning Schedule -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">This Week's Schedule</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Area</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($cleaningSchedule as $assignment)
                        <tr class="{{ $assignment->date->isToday() ? 'bg-blue-50' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $assignment->date->format('D, M j') }}
                                @if($assignment->date->isToday())
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        Today
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                {{ $assignment->area_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                {{ $assignment->start_time->format('h:i A') }} - {{ $assignment->end_time->format('h:i A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($assignment->completed_at)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                @elseif($assignment->date->isPast())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                        Missed
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">
                                        Pending
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                No cleaning assignments scheduled this week
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Cleaning Supplies -->
    @if($cleaningSupplies->isNotEmpty())
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Assigned Cleaning Supplies</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($cleaningSupplies as $supply)
                    <div class="p-4 border rounded-lg hover:bg-gray-50">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $supply->name }}</h4>
                                <p class="text-sm text-gray-500 mt-1">
                                    Quantity: {{ $supply->pivot->quantity_assigned }}
                                </p>
                            </div>
                            @if($supply->isLowStock())
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                    Low Stock
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 mt-2">
                            {{ $supply->description }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection