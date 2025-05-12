<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Staff Dashboard') | Blue Belle Resort</title>
    @vite(['resources/css/app.css'])
    @include('layouts.partials.head') <!-- Create this partial for shared head content -->
</head>
<body class="bg-gray-50">
@if(auth()->check() && in_array(auth()->user()->usertype, ['housekeeper', 'lifeguard']))
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="sidebar w-64 bg-white shadow-md hidden md:block">
            <div class="p-4 border-b border-gray-200">
                <h1 class="text-xl font-bold text-gray-800 font-serif flex items-center">
                    <i class="fas {{ auth()->user()->usertype === 'lifeguard' ? 'fa-swimming-pool' : 'fa-broom' }} text-blue-500 mr-2"></i>
                    Blue Belle Resort
                </h1>
                <p class="text-xs text-gray-500 mt-1">{{ ucfirst(auth()->user()->usertype) }} Dashboard</p>
            </div>

            <nav class="p-4 space-y-1">
                <a href="{{ route('staff_team.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg group {{ request()->routeIs('staff_team.dashboard') ? 'active-menu' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3 text-gray-500 group-hover:text-blue-500 {{ request()->routeIs('staff_team.dashboard') ? 'text-blue-500' : '' }}"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('staff_team.attendance.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg group {{ request()->routeIs('staff_team.attendance.*') ? 'active-menu' : '' }}">
                    <i class="fas fa-user-clock mr-3 text-gray-500 group-hover:text-blue-500 {{ request()->routeIs('staff_team.attendance.*') ? 'text-blue-500' : '' }}"></i>
                    My Attendance
                </a>
                
                <a href="{{ route('staff_team.tasks.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg group {{ request()->routeIs('staff_team.tasks.*') ? 'active-menu' : '' }}">
                    <i class="fas fa-tasks mr-3 text-gray-500 group-hover:text-blue-500 {{ request()->routeIs('staff_team.tasks.*') ? 'text-blue-500' : '' }}"></i>
                    My Tasks
                </a>
                
                <a href="{{ route('staff_team.inventory.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg group {{ request()->routeIs('staff_team.inventory.*') ? 'active-menu' : '' }}">
                    <i class="fas fa-boxes mr-3 text-gray-500 group-hover:text-blue-500 {{ request()->routeIs('staff_team.inventory.*') ? 'text-blue-500' : '' }}"></i>
                    Inventory Requests
                </a>
                
                <a href="{{ route('staff_team.announcements.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg group {{ request()->routeIs('staff_team.announcements.*') ? 'active-menu' : '' }}">
                    <i class="fas fa-bullhorn mr-3 text-gray-500 group-hover:text-blue-500 {{ request()->routeIs('staff_team.announcements.*') ? 'text-blue-500' : '' }}"></i>
                    Announcements
                </a>
            </nav>
        </div>

        <!-- Main Content (same as your staff_head layout) -->
        @include('layouts.partials.staff_content') <!-- Extract the common content structure -->
    </div>
@else
    @include('layouts.partials.access_denied')
@endif
</body>
</html>