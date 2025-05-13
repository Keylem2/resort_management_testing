@extends('layouts.staff_team')

@section('title', 'My Attendance | Blue Belle Resort')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Today's Attendance</h2>
        
        @if($today)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 border rounded-lg {{ $today->check_in ? 'bg-green-50 border-green-200' : 'bg-amber-50 border-amber-200' }}">
                    <p class="text-sm font-medium text-gray-500">Check In</p>
                    <p class="text-lg font-semibold mt-1">
                        {{ $today->check_in ? $today->check_in->format('h:i A') : 'Not checked in' }}
                    </p>
                    @if($today->late)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 mt-2">
                            Late Arrival
                        </span>
                    @endif
                </div>
                
                <div class="p-4 border rounded-lg {{ $today->check_out ? 'bg-green-50 border-green-200' : 'bg-amber-50 border-amber-200' }}">
                    <p class="text-sm font-medium text-gray-500">Check Out</p>
                    <p class="text-lg font-semibold mt-1">
                        {{ $today->check_out ? $today->check_out->format('h:i A') : 'Not checked out' }}
                    </p>
                </div>
            </div>
            
            <div class="mt-4 flex space-x-4">
                @unless($today->check_in)
                    <form method="POST" action="{{ route('staff_team.attendance.check_in') }}">
                        @csrf
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-sign-in-alt mr-2"></i> Check In
                        </button>
                    </form>
                @endunless
                
                @if($today->check_in && !$today->check_out)
                    <form method="POST" action="{{ route('staff_team.attendance.check_out') }}">
                        @csrf
                        <button type="submit" class="btn-secondary">
                            <i class="fas fa-sign-out-alt mr-2"></i> Check Out
                        </button>
                    </form>
                @endif
            </div>
        @else
            <form method="POST" action="{{ route('staff_team.attendance.check_in') }}">
                @csrf
                <button type="submit" class="btn-primary">
                    <i class="fas fa-sign-in-alt mr-2"></i> Check In Now
                </button>
            </form>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Monthly Summary -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Monthly Summary</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Days Present</span>
                    <span class="font-medium">{{ $monthSummary['present'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Late Arrivals</span>
                    <span class="font-medium">{{ $monthSummary['late'] }}</span>
                </div>
            </div>
        </div>

        <!-- Recent Records -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Records</h3>
            <div class="space-y-3">
                @forelse($recent as $record)
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <div>
                            <p class="font-medium">{{ $record->date->format('D, M j') }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $record->check_in->format('h:i A') }} - 
                                {{ $record->check_out ? $record->check_out->format('h:i A') : '--:--' }}
                            </p>
                        </div>
                        @if($record->late)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                Late
                            </span>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">No attendance records found</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection