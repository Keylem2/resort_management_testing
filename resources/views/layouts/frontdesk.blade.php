<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Front Desk Dashboard | Blue Belle Resort</title>
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
            background-color: rgba(59, 130, 246, 0.1);
            border-left: 4px solid #3b82f6;
            color: #1d4ed8;
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
    </style>
</head>
<body class="bg-gray-50">
    @if(auth()->check() && auth()->user()->usertype === 'front_desk')
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
<div class="sidebar w-64 bg-white shadow-md hidden md:block">
    <div class="p-4 border-b border-gray-200">
        <h1 class="text-xl font-bold text-gray-800 font-serif flex items-center">
            <i class="fas fa-umbrella-beach text-blue-500 mr-2"></i>
            Blue Belle Resort
        </h1>
        <p class="text-xs text-gray-500 mt-1">Front Desk Dashboard</p>
    </div>

    <nav class="p-4 space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('frontdesk.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg group {{ request()->routeIs('frontdesk.dashboard') ? 'active-menu' : '' }}">
            <i class="fas fa-tachometer-alt mr-3 text-gray-500 group-hover:text-blue-500 {{ request()->routeIs('frontdesk.dashboard') ? 'text-blue-500' : '' }}"></i>
            Dashboard
        </a>

        <!-- Bookings -->
        <a href="{{ route('frontdesk.bookings.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg group {{ request()->routeIs('frontdesk.bookings.index') && !request()->query('status') ? 'active-menu' : '' }}">
            <i class="fas fa-calendar-check mr-3 text-gray-500 group-hover:text-blue-500 {{ request()->routeIs('frontdesk.bookings.index') && !request()->query('status') ? 'text-blue-500' : '' }}"></i>
            Bookings
        </a>

        <!-- Rooms -->
        <a href="{{ route('frontdesk.rooms.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg group {{ request()->routeIs('frontdesk.rooms.index') ? 'active-menu' : '' }}">
            <i class="fas fa-bed mr-3 text-gray-500 group-hover:text-blue-500 {{ request()->routeIs('frontdesk.rooms.index') ? 'text-blue-500' : '' }}"></i>
            Rooms
        </a>
        
        <!-- Guests -->
        <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg group">
            <i class="fas fa-users mr-3 text-gray-500 group-hover:text-blue-500"></i>
            Guests
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
                                <span class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-medium">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span class="ml-2 text-gray-700 hidden md:inline">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down ml-1 text-gray-500 text-xs"></i>
                            </button>
                            
                            <!-- User Dropdown Menu -->
                            <div id="userMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                                <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-100">
                                    Signed in as <span class="font-medium">{{ Auth::user()->name }}</span>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                    <i class="fas fa-user mr-2"></i> Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
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
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar toggle
            document.getElementById('sidebarToggle').addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('hidden');
            });

            // Dropdown functionality
            const userMenuButton = document.getElementById('userMenuButton');
            const userMenu = document.getElementById('userMenu');
            const chevron = userMenuButton.querySelector('.fa-chevron-down');

            // Initialize dropdown as hidden
            userMenu.style.display = 'none';

            // Toggle dropdown on button click
            userMenuButton.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = userMenu.style.display === 'block';
                userMenu.style.display = isOpen ? 'none' : 'block';
                chevron.style.transform = isOpen ? '' : 'rotate(180deg)';
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (e.target !== userMenuButton && !userMenu.contains(e.target)) {
                    userMenu.style.display = 'none';
                    chevron.style.transform = '';
                }
            });

            // Prevent dropdown from closing when clicking inside it
            userMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
    @else
        <div class="flex items-center justify-center h-screen bg-gray-100">
            <div class="text-center p-8 bg-white rounded-lg shadow-md max-w-md">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Access Denied</h1>
                <p class="text-gray-600 mb-6">You don't have permission to access this page.</p>
                <a href="{{ route('home') }}" class="inline-block px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Return to Home
                </a>
            </div>
        </div>
    @endif
</body>
</html>