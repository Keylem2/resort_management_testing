<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Dashboard | Blue Belle Resort</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            background-color: rgba(16, 185, 129, 0.1);
            border-left: 4px solid #10b981;
            color: #047857;
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
        .btn-green {
            @apply bg-green-600 text-white hover:bg-green-700;
        }
        .btn-red {
            @apply bg-red-600 text-white hover:bg-red-700;
        }
        .btn-gray {
            @apply bg-gray-200 text-gray-700 hover:bg-gray-300;
        }
        .btn-sm {
            @apply px-3 py-1 text-sm;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    @if(auth()->check() && auth()->user()->isFinance())
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="sidebar w-64 bg-white shadow-md hidden md:block">
            <div class="p-4 border-b border-gray-200">
                <h1 class="text-xl font-bold text-gray-800 font-serif flex items-center">
                    <i class="fas fa-umbrella-beach text-green-500 mr-2"></i>
                    Blue Belle Resort
                </h1>
                <p class="text-xs text-gray-500 mt-1">Finance Dashboard</p>
            </div>

            <nav class="p-4 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('finance.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 rounded-lg group {{ request()->routeIs('finance.dashboard') ? 'active-menu' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3 text-gray-500 group-hover:text-green-500 {{ request()->routeIs('finance.dashboard') ? 'text-green-500' : '' }}"></i>
                    Dashboard
                </a>

                <!-- Pending Bookings -->
                <a href="{{ route('finance.bookings.pending') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 rounded-lg group {{ request()->routeIs('finance.bookings.pending') ? 'active-menu' : '' }}">
                    <i class="fas fa-calendar-check mr-3 text-gray-500 group-hover:text-green-500 {{ request()->routeIs('finance.bookings.pending') ? 'text-green-500' : '' }}"></i>
                    Booking Approvals
                    @php
                        $pendingCount = App\Models\Booking::where('status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="ml-auto bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded-full">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>

                <!-- Inventory Requests -->
                <a href="{{ route('finance.inventory-requests.index')}}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 rounded-lg group {{ request()->routeIs('finance.inventory.*') ? 'active-menu' : '' }}">
                    <i class="fas fa-boxes mr-3 text-gray-500 group-hover:text-green-500 {{ request()->routeIs('finance.inventory.*') ? 'text-green-500' : '' }}"></i>
                    Inventory Requests
                    @php
                        $pendingRequests = App\Models\InventoryRequest::where('status', 'pending')->count();
                    @endphp
                    @if($pendingRequests > 0)
                        <span class="ml-auto bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded-full">
                            {{ $pendingRequests }}
                        </span>
                    @endif
                </a>

                <!-- Reports -->
                <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-green-50 rounded-lg group">
                    <i class="fas fa-chart-bar mr-3 text-gray-500 group-hover:text-green-500"></i>
                    Financial Reports
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
                            @php
                                $totalPending = $pendingCount + $pendingRequests;
                            @endphp
                            @if($totalPending > 0)
                                <span class="absolute top-2 right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                    {{ $totalPending }}
                                </span>
                            @endif
                        </button>
                        <div class="relative">
                            <button id="userMenuButton" class="flex items-center focus:outline-none">
                                <span class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white font-medium">
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
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600">
                                    <i class="fas fa-user mr-2"></i> Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-600">
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
                <a href="{{ route('home') }}" class="inline-block px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    Return to Home
                </a>
            </div>
        </div>
    @endif
    @stack('scripts')
</body>
</html>