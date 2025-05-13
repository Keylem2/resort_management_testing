<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Staff Dashboard') | Blue Belle Resort</title>
    @vite(['resources/css/app.css'])
    @include('layouts.partials.head')
</head>
<body class="bg-gray-50">
@if(auth()->check() && in_array(auth()->user()->usertype, ['housekeeper', 'lifeguard']))
    @if(auth()->user()->employee)
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
                    
                    <!-- Rest of your sidebar navigation -->
                </nav>
            </div>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50 pb-20">
                @yield('content')
            </main>
        </div>
    @else
        <div class="flex items-center justify-center h-screen bg-gray-100">
            <div class="text-center p-8 bg-white rounded-lg shadow-md max-w-md">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Employee Record Missing</h1>
                <p class="text-gray-600 mb-6">Your user account is not linked to an employee record.</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-block px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    @endif
@else
    @include('layouts.partials.access_denied')
@endif
</body>
</html>