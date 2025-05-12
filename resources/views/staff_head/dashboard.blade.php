@extends('layouts.staff_head')

@section('title', 'Staff Head Dashboard | Blue Belle Resort')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="text-gray-600 mt-1">Here's today's team overview for Blue Belle Resort.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    <i class="fas fa-user-cog mr-1"></i> Staff Head
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Team Members -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Team Members</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalTeamMembers }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm font-medium {{ $teamChange >= 0 ? 'text-green-600' : 'text-red-600' }} flex items-center">
                    <i class="fas fa-arrow-{{ $teamChange >= 0 ? 'up' : 'down' }} mr-1"></i> {{ abs($teamChange) }}%
                </span>
                <span class="text-xs text-gray-500 ml-2">vs last month</span>
            </div>
        </div>

        <!-- On Leave Today -->
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
                    {{ $pendingLeaveRequests }} pending requests
                </span>
            </div>
        </div>

        <!-- Attendance Today -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Present Today</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $presentToday }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-green-100 text-green-600">
                    <i class="fas fa-user-check text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm font-medium {{ $attendanceChange >= 0 ? 'text-green-600' : 'text-red-600' }} flex items-center">
                    <i class="fas fa-arrow-{{ $attendanceChange >= 0 ? 'up' : 'down' }} mr-1"></i> {{ abs($attendanceChange) }}%
                </span>
                <span class="text-xs text-gray-500 ml-2">vs yesterday</span>
            </div>
        </div>

        <!-- Announcements -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Announcements</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalAnnouncements }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                    <i class="fas fa-bullhorn text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm font-medium text-gray-600">
                    {{ $recentAnnouncements }} new this week
                </span>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mt-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Team Activity</h3>

        <ul class="space-y-4">
            @forelse($recentActivities as $activity)
                <li class="flex items-start">
                    <div class="flex-shrink-0 p-3 rounded-lg bg-gray-100 text-gray-600 mr-4">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $activity->title }}</p>
                        <p class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $activity->description }}</p>
                    </div>
                </li>
            @empty
                <li class="text-center text-gray-500">No recent activity found.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
