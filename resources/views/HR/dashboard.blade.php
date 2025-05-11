@extends('layouts.hr')

@section('title', 'HR Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="text-gray-600 mt-1">Here's today's HR overview for Blue Belle Resort.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    <i class="fas fa-user-tie mr-1"></i> Human Resources
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Employees Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Employees</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalEmployees }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm font-medium {{ $employeeChange >= 0 ? 'text-green-600' : 'text-red-600' }} flex items-center">
                    <i class="fas fa-arrow-{{ $employeeChange >= 0 ? 'up' : 'down' }} mr-1"></i> {{ abs($employeeChange) }}%
                </span>
                <span class="text-xs text-gray-500 ml-2">vs last month</span>
            </div>
        </div>

        <!-- On Leave Today Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">On Leave Today</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $onLeaveToday }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-amber-100 text-amber-600">
                    <i class="fas fa-calendar-minus text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm font-medium text-gray-600">
                    {{ $leaveRequestsPending }} pending requests
                </span>
            </div>
        </div>

        <!-- Late Arrivals Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Late Arrivals</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $lateArrivalsToday }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-red-100 text-red-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm font-medium {{ $lateArrivalChange >= 0 ? 'text-red-600' : 'text-green-600' }} flex items-center">
                    <i class="fas fa-arrow-{{ $lateArrivalChange >= 0 ? 'up' : 'down' }} mr-1"></i> {{ abs($lateArrivalChange) }}%
                </span>
                <span class="text-xs text-gray-500 ml-2">vs yesterday</span>
            </div>
        </div>

        <!-- Payroll Status -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Payroll Status</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">
                        @if($payrollProcessed)
                            <span class="text-green-600">Processed</span>
                        @else
                            <span class="text-amber-600">Pending</span>
                        @endif
                    </h3>
                </div>
                <div class="p-3 rounded-lg bg-green-100 text-green-600">
                    <i class="fas fa-money-bill-wave text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                @if($payrollProcessed)
                    <span class="text-sm font-medium text-green-600">
                        Completed on {{ $payrollProcessDate->format('M d') }}
                    </span>
                @else
                    <span class="text-sm font-medium text-amber-600">
                        Due in {{ $payrollDueDays }} days
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Activity & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800">Recent HR Activity</h3>
                <a href="{{ route('hr.activity') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All</a>
            </div>
            
            <div class="space-y-4">
                @forelse($recentActivities as $activity)
                <div class="flex items-start pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center 
                        @switch($activity->type)
                            @case('leave') bg-amber-100 text-amber-600 @break
                            @case('attendance') bg-blue-100 text-blue-600 @break
                            @case('payroll') bg-green-100 text-green-600 @break
                            @case('employee') bg-purple-100 text-purple-600 @break
                            @default bg-gray-100 text-gray-600
                        @endswitch">
                        @switch($activity->type)
                            @case('leave') <i class="fas fa-calendar-minus"></i> @break
                            @case('attendance') <i class="fas fa-user-clock"></i> @break
                            @case('payroll') <i class="fas fa-money-bill-wave"></i> @break
                            @case('employee') <i class="fas fa-user-plus"></i> @break
                            @default <i class="fas fa-info-circle"></i>
                        @endswitch
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900">{{ $activity->title }}</p>
                            <span class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">{{ $activity->description }}</p>
                        @if($activity->action_url)
                        <a href="{{ $activity->action_url }}" class="inline-block mt-2 text-xs font-medium text-blue-600 hover:text-blue-800">
                            View details
                        </a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-gray-500">
                    No recent activity found
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Quick Actions</h3>
            
            <div class="space-y-4">
                <a href="{{ route('hr.attendance.create') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    <div class="p-3 rounded-lg bg-white text-blue-600 shadow-sm mr-4">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">Record Attendance</h4>
                        <p class="text-sm text-gray-500">Manual time entry</p>
                    </div>
                </a>
                
                <a href="{{ route('hr.leave.create') }}" class="flex items-center p-4 bg-amber-50 rounded-lg hover:bg-amber-100 transition">
                    <div class="p-3 rounded-lg bg-white text-amber-600 shadow-sm mr-4">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">Process Leave</h4>
                        <p class="text-sm text-gray-500">Approve/reject requests</p>
                    </div>
                </a>
                
                <a href="{{ route('hr.payroll.run') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                    <div class="p-3 rounded-lg bg-white text-green-600 shadow-sm mr-4">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">Run Payroll</h4>
                        <p class="text-sm text-gray-500">Process salaries</p>
                    </div>
                </a>
                
                <a href="{{ route('hr.employees.create') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                    <div class="p-3 rounded-lg bg-white text-purple-600 shadow-sm mr-4">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-800">Add Employee</h4>
                        <p class="text-sm text-gray-500">New staff member</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Upcoming Events -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-800">Upcoming Events</h3>
            <a href="{{ route('hr.events.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View Calendar</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($upcomingEvents as $event)
            <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                <div class="flex items-start">
                    <div class="flex-shrink-0 p-2 rounded-lg 
                        @if($event->type === 'holiday') bg-red-100 text-red-600
                        @elseif($event->type === 'birthday') bg-purple-100 text-purple-600
                        @else bg-blue-100 text-blue-600 @endif">
                        <i class="fas 
                            @if($event->type === 'holiday') fa-umbrella-beach
                            @elseif($event->type === 'birthday') fa-birthday-cake
                            @else fa-calendar-alt @endif"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="font-medium text-gray-800">{{ $event->title }}</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            <i class="far fa-calendar-alt mr-1"></i>
                            {{ $event->date->format('M d, Y') }}
                            @if($event->time)
                                <span class="ml-2">
                                    <i class="far fa-clock mr-1"></i>
                                    {{ $event->time }}
                                </span>
                            @endif
                        </p>
                        @if($event->employee)
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-user mr-1"></i>
                            {{ $event->employee->name }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-4 text-gray-500">
                No upcoming events found
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection