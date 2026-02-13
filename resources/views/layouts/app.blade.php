<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'OJTracker') }} - @yield('title', 'Dashboard')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/ojtracker_logo.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        
        /* Loading Screen Styles */
        #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
        }
        
        #loading-screen.hidden {
            opacity: 0;
            visibility: hidden;
        }
        
        .loading-logo {
            width: 120px;
            height: 120px;
            margin-bottom: 20px;
            animation: pulse 2s ease-in-out infinite;
        }
        
        .loading-spinner {
            width: 140px;
            height: 140px;
            border: 6px solid rgba(255, 255, 255, 0.2);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }
    </style>
</head>
<body class="antialiased bg-gray-50">
    <!-- Loading Screen -->
    <div id="loading-screen">
        <div class="loading-spinner">
            <img src="{{ asset('assets/images/ojtracker_logo.png') }}" alt="Loading..." class="loading-logo">
        </div>
    </div>
    
    <div class="min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-br from-indigo-600 via-purple-600 to-blue-700 transform transition-transform duration-300 ease-in-out lg:translate-x-0 -translate-x-full">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-between h-16 px-6 border-b border-white/20">
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <img src="{{ asset('assets/images/ojtracker_logo.png') }}" alt="OJTracker" class="h-8 sm:h-10">
                        <span class="text-lg sm:text-xl font-bold text-white">OJTracker</span>
                    </div>
                    <button onclick="toggleSidebar()" class="lg:hidden text-white hover:bg-white/10 p-2 rounded-lg transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="truncate">Dashboard</span>
                    </a>

                    <a href="{{ route('dtr.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition {{ request()->routeIs('dtr.*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="truncate">Daily Time Record</span>
                    </a>

                    <a href="{{ route('accomplishments.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition {{ request()->routeIs('accomplishments.*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        <span class="truncate">Accomplishments</span>
                    </a>

                    <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition {{ request()->routeIs('reports.*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="truncate">Reports</span>
                    </a>

                    <a href="{{ route('profile.index') }}" class="flex items-center px-4 py-3 text-white rounded-lg transition {{ request()->routeIs('profile.*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="truncate">Profile</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-black/50 lg:hidden hidden" onclick="toggleSidebar()"></div>

        <!-- Main Content -->
        <div class="lg:ml-64">
            <!-- Top Navigation Bar -->
            <header class="sticky top-0 z-30 bg-white border-b border-gray-200 shadow-sm">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <!-- Left: Mobile Menu Button & Page Title -->
                    <div class="flex items-center space-x-3">
                        <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-gray-700 p-2 rounded-lg transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <h1 class="text-lg sm:text-xl font-bold text-gray-900 truncate max-w-[150px] sm:max-w-none">@yield('page-title', 'Dashboard')</h1>
                    </div>

                    <!-- Center: Live Date & Time -->
                    <div class="hidden lg:flex items-center text-gray-700">
                        <span id="live-datetime" class="text-sm font-medium italic"></span>
                    </div>

                    <!-- Right Side Actions -->
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <!-- Notifications -->
                        <div class="relative" x-data="{ open: false, notifications: [], unreadCount: 0 }" x-init="
                            // Fetch notifications on load
                            fetch('{{ route('notifications.index') }}')
                                .then(res => res.json())
                                .then(data => {
                                    notifications = data.notifications;
                                    unreadCount = data.unread_count;
                                });
                            
                            // Refresh every 60 seconds
                            setInterval(() => {
                                fetch('{{ route('notifications.index') }}')
                                    .then(res => res.json())
                                    .then(data => {
                                        notifications = data.notifications;
                                        unreadCount = data.unread_count;
                                    });
                            }, 60000);
                        ">
                            <button @click="open = !open" class="relative text-gray-500 hover:text-gray-700 transition p-2 rounded-lg hover:bg-gray-100">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <!-- Unread Badge -->
                                <span x-show="unreadCount > 0" x-text="unreadCount > 9 ? '9+' : unreadCount" 
                                      class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                                </span>
                            </button>

                            <!-- Notifications Dropdown -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition
                                 class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-lg shadow-lg border border-gray-200 z-50 max-h-[500px] overflow-hidden flex flex-col"
                                 style="display: none;">
                                
                                <!-- Header -->
                                <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                    <h3 class="font-semibold text-gray-900">Notifications</h3>
                                    <button @click="
                                        fetch('{{ route('notifications.read-all') }}', { 
                                            method: 'POST',
                                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                        }).then(() => {
                                            notifications.forEach(n => n.is_read = true);
                                            unreadCount = 0;
                                        });
                                    " class="text-xs text-indigo-600 hover:text-indigo-800">
                                        Mark all read
                                    </button>
                                </div>

                                <!-- Notifications List -->
                                <div class="overflow-y-auto flex-1">
                                    <template x-if="notifications.length === 0">
                                        <div class="py-12 text-center">
                                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                            </svg>
                                            <p class="text-gray-500 text-sm">No notifications yet</p>
                                        </div>
                                    </template>

                                    <template x-for="notification in notifications" :key="notification.id">
                                        <div :class="notification.is_read ? 'bg-white' : 'bg-indigo-50'" 
                                             class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 transition cursor-pointer"
                                             @click="
                                                if (!notification.is_read) {
                                                    fetch(`/notifications/${notification.id}/read`, { 
                                                        method: 'POST',
                                                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                                    });
                                                    notification.is_read = true;
                                                    unreadCount--;
                                                }
                                                if (notification.link) window.location.href = notification.link;
                                             ">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 text-2xl mr-3" x-text="notification.icon || '🔔'"></div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold text-gray-900" x-text="notification.title"></p>
                                                    <p class="text-xs text-gray-600 mt-1" x-text="notification.message"></p>
                                                    <p class="text-xs text-gray-400 mt-1" x-text="new Date(notification.created_at).toLocaleString()"></p>
                                                </div>
                                                <button @click.stop="
                                                    fetch(`/notifications/${notification.id}`, { 
                                                        method: 'DELETE',
                                                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                                                    }).then(() => {
                                                        notifications = notifications.filter(n => n.id !== notification.id);
                                                        if (!notification.is_read) unreadCount--;
                                                    });
                                                " class="text-gray-400 hover:text-red-500 ml-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- User Profile Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 sm:space-x-3 focus:outline-none hover:bg-gray-100 px-2 sm:px-3 py-2 rounded-lg transition-colors duration-200 cursor-pointer">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-white font-bold text-sm sm:text-base overflow-hidden border-2 border-white shadow-md">
                                    @if(auth()->user()->profile_picture)
                                        <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                    @else
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    @endif
                                </div>
                                <div class="text-left hidden md:block">
                                    <p class="text-sm font-semibold text-gray-900 truncate max-w-[120px]">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate max-w-[120px]">{{ auth()->user()->email }}</p>
                                </div>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-200"
                                 style="display: none;">
                                
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                </div>

                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 sm:p-6 lg:p-8">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-green-800 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Error Message -->
                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-red-800 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Update live date and time
        function updateDateTime() {
            const now = new Date();
            const dayName = now.toLocaleDateString('en-US', { weekday: 'long' });
            const dateOptions = { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric'
            };
            const dateString = now.toLocaleDateString('en-US', dateOptions);
            const timeString = now.toLocaleTimeString('en-US', { 
                hour: 'numeric', 
                minute: '2-digit',
                second: '2-digit',
                hour12: true 
            });
            
            const dateTimeElement = document.getElementById('live-datetime');
            if (dateTimeElement) {
                dateTimeElement.textContent = `${dayName}, ${dateString} ${timeString}`;
            }
        }

        // Update immediately and then every second
        updateDateTime();
        setInterval(updateDateTime, 1000);

        // Close sidebar when clicking outside on mobile
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                document.getElementById('sidebar-overlay').classList.add('hidden');
            }
        });

        // Loading Screen Handler
        const loadingScreen = document.getElementById('loading-screen');
        
        // Hide loading screen when page is fully loaded
        window.addEventListener('load', function() {
            setTimeout(() => {
                loadingScreen.classList.add('hidden');
            }, 500); // Small delay for smooth transition
        });
        
        // Show loading screen on navigation (clicking links)
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link && link.href && !link.target && !link.href.startsWith('#') && !link.href.includes('javascript:')) {
                const isSameDomain = link.hostname === window.location.hostname;
                if (isSameDomain) {
                    loadingScreen.classList.remove('hidden');
                }
            }
        });
        
        // Show loading screen on form submission
        document.addEventListener('submit', function(e) {
            loadingScreen.classList.remove('hidden');
        });
        
        // Hide loading screen if navigation is cancelled (back button, etc)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                loadingScreen.classList.add('hidden');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
