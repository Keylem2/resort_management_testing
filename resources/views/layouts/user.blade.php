<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Dashboard') | Blue Belle Resort</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            transition: all 0.3s;
        }
        .active-menu {
            background-color: rgba(245, 158, 11, 0.1);
            border-left: 4px solid #f59e0b;
            color: #d97706;
        }
        /* Dropdown specific styles */
        #userMenu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 0.5rem;
            width: 12rem;
            background: white;
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            z-index: 1000;
        }
        /* Button styles */
        .btn {
            @apply px-4 py-2 rounded-md font-medium transition-colors duration-200;
        }
        .btn-amber {
            @apply bg-amber-600 text-white hover:bg-amber-700;
        }
        .btn-gray {
            @apply bg-gray-200 text-gray-700 hover:bg-gray-300;
        }
        .btn-blue {
            @apply bg-blue-600 text-white hover:bg-blue-700;
        }
        .btn-sm {
            @apply px-3 py-1 text-sm;
        }
        /* Form styles */
        .form-input, .form-select, .form-textarea {
            @apply block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500;
        }
        .form-input, .form-select {
            @apply h-10;
        }
        .form-textarea {
            @apply min-h-[80px];
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="sidebar w-64 bg-white shadow-md hidden md:block">
            <div class="p-4 border-b border-gray-200">
                <h1 class="text-xl font-bold text-gray-800 font-serif flex items-center">
                    <i class="fas fa-umbrella-beach text-[#f59e0b] mr-2"></i>
                    Blue Belle Resort
                </h1>
                <p class="text-xs text-gray-500 mt-1">Member Dashboard</p>
            </div>
            
            <nav class="p-4 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-amber-50 rounded-lg group {{ request()->routeIs('dashboard') ? 'active-menu' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3 text-gray-500 group-hover:text-[#f59e0b] {{ request()->routeIs('dashboard') ? 'text-[#f59e0b]' : '' }}"></i>
                    Dashboard
                </a>
                
                <!-- My Bookings -->
<a href="{{ route('booking.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-amber-50 rounded-lg group {{ request()->routeIs('booking.*') ? 'active-menu' : '' }}">
    <i class="fas fa-calendar-check mr-3 text-gray-500 group-hover:text-[#f59e0b] {{ request()->routeIs('booking.*') ? 'text-[#f59e0b]' : '' }}"></i>
    My Bookings
</a>

<!-- Pending Payments (Indented as Sub-Item) -->
@php
    $pendingCount = Auth::user()->bookings()->where('status', 'pending_approval')->count();
@endphp

@if($pendingCount > 0)
<a href="{{ route('user.payments.pending') }}" 
   class="flex items-center pl-8 py-2 text-gray-600 hover:bg-amber-50 rounded-lg group {{ request()->routeIs('user.payments.pending') ? 'active-menu' : '' }}">
    <i class="fas fa-wallet mr-2 text-gray-500 group-hover:text-[#f59e0b]"></i>
    Pending Payments ({{ $pendingCount }})
</a>
@endif


                <!-- Rooms -->
                <a href="{{ route('user.rooms.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-amber-50 rounded-lg group {{ request()->routeIs('user.rooms.index') ? 'active-menu' : '' }}">
    <i class="fas fa-bed mr-3 text-gray-500 group-hover:text-[#f59e0b] {{ request()->routeIs('user.rooms.index') ? 'text-[#f59e0b]' : '' }}"></i>
    Rooms
</a>
                
                <!-- Profile -->
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-amber-50 rounded-lg group {{ request()->routeIs('profile.edit') ? 'active-menu' : '' }}">
                    <i class="fas fa-user mr-3 text-gray-500 group-hover:text-[#f59e0b] {{ request()->routeIs('profile.edit') ? 'text-[#f59e0b]' : '' }}"></i>
                    My Profile
                </a>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between px-6 py-3">
                    <div class="flex items-center">
                        <button id="sidebarToggle" class="md:hidden text-gray-500 focus:outline-none mr-4">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h2 class="text-lg font-medium text-gray-800">@yield('title', 'Dashboard')</h2>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                            <i class="fas fa-bell"></i>
                        </button>
                        <div class="relative">
                            <button id="userMenuButton" class="flex items-center focus:outline-none">
                                <span class="w-8 h-8 bg-[#f59e0b] rounded-full flex items-center justify-center text-white font-medium">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                                <span class="ml-2 text-gray-700 hidden md:inline">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down ml-1 text-gray-500 text-xs"></i>
                            </button>
                            
                            <!-- User Dropdown Menu -->
                            <div id="userMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                                <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-100">
                                    Signed in as <span class="font-medium">{{ auth()->user()->name }}</span>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600">
                                    <i class="fas fa-user mr-2"></i> Profile
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600">
                                    <i class="fas fa-cog mr-2"></i> Settings
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50 pb-20">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                
                <!-- Error Message -->
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('hidden');
                });
            }

            // Dropdown functionality
            const userMenuButton = document.getElementById('userMenuButton');
            const userMenu = document.getElementById('userMenu');
            
            if (userMenuButton && userMenu) {
                const chevron = userMenuButton.querySelector('.fa-chevron-down');

                // Initialize dropdown as hidden
                userMenu.style.display = 'none';

                // Toggle dropdown on button click
                userMenuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isOpen = userMenu.style.display === 'block';
                    userMenu.style.display = isOpen ? 'none' : 'block';
                    if (chevron) {
                        chevron.style.transform = isOpen ? '' : 'rotate(180deg)';
                    }
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (e.target !== userMenuButton && !userMenu.contains(e.target)) {
                        userMenu.style.display = 'none';
                        if (chevron) {
                            chevron.style.transform = '';
                        }
                    }
                });

                // Prevent dropdown from closing when clicking inside it
                userMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>