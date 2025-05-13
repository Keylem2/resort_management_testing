@extends('layouts.staff_team')

@section('title', ucfirst(auth()->user()->usertype) . ' Dashboard | Blue Belle Resort')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Welcome, {{ Auth::user()->name }}!</h2>
                <p class="text-gray-600 mt-1">
                    @if(auth()->user()->usertype === 'lifeguard')
                        Today's pool schedule and safety checks
                    @else
                        Today's cleaning assignments and tasks
                    @endif
                </p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    <i class="fas {{ auth()->user()->usertype === 'lifeguard' ? 'fa-swimming-pool' : 'fa-broom' }} mr-1"></i> 
                    {{ ucfirst(auth()->user()->usertype) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Today's Tasks -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Today's Tasks</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $todaysTasks ?? 0 }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                    <i class="fas fa-tasks text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm font-medium {{ ($tasksCompletedPercent ?? 0) >= 80 ? 'text-green-600' : (($tasksCompletedPercent ?? 0) >= 50 ? 'text-amber-600' : 'text-red-600') }}">
                    {{ $tasksCompletedPercent ?? 0 }}% completed
                </span>
            </div>
        </div>

        <!-- Current Shift -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Current Shift</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">
                        {{ $currentShift['name'] ?? 'None' }}
                    </h3>
                    @if(isset($currentShift['time']))
                        <p class="text-sm text-gray-600 mt-1">{{ $currentShift['time'] }}</p>
                    @endif
                </div>
                <div class="p-3 rounded-lg bg-green-100 text-green-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Inventory Status -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Inventory Requests</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $pendingInventoryRequests ?? 0 }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                    <i class="fas fa-box-open text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm font-medium text-gray-600">
                    {{ $approvedInventoryRequests ?? 0 }} approved
                </span>
            </div>
        </div>
    </div>

    <!-- Recent Announcements -->
    @if(isset($recentAnnouncements) && $recentAnnouncements->isNotEmpty())
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mt-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Announcements</h3>
            
            <div class="space-y-4">
                @foreach($recentAnnouncements as $announcement)
                    <div class="p-4 border border-gray-100 rounded-lg hover:bg-gray-50">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-medium text-gray-900">{{ $announcement->title }}</h4>
                                <p class="text-sm text-gray-500 mt-1">{{ $announcement->created_at->diffForHumans() }}</p>
                            </div>
                            @if($announcement->is_new ?? false)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                    New
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 mt-2">{{ Str::limit($announcement->content, 120) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection