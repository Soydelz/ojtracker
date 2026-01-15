<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>OJTracker - Track Your OJT Hours Easily & Professionally</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('assets/images/ojtracker_logo.png') }}">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        
        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
            
            /* Grid Pattern Background */
            .bg-grid-pattern {
                background-image: 
                    linear-gradient(to right, #e0e7ff 1px, transparent 1px),
                    linear-gradient(to bottom, #e0e7ff 1px, transparent 1px);
                background-size: 40px 40px;
            }
            
            /* Blob Animation */
            @keyframes blob {
                0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
                100% { transform: translate(0px, 0px) scale(1); }
            }
            
            .animate-blob {
                animation: blob 7s infinite;
            }
            
            .animation-delay-2000 {
                animation-delay: 2s;
            }
            
            .animation-delay-4000 {
                animation-delay: 4s;
            }
        </style>
    </head>
    <body class="antialiased bg-gradient-to-br from-blue-50 via-white to-indigo-50">
        
        <!-- Navigation Bar -->
        <nav class="fixed w-full bg-white/90 backdrop-blur-md z-50 shadow-sm border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo & Brand -->
                    <a href="#top" onclick="event.preventDefault(); window.scrollTo({top: 0, behavior: 'smooth'});" class="flex items-center space-x-3 cursor-pointer">
                        <img src="{{ asset('assets/images/ojtracker_logo.png') }}" alt="OJTracker Logo" class="h-10 sm:h-12">
                    </a>
                    
                    <!-- Auth Links -->
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-indigo-600 font-medium transition duration-200 text-sm sm:text-base">
                                    Dashboard
                                </a>
                            @else
                                <button onclick="openModal('loginModal')" class="text-gray-700 hover:text-indigo-600 font-medium transition duration-200 text-sm sm:text-base">
                                    Login
                                </button>
                                @if (Route::has('register'))
                                    <button onclick="openModal('registerModal')" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-3 py-2 sm:px-6 sm:py-2.5 rounded-lg font-semibold hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 text-xs sm:text-base whitespace-nowrap">
                                        Get Started
                                    </button>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative pt-32 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 z-0">
                <!-- Background Image -->
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1920&q=80" 
                     alt="Team collaboration" 
                     class="w-full h-full object-cover">
                
                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/95 via-purple-900/90 to-blue-900/95"></div>
                
                <!-- Pattern Overlay -->
                <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
            </div>

            <div class="max-w-7xl mx-auto relative z-10">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    
                    <!-- Left Content -->
                    <div class="space-y-8 animate-fade-in">
                        <!-- Main Heading -->
                        <div class="space-y-4">
                            <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white leading-tight">
                                Track Your <br>
                                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">OJT Hours</span> <br>
                                Effortlessly
                            </h1>
                            <p class="text-xl md:text-2xl text-gray-200 leading-relaxed max-w-xl">
                                Track your OJT hours easily and professionally. Manage time records, document accomplishments, and generate reports—all in one place.
                            </p>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            @if (Route::has('register'))
                                <button onclick="openModal('registerModal')" class="group inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    <span>Start Tracking Now</span>
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </button>
                            @endif
                            @if (Route::has('login'))
                                <button onclick="openModal('loginModal')" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-indigo-600 bg-white rounded-xl hover:bg-indigo-50 transition-all duration-200 shadow-md hover:shadow-lg border-2 border-indigo-200 hover:border-indigo-300">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    <span>Sign In</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                        Everything You Need to <span class="text-indigo-600">Succeed</span>
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Powerful features designed specifically for OJT students and interns
                    </p>
                </div>

                <!-- Features Grid -->
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    <!-- Feature 1: Daily Time Record -->
                    <div class="group relative bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-blue-200">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative z-10">
                            <div class="bg-blue-600 group-hover:bg-white w-14 h-14 rounded-xl flex items-center justify-center mb-6 transition-colors duration-300">
                                <svg class="w-7 h-7 text-white group-hover:text-blue-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 group-hover:text-white mb-3 transition-colors duration-300">Daily Time Record</h3>
                            <p class="text-gray-600 group-hover:text-blue-100 transition-colors duration-300">
                                Easy time-in and time-out system with automatic hour computation. Track your daily attendance effortlessly.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2: Accomplishment Logs -->
                    <div class="group relative bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-purple-200">
                        <div class="absolute inset-0 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative z-10">
                            <div class="bg-purple-600 group-hover:bg-white w-14 h-14 rounded-xl flex items-center justify-center mb-6 transition-colors duration-300">
                                <svg class="w-7 h-7 text-white group-hover:text-purple-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 group-hover:text-white mb-3 transition-colors duration-300">Accomplishment Logs</h3>
                            <p class="text-gray-600 group-hover:text-purple-100 transition-colors duration-300">
                                Document your daily tasks, learnings, and technologies used. Build your professional portfolio while you work.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3: Progress Dashboard -->
                    <div class="group relative bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-green-200">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-600 to-green-700 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative z-10">
                            <div class="bg-green-600 group-hover:bg-white w-14 h-14 rounded-xl flex items-center justify-center mb-6 transition-colors duration-300">
                                <svg class="w-7 h-7 text-white group-hover:text-green-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 group-hover:text-white mb-3 transition-colors duration-300">Progress Dashboard</h3>
                            <p class="text-gray-600 group-hover:text-green-100 transition-colors duration-300">
                                Real-time visualization of your total hours, remaining hours, and completion percentage at a glance.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 4: PDF Reports -->
                    <div class="group relative bg-gradient-to-br from-red-50 to-red-100 rounded-2xl p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-red-200">
                        <div class="absolute inset-0 bg-gradient-to-br from-red-600 to-red-700 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative z-10">
                            <div class="bg-red-600 group-hover:bg-white w-14 h-14 rounded-xl flex items-center justify-center mb-6 transition-colors duration-300">
                                <svg class="w-7 h-7 text-white group-hover:text-red-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 group-hover:text-white mb-3 transition-colors duration-300">PDF Reports</h3>
                            <p class="text-gray-600 group-hover:text-red-100 transition-colors duration-300">
                                Generate professional weekly and monthly reports ready for submission to your OJT coordinator instantly.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 5: Secure & Private -->
                    <div class="group relative bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-2xl p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-yellow-200">
                        <div class="absolute inset-0 bg-gradient-to-br from-yellow-600 to-yellow-700 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative z-10">
                            <div class="bg-yellow-600 group-hover:bg-white w-14 h-14 rounded-xl flex items-center justify-center mb-6 transition-colors duration-300">
                                <svg class="w-7 h-7 text-white group-hover:text-yellow-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 group-hover:text-white mb-3 transition-colors duration-300">Secure & Private</h3>
                            <p class="text-gray-600 group-hover:text-yellow-100 transition-colors duration-300">
                                Your data is encrypted and protected. Only you can access your personal records and information.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 6: Mobile Responsive -->
                    <div class="group relative bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-2xl p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-indigo-200">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative z-10">
                            <div class="bg-indigo-600 group-hover:bg-white w-14 h-14 rounded-xl flex items-center justify-center mb-6 transition-colors duration-300">
                                <svg class="w-7 h-7 text-white group-hover:text-indigo-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 group-hover:text-white mb-3 transition-colors duration-300">Mobile Responsive</h3>
                            <p class="text-gray-600 group-hover:text-indigo-100 transition-colors duration-300">
                                Access your tracker anywhere, anytime. Fully optimized for mobile, tablet, and desktop devices.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-20 bg-gradient-to-br from-indigo-600 to-purple-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-3 gap-8 text-center">
                    <div class="space-y-2">
                        <p class="text-5xl font-bold text-white">590</p>
                        <p class="text-indigo-200 text-lg">Total Hours to Track</p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-5xl font-bold text-white">75</p>
                        <p class="text-indigo-200 text-lg">Working Days</p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-5xl font-bold text-white">100%</p>
                        <p class="text-indigo-200 text-lg">Free Forever</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-24 bg-gray-50">
            <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Ready to Start <span class="text-indigo-600">Tracking?</span>
                </h2>
                <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
                    Join students and interns who are managing their OJT hours professionally with OJTracker
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @if (Route::has('register'))
                        <button onclick="openModal('registerModal')" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Get Started Free
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    @endif
                    @if (Route::has('login'))
                        <button onclick="openModal('loginModal')" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-gray-700 bg-white rounded-xl hover:bg-gray-100 transition-all duration-200 shadow-md hover:shadow-lg border border-gray-200">
                            Already have an account? Sign In
                        </button>
                    @endif
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="relative bg-gray-900 text-gray-400 py-12 overflow-hidden">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1920&q=80" 
                     alt="Background" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/95 via-purple-900/95 to-blue-900/95"></div>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <!-- Brand -->
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('assets/images/ojtracker_logo.png') }}" alt="OJTracker Logo" class="h-16 md:h-20">
                    </div>
                    
                    <!-- Copyright -->
                    <div class="text-center md:text-right">
                        <p class="text-sm">© {{ date('Y') }} OJTracker. Built for students, by Soydelz.</p>
                        <p class="text-sm mt-1">All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Login Modal -->
        <div id="loginModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                <div class="p-8">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Welcome Back</h2>
                        <button onclick="closeModal('loginModal')" class="text-gray-400 hover:text-gray-600 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf
                        
                        <!-- Username -->
                        <div class="mb-4">
                            <label for="login_username" class="block text-sm font-medium text-gray-700 mb-2">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="login_username" name="username" required autofocus value="{{ old('username') }}"
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @if($errors->has('username') || $errors->has('password')) border-red-500 @else border-gray-300 @endif">
                        </div>

                        <!-- Password -->
                        <div class="mb-6">
                            <label for="login_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="login_password" name="password" required
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition @if($errors->has('username') || $errors->has('password')) border-red-500 @else border-gray-300 @endif">
                            @error('username')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" id="remember_me" name="remember" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>
                            <button type="button" onclick="switchModal('loginModal', 'forgotPasswordModal')" class="text-sm text-indigo-600 hover:text-indigo-700">
                                Forgot password?
                            </button>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-lg font-semibold hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-lg">
                            Sign In
                        </button>
                    </form>

                    <!-- Register Link -->
                    <p class="mt-6 text-center text-sm text-gray-600">
                        Don't have an account? 
                        <button onclick="switchModal('loginModal', 'registerModal')" class="text-indigo-600 hover:text-indigo-700 font-semibold">
                            Create Account
                        </button>
                    </p>
                </div>
            </div>
        </div>

        <!-- Register Modal -->
        <div id="registerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
                <div class="p-8">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Create Account</h2>
                        <button onclick="closeModal('registerModal')" class="text-gray-400 hover:text-gray-600 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Register Form -->
                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf
                        
                        <!-- Name -->
                        <div class="mb-4">
                            <label for="register_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="register_name" name="name" required autofocus
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            <p class="text-red-500 text-xs mt-1 hidden" id="register_name_error"></p>
                        </div>

                        <!-- Username -->
                        <div class="mb-4">
                            <label for="register_username" class="block text-sm font-medium text-gray-700 mb-2">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="register_username" name="username" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            <p class="text-red-500 text-xs mt-1 hidden" id="register_username_error"></p>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="register_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-2">
                                <input type="email" id="register_email" name="email" required
                                       class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                <button type="button" id="send_verification_btn" onclick="sendVerificationCode()" 
                                        class="px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition whitespace-nowrap text-sm font-medium">
                                    Send Code
                                </button>
                            </div>
                            <p class="text-red-500 text-xs mt-1 hidden" id="register_email_error"></p>
                            <p class="text-green-600 text-xs mt-1 hidden" id="register_email_success"></p>
                            
                            <!-- Verification Code Input (hidden by default) -->
                            <div id="verification_code_container" class="mt-3 hidden">
                                <label for="verification_code" class="block text-sm font-medium text-gray-700 mb-2">
                                    Verification Code <span class="text-red-500">*</span>
                                </label>
                                <div class="flex gap-2">
                                    <input type="text" id="verification_code" maxlength="6" placeholder="Enter 6-digit code"
                                           class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                    <button type="button" id="verify_code_btn" onclick="verifyCode()" 
                                            class="px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition whitespace-nowrap text-sm font-medium">
                                        Verify
                                    </button>
                                </div>
                                <p class="text-red-500 text-xs mt-1 hidden" id="verification_code_error"></p>
                                <p class="text-green-600 text-xs mt-1 hidden flex items-center" id="email_verified_indicator">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Email verified successfully!
                                </p>
                            </div>
                        </div>

                        <!-- School/University -->
                        <div class="mb-4">
                            <label for="register_school" class="block text-sm font-medium text-gray-700 mb-2">
                                School/University <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="register_school" name="school" required placeholder="e.g., Southern de Oro Philippines College"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            <p class="text-red-500 text-xs mt-1 hidden" id="register_school_error"></p>
                        </div>

                        <!-- Required Hours -->
                        <div class="mb-4">
                            <label for="register_required_hours" class="block text-sm font-medium text-gray-700 mb-2">
                                Required OJT Hours <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="register_required_hours" name="required_hours" value="590" required min="1" max="2000"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            <p class="text-xs text-gray-500 mt-1">Enter your total required OJT hours</p>
                            <p class="text-xs text-indigo-600 mt-1 font-medium" id="calculated_days_modal">≈ 75 days of OJT</p>
                            <p class="text-red-500 text-xs mt-1 hidden" id="register_required_hours_error"></p>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="register_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="register_password" name="password" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            
                            <!-- Password Strength Indicator -->
                            <div class="mt-2 hidden" id="password_strength_container">
                                <div class="flex items-center gap-2 mb-1">
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                        <div id="password_strength_bar" class="h-full transition-all duration-300" style="width: 0%"></div>
                                    </div>
                                    <span id="password_strength_text" class="text-xs font-medium"></span>
                                </div>
                                <ul class="text-xs space-y-1 mt-2">
                                    <li id="length_check" class="flex items-center text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        At least 8 characters
                                    </li>
                                    <li id="capital_check" class="flex items-center text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        At least 1 uppercase letter
                                    </li>
                                    <li id="number_check" class="flex items-center text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        At least 1 number
                                    </li>
                                </ul>
                            </div>
                            <p class="text-red-500 text-xs mt-1 hidden" id="register_password_error"></p>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-6">
                            <label for="register_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirm Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="register_password_confirmation" name="password_confirmation" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            <p class="text-red-500 text-xs mt-1 hidden" id="register_password_confirmation_error"></p>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-lg font-semibold hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-lg">
                            Create Account
                        </button>
                    </form>

                    <!-- Login Link -->
                    <p class="mt-6 text-center text-sm text-gray-600">
                        Already have an account? 
                        <button onclick="switchModal('registerModal', 'loginModal')" class="text-indigo-600 hover:text-indigo-700 font-semibold">
                            Sign In
                        </button>
                    </p>
                </div>
            </div>
        </div>

        <!-- Forgot Password Modal -->
        <div id="forgotPasswordModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
                <div class="p-8">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Reset Password</h2>
                        <button onclick="closeModal('forgotPasswordModal')" class="text-gray-400 hover:text-gray-600 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <p class="text-gray-600 text-sm mb-6">
                        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.
                    </p>

                    <!-- Success Message -->
                    <div id="forgot_password_success" class="hidden mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-green-800 text-sm">Password reset link has been sent to your email!</p>
                    </div>

                    <!-- Forgot Password Form -->
                    <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
                        @csrf
                        
                        <!-- Email -->
                        <div class="mb-6">
                            <label for="forgot_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="forgot_email" name="email" required autofocus
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            <p class="text-red-500 text-xs mt-1 hidden" id="forgot_email_error"></p>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-lg font-semibold hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-lg">
                            Send Reset Link
                        </button>
                    </form>

                    <!-- Back to Login Link -->
                    <p class="mt-6 text-center text-sm text-gray-600">
                        Remember your password? 
                        <button onclick="switchModal('forgotPasswordModal', 'loginModal')" class="text-indigo-600 hover:text-indigo-700 font-semibold">
                            Back to Login
                        </button>
                    </p>
                </div>
            </div>
        </div>

        <!-- Reset Password Modal -->
        <div id="resetPasswordModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
                <div class="p-8">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Reset Password</h2>
                        <button onclick="closeModal('resetPasswordModal')" class="text-gray-400 hover:text-gray-600 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Reset Password Form -->
                    <form method="POST" action="{{ route('password.store') }}" id="resetPasswordForm">
                        @csrf
                        <input type="hidden" name="token" id="reset_token" value="">
                        
                        <!-- Email -->
                        <div class="mb-4">
                            <label for="reset_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="reset_email" name="email" required readonly
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                            <p class="text-red-500 text-xs mt-1 hidden" id="reset_email_error"></p>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="reset_password" class="block text-sm font-medium text-gray-700 mb-2">
                                New Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="reset_password" name="password" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            
                            <!-- Password Strength Indicator -->
                            <div class="mt-2 hidden" id="reset_password_strength_container">
                                <div class="flex items-center gap-2 mb-1">
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                        <div id="reset_password_strength_bar" class="h-full transition-all duration-300" style="width: 0%"></div>
                                    </div>
                                    <span id="reset_password_strength_text" class="text-xs font-medium"></span>
                                </div>
                                <ul class="text-xs space-y-1 mt-2">
                                    <li id="reset_length_check" class="flex items-center text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        At least 8 characters
                                    </li>
                                    <li id="reset_capital_check" class="flex items-center text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        At least 1 uppercase letter
                                    </li>
                                    <li id="reset_number_check" class="flex items-center text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        At least 1 number
                                    </li>
                                </ul>
                            </div>
                            <p class="text-red-500 text-xs mt-1 hidden" id="reset_password_error"></p>
                        </div>

                        <!-- Password Confirmation -->
                        <div class="mb-6">
                            <label for="reset_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirm Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="reset_password_confirmation" name="password_confirmation" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                            <p class="text-red-500 text-xs mt-1 hidden" id="reset_password_confirmation_error"></p>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-lg font-semibold hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-lg">
                            Reset Password
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal JavaScript -->
        <script>
            // Password strength checker
            function checkPasswordStrength(password) {
                let strength = 0;
                const checks = {
                    length: password.length >= 8,
                    capital: /[A-Z]/.test(password),
                    number: /[0-9]/.test(password)
                };

                // Update visual indicators
                updateCheck('length_check', checks.length);
                updateCheck('capital_check', checks.capital);
                updateCheck('number_check', checks.number);

                // Calculate strength
                if (checks.length) strength++;
                if (checks.capital) strength++;
                if (checks.number) strength++;

                // Update strength bar and text
                const strengthBar = document.getElementById('password_strength_bar');
                const strengthText = document.getElementById('password_strength_text');
                const strengthContainer = document.getElementById('password_strength_container');

                if (strengthBar && strengthText && strengthContainer) {
                    if (password.length === 0) {
                        strengthContainer.classList.add('hidden');
                        strengthBar.style.width = '0%';
                        strengthBar.className = 'h-full transition-all duration-300';
                        strengthText.textContent = '';
                        strengthText.className = 'text-xs font-medium';
                    } else {
                        strengthContainer.classList.remove('hidden');
                        if (strength === 0) {
                        strengthBar.style.width = '25%';
                    strengthBar.className = 'h-full transition-all duration-300 bg-red-500';
                    strengthText.textContent = 'Weak';
                    strengthText.className = 'text-xs font-medium text-red-500';
                } else if (strength === 1) {
                    strengthBar.style.width = '50%';
                    strengthBar.className = 'h-full transition-all duration-300 bg-orange-500';
                    strengthText.textContent = 'Fair';
                    strengthText.className = 'text-xs font-medium text-orange-500';
                } else if (strength === 2) {
                    strengthBar.style.width = '75%';
                    strengthBar.className = 'h-full transition-all duration-300 bg-yellow-500';
                    strengthText.textContent = 'Good';
                    strengthText.className = 'text-xs font-medium text-yellow-500';
                } else if (strength === 3) {
                    strengthBar.style.width = '100%';
                    strengthBar.className = 'h-full transition-all duration-300 bg-green-500';
                    strengthText.textContent = 'Strong';
                    strengthText.className = 'text-xs font-medium text-green-500';
                        }
                    }
                }

                return checks;
            }

            function updateCheck(elementId, isPassing) {
                const element = document.getElementById(elementId);
                if (isPassing) {
                    element.className = 'flex items-center text-green-600';
                    element.querySelector('svg').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';
                } else {
                    element.className = 'flex items-center text-gray-500';
                    element.querySelector('svg').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
                }
            }

            // Remember Me functionality - Load saved credentials
            window.addEventListener('DOMContentLoaded', function() {
                const savedUsername = localStorage.getItem('remembered_username');
                const savedPassword = localStorage.getItem('remembered_password');
                
                if (savedUsername && savedPassword) {
                    const usernameInput = document.getElementById('login_username');
                    const passwordInput = document.getElementById('login_password');
                    const rememberCheckbox = document.getElementById('remember_me');
                    
                    if (usernameInput && passwordInput && rememberCheckbox) {
                        usernameInput.value = savedUsername;
                        passwordInput.value = atob(savedPassword); // Decode from base64
                        rememberCheckbox.checked = true;
                    }
                }
            });

            // Real-time password validation
            document.getElementById('register_password')?.addEventListener('input', function() {
                checkPasswordStrength(this.value);
            });

            // Real-time reset password validation
            document.getElementById('reset_password')?.addEventListener('input', function() {
                checkResetPasswordStrength(this.value);
            });

            // Calculate required days based on required hours
            document.getElementById('register_required_hours')?.addEventListener('input', function() {
                const hours = parseInt(this.value) || 590;
                const hoursPerDay = 7.867; // 590 hours / 75 days
                const days = Math.ceil(hours / hoursPerDay);
                const calculatedText = document.getElementById('calculated_days_modal');
                if (calculatedText) {
                    calculatedText.textContent = `≈ ${days} days of OJT`;
                }
            });

            // Password strength checker for reset password
            function checkResetPasswordStrength(password) {
                let strength = 0;
                const checks = {
                    length: password.length >= 8,
                    capital: /[A-Z]/.test(password),
                    number: /[0-9]/.test(password)
                };

                // Update visual indicators
                updateCheck('reset_length_check', checks.length);
                updateCheck('reset_capital_check', checks.capital);
                updateCheck('reset_number_check', checks.number);

                // Calculate strength
                if (checks.length) strength++;
                if (checks.capital) strength++;
                if (checks.number) strength++;

                // Update strength bar and text
                const strengthBar = document.getElementById('reset_password_strength_bar');
                const strengthText = document.getElementById('reset_password_strength_text');
                const strengthContainer = document.getElementById('reset_password_strength_container');

                if (strengthBar && strengthText && strengthContainer) {
                    if (password.length === 0) {
                        strengthContainer.classList.add('hidden');
                        strengthBar.style.width = '0%';
                        strengthBar.className = 'h-full transition-all duration-300';
                        strengthText.textContent = '';
                        strengthText.className = 'text-xs font-medium';
                    } else {
                        strengthContainer.classList.remove('hidden');
                        if (strength === 0) {
                            strengthBar.style.width = '25%';
                            strengthBar.className = 'h-full transition-all duration-300 bg-red-500';
                            strengthText.textContent = 'Weak';
                            strengthText.className = 'text-xs font-medium text-red-500';
                        } else if (strength === 1) {
                            strengthBar.style.width = '50%';
                            strengthBar.className = 'h-full transition-all duration-300 bg-orange-500';
                            strengthText.textContent = 'Fair';
                            strengthText.className = 'text-xs font-medium text-orange-500';
                        } else if (strength === 2) {
                            strengthBar.style.width = '75%';
                            strengthBar.className = 'h-full transition-all duration-300 bg-yellow-500';
                            strengthText.textContent = 'Good';
                            strengthText.className = 'text-xs font-medium text-yellow-500';
                        } else if (strength === 3) {
                            strengthBar.style.width = '100%';
                            strengthBar.className = 'h-full transition-all duration-300 bg-green-500';
                            strengthText.textContent = 'Strong';
                            strengthText.className = 'text-xs font-medium text-green-500';
                        }
                    }
                }

                return checks;
            }

            // Form validation
            document.getElementById('registerForm')?.addEventListener('submit', function(e) {
                let isValid = true;
                
                // Clear previous errors
                document.querySelectorAll('.text-red-500').forEach(el => {
                    if (el.id.includes('_error')) {
                        el.classList.add('hidden');
                        el.textContent = '';
                    }
                });
                document.querySelectorAll('input').forEach(input => {
                    input.classList.remove('border-red-500');
                });

                // Validate name
                const name = document.getElementById('register_name').value.trim();
                if (!name) {
                    showError('register_name', 'Full name is required');
                    isValid = false;
                }

                // Validate username
                const username = document.getElementById('register_username').value.trim();
                if (!username) {
                    showError('register_username', 'Username is required');
                    isValid = false;
                } else if (username.length < 3) {
                    showError('register_username', 'Username must be at least 3 characters');
                    isValid = false;
                }

                // Validate email
                const email = document.getElementById('register_email').value.trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const emailVerified = document.getElementById('register_email').dataset.verified === 'true';
                if (!email) {
                    showError('register_email', 'Email is required');
                    isValid = false;
                } else if (!emailRegex.test(email)) {
                    showError('register_email', 'Please enter a valid email address');
                    isValid = false;
                } else if (!emailVerified) {
                    showError('register_email', 'Please verify your email address first');
                    isValid = false;
                }

                // Validate password
                const password = document.getElementById('register_password').value;
                const checks = checkPasswordStrength(password);
                if (!password) {
                    showError('register_password', 'Password is required');
                    isValid = false;
                } else if (!checks.length || !checks.capital || !checks.number) {
                    showError('register_password', 'Password must be strong (meet all 3 requirements)');
                    isValid = false;
                }

                // Validate password confirmation
                const passwordConfirmation = document.getElementById('register_password_confirmation').value;
                if (!passwordConfirmation) {
                    showError('register_password_confirmation', 'Please confirm your password');
                    isValid = false;
                } else if (password !== passwordConfirmation) {
                    showError('register_password_confirmation', 'Passwords do not match');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });

            // Login form validation
            document.getElementById('loginForm')?.addEventListener('submit', function(e) {
                let isValid = true;
                
                // Clear previous errors
                document.querySelectorAll('.text-red-500').forEach(el => {
                    if (el.id.includes('_error')) {
                        el.classList.add('hidden');
                        el.textContent = '';
                    }
                });
                document.querySelectorAll('input').forEach(input => {
                    input.classList.remove('border-red-500');
                });

                // Validate username
                const username = document.getElementById('login_username').value.trim();
                if (!username) {
                    showError('login_username', 'Username is required');
                    isValid = false;
                }

                // Validate password
                const password = document.getElementById('login_password').value;
                if (!password) {
                    showError('login_password', 'Password is required');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    return;
                }

                // Handle Remember Me
                const rememberMe = document.getElementById('remember_me').checked;
                if (rememberMe) {
                    // Save credentials to localStorage (encode password with base64)
                    localStorage.setItem('remembered_username', username);
                    localStorage.setItem('remembered_password', btoa(password)); // Encode to base64
                } else {
                    // Clear saved credentials if remember me is unchecked
                    localStorage.removeItem('remembered_username');
                    localStorage.removeItem('remembered_password');
                }
            });

            function showError(fieldId, message) {
                const errorElement = document.getElementById(fieldId + '_error');
                const inputElement = document.getElementById(fieldId);
                
                if (errorElement) {
                    errorElement.textContent = message;
                    errorElement.classList.remove('hidden');
                }
                if (inputElement) {
                    inputElement.classList.add('border-red-500');
                }
            }

            // Function to clear remember me data (call this on logout)
            function clearRememberMe() {
                localStorage.removeItem('remembered_username');
                localStorage.removeItem('remembered_password');
            }

            function openModal(modalId) {
                document.getElementById(modalId).classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
                document.body.style.overflow = 'auto';
                
                // Clear form and errors
                const forms = document.querySelectorAll('form');
                forms.forEach(form => form.reset());
                document.querySelectorAll('.text-red-500').forEach(el => {
                    if (el.id.includes('_error')) {
                        el.classList.add('hidden');
                        el.textContent = '';
                    }
                });
                document.querySelectorAll('input').forEach(input => {
                    input.classList.remove('border-red-500');
                });
                
                // Reset password strength indicator
                const strengthBar = document.getElementById('password_strength_bar');
                const strengthText = document.getElementById('password_strength_text');
                const strengthContainer = document.getElementById('password_strength_container');
                if (strengthContainer) {
                    strengthContainer.classList.add('hidden');
                }
                if (strengthBar) {
                    strengthBar.style.width = '0%';
                    strengthBar.className = 'h-full transition-all duration-300';
                }
                if (strengthText) {
                    strengthText.textContent = '';
                    strengthText.className = 'text-xs font-medium';
                }
                
                // Reset reset password strength indicator
                const resetStrengthBar = document.getElementById('reset_password_strength_bar');
                const resetStrengthText = document.getElementById('reset_password_strength_text');
                const resetStrengthContainer = document.getElementById('reset_password_strength_container');
                if (resetStrengthContainer) {
                    resetStrengthContainer.classList.add('hidden');
                }
                if (resetStrengthBar) {
                    resetStrengthBar.style.width = '0%';
                    resetStrengthBar.className = 'h-full transition-all duration-300';
                }
                if (resetStrengthText) {
                    resetStrengthText.textContent = '';
                    resetStrengthText.className = 'text-xs font-medium';
                }
                
                // Reset checkmarks
                ['length_check', 'capital_check', 'number_check', 'reset_length_check', 'reset_capital_check', 'reset_number_check'].forEach(id => {
                    const element = document.getElementById(id);
                    if (element) {
                        element.className = 'flex items-center text-gray-500';
                        const svg = element.querySelector('svg');
                        if (svg) {
                            svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
                        }
                    }
                });
            }

            function switchModal(closeModalId, openModalId) {
                closeModal(closeModalId);
                setTimeout(() => openModal(openModalId), 100);
            }

            // Email Verification Functions
            let verificationCodeSent = false;
            
            function sendVerificationCode() {
                const emailInput = document.getElementById('register_email');
                const email = emailInput.value.trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const sendBtn = document.getElementById('send_verification_btn');
                const successMsg = document.getElementById('register_email_success');
                const errorMsg = document.getElementById('register_email_error');
                
                // Clear previous messages
                errorMsg.classList.add('hidden');
                successMsg.classList.add('hidden');
                
                if (!email) {
                    errorMsg.textContent = 'Please enter your email address';
                    errorMsg.classList.remove('hidden');
                    return;
                }
                
                if (!emailRegex.test(email)) {
                    errorMsg.textContent = 'Please enter a valid email address';
                    errorMsg.classList.remove('hidden');
                    return;
                }
                
                // Disable button and show loading
                sendBtn.disabled = true;
                sendBtn.textContent = 'Sending...';
                
                // Send verification code via AJAX
                fetch('{{ route("send.verification") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ email: email })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        successMsg.textContent = 'Verification code sent! Check your email.';
                        successMsg.classList.remove('hidden');
                        document.getElementById('verification_code_container').classList.remove('hidden');
                        verificationCodeSent = true;
                        sendBtn.textContent = 'Resend Code';
                        // Don't lock email field yet - allow editing in case of typo
                    } else {
                        errorMsg.textContent = data.message || 'Failed to send verification code';
                        errorMsg.classList.remove('hidden');
                        sendBtn.textContent = 'Send Code';
                    }
                })
                .catch(error => {
                    errorMsg.textContent = 'Error sending verification code. Please try again.';
                    errorMsg.classList.remove('hidden');
                    sendBtn.textContent = 'Send Code';
                })
                .finally(() => {
                    sendBtn.disabled = false;
                });
            }
            
            function verifyCode() {
                const emailInput = document.getElementById('register_email');
                const codeInput = document.getElementById('verification_code');
                const code = codeInput.value.trim();
                const verifyBtn = document.getElementById('verify_code_btn');
                const sendBtn = document.getElementById('send_verification_btn');
                const errorMsg = document.getElementById('verification_code_error');
                const successIndicator = document.getElementById('email_verified_indicator');
                
                // Clear previous messages
                errorMsg.classList.add('hidden');
                
                if (!code) {
                    errorMsg.textContent = 'Please enter the verification code';
                    errorMsg.classList.remove('hidden');
                    return;
                }
                
                if (code.length !== 6) {
                    errorMsg.textContent = 'Verification code must be 6 digits';
                    errorMsg.classList.remove('hidden');
                    return;
                }
                
                // Disable button and show loading
                verifyBtn.disabled = true;
                verifyBtn.textContent = 'Verifying...';
                
                // Verify code via AJAX
                fetch('{{ route("verify.code") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ 
                        email: emailInput.value.trim(),
                        code: code 
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        successIndicator.classList.remove('hidden');
                        emailInput.dataset.verified = 'true';
                        // Lock email field ONLY after successful verification
                        emailInput.readOnly = true;
                        emailInput.classList.add('bg-gray-100');
                        codeInput.readOnly = true;
                        codeInput.classList.add('bg-gray-100');
                        verifyBtn.classList.add('hidden');
                        sendBtn.classList.add('hidden');
                        errorMsg.classList.add('hidden');
                    } else {
                        errorMsg.textContent = data.message || 'Invalid verification code';
                        errorMsg.classList.remove('hidden');
                        verifyBtn.textContent = 'Verify';
                    }
                })
                .catch(error => {
                    errorMsg.textContent = 'Error verifying code. Please try again.';
                    errorMsg.classList.remove('hidden');
                    verifyBtn.textContent = 'Verify';
                })
                .finally(() => {
                    verifyBtn.disabled = false;
                });
            }
            
            // Reset email verification when modal closes
            const originalCloseModal = closeModal;
            closeModal = function(modalId) {
                if (modalId === 'registerModal') {
                    // Reset verification state
                    verificationCodeSent = false;
                    const emailInput = document.getElementById('register_email');
                    const sendBtn = document.getElementById('send_verification_btn');
                    if (emailInput) {
                        emailInput.dataset.verified = 'false';
                        emailInput.readOnly = false;
                        emailInput.classList.remove('bg-gray-100');
                    }
                    if (sendBtn) {
                        sendBtn.classList.remove('hidden');
                        sendBtn.textContent = 'Send Code';
                    }
                    document.getElementById('verification_code_container')?.classList.add('hidden');
                    document.getElementById('email_verified_indicator')?.classList.add('hidden');
                    document.getElementById('register_email_success')?.classList.add('hidden');
                    const codeInput = document.getElementById('verification_code');
                    if (codeInput) {
                        codeInput.value = '';
                        codeInput.readOnly = false;
                        codeInput.classList.remove('bg-gray-100');
                    }
                    document.getElementById('verify_code_btn')?.classList.remove('hidden');
                }
                originalCloseModal(modalId);
            };
        </script>

        <!-- Modal JavaScript -->
        <script>
            function openModal(modalId) {
                document.getElementById(modalId).classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            function switchModal(closeModalId, openModalId) {
                closeModal(closeModalId);
                setTimeout(() => openModal(openModalId), 100);
            }

            // Close modal when clicking outside
            document.addEventListener('click', function(event) {
                const loginModal = document.getElementById('loginModal');
                const registerModal = document.getElementById('registerModal');
                const forgotPasswordModal = document.getElementById('forgotPasswordModal');
                const resetPasswordModal = document.getElementById('resetPasswordModal');
                
                if (event.target === loginModal) {
                    closeModal('loginModal');
                }
                if (event.target === registerModal) {
                    closeModal('registerModal');
                }
                if (event.target === forgotPasswordModal) {
                    closeModal('forgotPasswordModal');
                }
                if (event.target === resetPasswordModal) {
                    closeModal('resetPasswordModal');
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeModal('loginModal');
                    closeModal('registerModal');
                    closeModal('forgotPasswordModal');
                    closeModal('resetPasswordModal');
                }
            });

            // Check for registration success message
            @if(session('registration_success'))
                // Close register modal
                closeModal('registerModal');
                
                // Show success message
                const successDiv = document.createElement('div');
                successDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-[200] flex items-center gap-3';
                successDiv.innerHTML = `
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="font-semibold">Account created successfully!</p>
                        <p class="text-sm">You can now login with your credentials.</p>
                    </div>
                `;
                document.body.appendChild(successDiv);
                
                // Open login modal after 2 seconds
                setTimeout(() => {
                    openModal('loginModal');
                    // Remove success message after 5 seconds
                    setTimeout(() => {
                        successDiv.remove();
                    }, 3000);
                }, 2000);
            @endif

            // Check for login errors and open login modal
            @error('username')
                openModal('loginModal');
            @enderror
            @error('password')
                openModal('loginModal');
            @enderror

            // Check for password reset status
            @if(session('status'))
                openModal('forgotPasswordModal');
                document.getElementById('forgot_password_success').classList.remove('hidden');
                setTimeout(() => {
                    closeModal('forgotPasswordModal');
                    openModal('loginModal');
                }, 3000);
            @endif

            // Check for forgot password errors
            @error('email')
                @if(!request()->has('token'))
                    openModal('forgotPasswordModal');
                    const forgotEmailError = document.getElementById('forgot_email_error');
                    if (forgotEmailError) {
                        forgotEmailError.textContent = '{{ $message }}';
                        forgotEmailError.classList.remove('hidden');
                        document.getElementById('forgot_email').classList.add('border-red-500');
                    }
                @endif
            @enderror

            // Check for password reset token in URL
            const urlParams = new URLSearchParams(window.location.search);
            const resetToken = urlParams.get('token');
            const resetEmail = urlParams.get('email');
            
            if (resetToken && resetEmail) {
                document.getElementById('reset_token').value = resetToken;
                document.getElementById('reset_email').value = decodeURIComponent(resetEmail);
                openModal('resetPasswordModal');
            }

            // Check for password reset success
            @if(session('password_reset_success'))
                // Show success message
                const resetSuccessDiv = document.createElement('div');
                resetSuccessDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-[200] flex items-center gap-3';
                resetSuccessDiv.innerHTML = `
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-semibold">Password reset successful! You can now login with your new password.</span>
                `;
                document.body.appendChild(resetSuccessDiv);
                
                // Open login modal after a delay
                setTimeout(() => {
                    openModal('loginModal');
                    // Remove success message after showing login modal
                    setTimeout(() => {
                        resetSuccessDiv.remove();
                    }, 3000);
                }, 2000);
            @endif

            // Check for reset password errors
            @if($errors->has('password') || $errors->has('email'))
                @if(request()->has('token'))
                    const token = '{{ request()->get("token") }}';
                    const email = '{{ request()->get("email") }}';
                    if (token && email) {
                        document.getElementById('reset_token').value = token;
                        document.getElementById('reset_email').value = email;
                        openModal('resetPasswordModal');
                        
                        @error('email')
                            const resetEmailError = document.getElementById('reset_email_error');
                            if (resetEmailError) {
                                resetEmailError.textContent = '{{ $message }}';
                                resetEmailError.classList.remove('hidden');
                                document.getElementById('reset_email').classList.add('border-red-500');
                            }
                        @enderror
                        
                        @error('password')
                            const resetPasswordError = document.getElementById('reset_password_error');
                            if (resetPasswordError) {
                                resetPasswordError.textContent = '{{ $message }}';
                                resetPasswordError.classList.remove('hidden');
                                document.getElementById('reset_password').classList.add('border-red-500');
                            }
                        @enderror
                    }
                @endif
            @endif
        </script>

    </body>
</html>
