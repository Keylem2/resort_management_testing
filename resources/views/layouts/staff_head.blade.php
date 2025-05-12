<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Head Dashboard | Blue Belle Resort</title>
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
            background-color: rgba(59, 130, 246, 0.1);
            border-left: 4px solid #3b82f6;
            color: #1d4ed8;
        }
        .submenu {
            display: none;
            padding-left: 1.5rem;
            margin-top: 0.25rem;
        }
        .submenu.active {
            display: block;
        }
        .has-submenu::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            margin-left: auto;
            font-size: 0.75rem;
            transition: transform 0.3s;
        }
        .has-submenu.open::after {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="bg-gray-50">
@if(auth()->check() && auth()->user()->usertype === 'staff_head')
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="sidebar w-64 bg-white shadow-md hidden md:block">
            <div class="p-4 border-b border-gray-200">
                <h1 class="text-xl font-bold text-gray-800 font-serif flex items-center">
                    <i class="fas fa-users-cog text-blue-500 mr-2"></i>
                    Blue Belle Resort
                </h1>
                <p class="text-xs text-gray-500 mt-1">Staff Head Dashboard</p>
            </div>

            <nav class="p-4 space-y-1">
                <a href="{{ route('staff_head.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg group {{ request()->routeIs('staff_head.dashboard') ? 'active-menu' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3 text-gray-500 group-hover:text-blue-500 {{ request()->routeIs('staff_head.dashboard') ? 'text-blue-500' : '' }}"></i>
                    Dashboard
                </a>
                <a href="{{ route('staff_head.team.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg group {{ request()->routeIs('staff_head.team.*') ? 'active-menu' : '' }}">
                    <i class="fas fa-users mr-3 text-gray-500 group-hover:text-blue-500 {{ request()->routeIs('staff_head.team.*') ? 'text-blue-500' : '' }}"></i>
                    Team Management
                </a>
                <a href="{{ route('staff_head.attendance.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg group {{ request()->routeIs('staff_head.attendance.*') ? 'active-menu' : '' }}">
                    <i class="fas fa-user-clock mr-3 text-gray-500 group-hover:text-blue-500 {{ request()->routeIs('staff_head.attendance.*') ? 'text-blue-500' : '' }}"></i>
                    Attendance
                </a>
                <a href="{{ route('staff_head.leave.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg group {{ request()->routeIs('staff_head.leave.*') ? 'active-menu' : '' }}">
                    <i class="fas fa-calendar-check mr-3 text-gray-500 group-hover:text-blue-500 {{ request()->routeIs('staff_head.leave.*') ? 'text-blue-500' : '' }}"></i>
                    Leave Approvals
                </a>
                <a href="{{ route('staff_head.announcements.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg group {{ request()->routeIs('staff_head.announcements.*') ? 'active-menu' : '' }}">
                    <i class="fas fa-bullhorn mr-3 text-gray-500 group-hover:text-blue-500 {{ request()->routeIs('staff_head.announcements.*') ? 'text-blue-500' : '' }}"></i>
                    Announcements
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm z-10 relative">
                <div class="flex items-center justify-between px-6 py-3">
                    <div class="flex items-center">
                        <button id="sidebarToggle" class="md:hidden text-gray-500 focus:outline-none mr-4">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h2 class="text-lg font-medium text-gray-800">@yield('title', 'Dashboard')</h2>
                    </div>

                    <div class="flex items-center space-x-4 relative">
                        <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-1.5 right-1.5 h-2 w-2 rounded-full bg-red-500"></span>
                        </button>

                        <!-- User Dropdown -->
                        <div class="relative">
                            <button id="userMenuButton" class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none">
                                <i class="fas fa-user-circle text-xl mr-2"></i>
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down ml-1 text-xs"></i>
                            </button>

                            <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
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

    <!-- Scripts -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('hidden');
        });

        const userMenuBtn = document.getElementById('userMenuButton');
        const userMenu = document.getElementById('userMenu');

        userMenuBtn.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!userMenu.contains(e.target) && !userMenuBtn.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
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
