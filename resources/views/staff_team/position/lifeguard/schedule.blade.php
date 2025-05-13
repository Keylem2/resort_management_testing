@extends('layouts.staff_team')

@section('title', 'Pool Schedule | Blue Belle Resort')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-800">Pool Schedule</h2>

    <!-- Current Shift -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Current Shift</h3>
        
        @if($currentShift)
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="font-medium text-blue-800">{{ $currentShift['name'] }}</h4>
                        <p class="text-sm text-blue-600 mt-1">{{ $currentShift['time'] }}</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                        Active Now
                    </span>
                </div>
            </div>
        @else
            <p class="text-gray-500">No active shift at this time</p>
        @endif
    </div>

    <!-- Weekly Schedule -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">This Week's Schedule</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Day</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shift</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($weeklySchedule as $shift)
                        <tr class="{{ $shift->date->isToday() ? 'bg-blue-50' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $shift->date->format('l') }}
                                @if($shift->date->isToday())
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        Today
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                {{ $shift->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                {{ $shift->start_time }} - {{ $shift->end_time }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                No shifts scheduled this week
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection