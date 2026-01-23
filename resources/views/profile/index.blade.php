@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', 'Profile')

@push('scripts')
<!-- Face-API.js Library -->
<script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.min.js"></script>
<script defer src="{{ asset('js/profile-face-registration.js') }}"></script>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Success/Warning Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ session('warning') }}
        </div>
    @endif

    <!-- Profile Header with Cover Photo (Facebook Style) -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <!-- Cover Photo Section -->
        <div class="relative h-64 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
            @if($user->cover_photo)
                <img src="{{ asset('storage/' . $user->cover_photo) }}" alt="Cover Photo" class="w-full h-full object-cover">
            @endif
            
            <!-- Change Cover Photo Button -->
            <div class="absolute top-4 right-4">
                <button onclick="document.getElementById('coverPhotoInput').click()" 
                        class="flex items-center px-4 py-2 bg-white/90 backdrop-blur-sm text-gray-700 font-medium rounded-lg hover:bg-white transition shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $user->cover_photo ? 'Change' : 'Add' }} Cover Photo
                </button>
                <form id="coverPhotoForm" action="{{ route('profile.upload-cover') }}" method="POST" enctype="multipart/form-data" class="hidden">
                    @csrf
                    <input type="file" id="coverPhotoInput" name="cover_photo" accept="image/*" onchange="document.getElementById('coverPhotoForm').submit()">
                </form>
            </div>
        </div>

        <!-- Profile Info Section -->
        <div class="relative px-6 pb-6">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between">
                <!-- Profile Picture & Info -->
                <div class="flex flex-col md:flex-row md:items-end -mt-16 md:-mt-20">
                    <!-- Profile Picture -->
                    <div class="relative group">
                        <div class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white shadow-xl overflow-hidden bg-gradient-to-br from-indigo-500 to-purple-600">
                            @if($user->profile_picture)
                                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-white text-5xl md:text-6xl font-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        
                        <!-- Change Profile Picture Button (appears on hover) -->
                        <button onclick="document.getElementById('profilePictureInput').click()" 
                                class="absolute inset-0 w-32 h-32 md:w-40 md:h-40 rounded-full bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                        <form id="profilePictureForm" action="{{ route('profile.upload-picture') }}" method="POST" enctype="multipart/form-data" class="hidden">
                            @csrf
                            <input type="file" id="profilePictureInput" name="profile_picture" accept="image/*" onchange="document.getElementById('profilePictureForm').submit()">
                        </form>
                    </div>

                    <!-- Name & Username -->
                    <div class="mt-4 md:mt-0 md:ml-6 md:mb-4">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="text-lg text-gray-600">@<span>{{ $user->username }}</span></p>
                        <p class="text-sm text-gray-500 mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Member since {{ $user->created_at->format('F Y') }}
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 md:mt-0 md:mb-4">
                    <button onclick="window.scrollTo({top: document.getElementById('settingsSection').offsetTop - 80, behavior: 'smooth'})" 
                            class="w-full md:w-auto px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-lg">
                        Edit Profile Settings
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div id="settingsSection" class="bg-white rounded-lg shadow border border-gray-100" x-data="{ activeTab: 'account' }">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <button @click="activeTab = 'account'" 
                        :class="activeTab === 'account' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm transition">
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Account Information
                    </div>
                </button>
                <button @click="activeTab = 'password'" 
                        :class="activeTab === 'password' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm transition">
                    <div class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Change Password
                    </div>
                </button>
            </nav>
        </div>

        <!-- Account Information Tab -->
        <div x-show="activeTab === 'account'" x-cloak class="p-6">
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Form Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                        <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('username') border-red-500 @enderror">
                        @error('username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if(!$user->email_verified_at)
                            <p class="mt-1 text-sm text-yellow-600">Email not verified</p>
                        @endif
                    </div>

                    <!-- School -->
                    <div>
                        <label for="school" class="block text-sm font-medium text-gray-700 mb-2">School/Institution</label>
                        <input type="text" name="school" id="school" value="{{ old('school', $user->school) }}"
                               placeholder="Southern de Oro Philippines College"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('school') border-red-500 @enderror">
                        @error('school')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Required Hours -->
                    <div>
                        <label for="required_hours" class="block text-sm font-medium text-gray-700 mb-2">Required OJT Hours</label>
                        <input type="number" name="required_hours" id="required_hours" value="{{ old('required_hours', $user->required_hours ?? 590) }}"
                               min="1" max="2000" step="1"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('required_hours') border-red-500 @enderror"
                               onkeyup="calculateRequiredDays()">
                        @error('required_hours')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Equivalent to <span id="required_days" class="font-semibold text-indigo-600">{{ $user->getRequiredDays() }}</span> days
                        </p>
                    </div>
                </div>

                <!-- OJT Statistics -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Your OJT Progress</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <p class="text-xs text-gray-600">Total Rendered</p>
                            <p class="text-lg font-bold text-green-600">{{ number_format($user->getTotalRenderedHours(), 2) }} hrs</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Remaining</p>
                            <p class="text-lg font-bold text-orange-600">{{ number_format($user->getRemainingHours(), 2) }} hrs</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Progress</p>
                            <p class="text-lg font-bold text-indigo-600">{{ number_format($user->getProgressPercentage(), 2) }}%</p>
                        </div>
                    </div>
                </div>

                <!-- Face Registration Section (For users without registered face) -->
                @if(!$user->face_descriptor)
                <div class="mb-6 bg-gradient-to-br from-yellow-50 to-orange-50 border-2 border-yellow-300 rounded-xl p-6">
                    <div class="flex items-start space-x-3 mb-4">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-1">⚠️ Face Recognition Required</h3>
                            <p class="text-sm text-gray-700 mb-3">
                                You need to register your face for DTR Time In/Out attendance. This is required to use the attendance system.
                            </p>
                            
                            <div id="face_registration_status" class="hidden mb-3">
                                <div class="flex items-center space-x-2 text-green-700 bg-green-50 px-4 py-2 rounded-lg border border-green-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="font-medium">Face captured successfully! Click "Save Changes" to register.</span>
                                </div>
                            </div>
                            
                            <button type="button" onclick="openProfileFaceCapture()" 
                                    class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-semibold rounded-lg hover:from-yellow-600 hover:to-orange-600 transition shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Register Face Now
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Hidden input for face descriptor -->
                <input type="hidden" name="face_descriptor" id="profile_face_descriptor" value="{{ $user->face_descriptor }}">

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="button" onclick="window.location.reload()" 
                            class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-lg">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password Tab -->
        <div x-show="activeTab === 'password'" x-cloak class="p-6">
            <form action="{{ route('profile.password') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-semibold mb-1">Password Requirements:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Minimum 8 characters</li>
                                <li>Must confirm new password</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                    <input type="password" name="current_password" id="current_password" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('current_password') border-red-500 @enderror">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm New Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                    <button type="button" onclick="document.getElementById('password').value=''; document.getElementById('password_confirmation').value=''; document.getElementById('current_password').value='';" 
                            class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                        Clear
                    </button>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-lg">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Face Registration Modal -->
<div id="faceRegistrationModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-4 rounded-t-2xl flex items-center justify-between">
            <h3 class="text-xl font-bold flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Register Your Face
            </h3>
            <button onclick="closeFaceRegistration()" class="text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 space-y-6">
            <!-- Instructions -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="font-semibold text-blue-900 mb-2">📋 Instructions:</h4>
                <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                    <li>Position your face in the center of the camera</li>
                    <li>Ensure good lighting (not too dark or bright)</li>
                    <li>Look directly at the camera with a neutral expression</li>
                    <li>Remove sunglasses or anything covering your face</li>
                    <li>Wait for the system to detect your face</li>
                </ul>
            </div>

            <!-- Camera Container -->
            <div class="relative">
                <video id="faceVideo" class="w-full rounded-lg border-4 border-gray-300" autoplay muted playsinline style="max-height: 400px;"></video>
                <canvas id="faceCanvas" class="hidden"></canvas>
                
                <!-- Face Detection Overlay -->
                <div id="faceDetectionOverlay" class="hidden absolute inset-0 flex items-center justify-center">
                    <div class="bg-green-500 bg-opacity-75 rounded-lg p-4 text-white font-bold">
                        ✓ Face Detected!
                    </div>
                </div>

                <!-- Loading Overlay -->
                <div id="loadingOverlay" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center rounded-lg">
                    <div class="text-center text-white">
                        <svg class="animate-spin h-12 w-12 mx-auto mb-3" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p id="loadingText">Loading face detection models...</p>
                    </div>
                </div>
            </div>

            <!-- Status Messages -->
            <div id="faceStatus" class="text-center text-sm"></div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4">
                <button type="button" onclick="closeFaceRegistration()" 
                        class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="button" id="captureFaceBtn" onclick="captureFace()" disabled
                        class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                    Capture & Register
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Load Face-API.js -->
<script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

<script>
    let faceStream = null;
    let faceModelsLoaded = false;
    let detectedFaceDescriptor = null;

    function calculateRequiredDays() {
        const hours = parseFloat(document.getElementById('required_hours').value) || 590;
        const days = Math.ceil(hours / 7.867); // 7.867 = 590/75
        document.getElementById('required_days').textContent = days;
    }

    async function openFaceRegistration() {
        document.getElementById('faceRegistrationModal').classList.remove('hidden');
        document.getElementById('loadingOverlay').classList.remove('hidden');
        document.getElementById('captureFaceBtn').disabled = true;
        
        try {
            // Load face-api.js models if not already loaded
            if (!faceModelsLoaded) {
                document.getElementById('loadingText').textContent = 'Loading face detection models...';
                await Promise.all([
                    faceapi.nets.tinyFaceDetector.loadFromUri('https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model'),
                    faceapi.nets.faceLandmark68Net.loadFromUri('https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model'),
                    faceapi.nets.faceRecognitionNet.loadFromUri('https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model')
                ]);
                faceModelsLoaded = true;
            }

            // Start camera
            document.getElementById('loadingText').textContent = 'Starting camera...';
            faceStream = await navigator.mediaDevices.getUserMedia({ 
                video: { 
                    facingMode: 'user',
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                } 
            });
            
            const video = document.getElementById('faceVideo');
            video.srcObject = faceStream;
            
            await video.play();
            
            document.getElementById('loadingOverlay').classList.add('hidden');
            
            // Start face detection loop
            detectFace();
            
        } catch (error) {
            console.error('Error starting face registration:', error);
            alert('Could not access camera. Please check permissions and try again.');
            closeFaceRegistration();
        }
    }

    async function detectFace() {
        const video = document.getElementById('faceVideo');
        const statusDiv = document.getElementById('faceStatus');
        const captureBtn = document.getElementById('captureFaceBtn');
        const overlay = document.getElementById('faceDetectionOverlay');
        
        const detect = async () => {
            if (!faceStream) return;
            
            try {
                const detection = await faceapi
                    .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
                    .withFaceLandmarks()
                    .withFaceDescriptor();
                
                if (detection) {
                    // Face detected
                    detectedFaceDescriptor = detection.descriptor;
                    statusDiv.innerHTML = '<span class="text-green-600 font-semibold">✓ Face detected! Ready to capture.</span>';
                    captureBtn.disabled = false;
                    overlay.classList.remove('hidden');
                    
                    // Draw detection box (optional)
                    const canvas = document.getElementById('faceCanvas');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    
                } else {
                    // No face detected
                    statusDiv.innerHTML = '<span class="text-yellow-600">⚠ No face detected. Please position your face in the camera.</span>';
                    captureBtn.disabled = true;
                    overlay.classList.add('hidden');
                    detectedFaceDescriptor = null;
                }
                
                // Continue detection loop
                setTimeout(detect, 100);
                
            } catch (error) {
                console.error('Detection error:', error);
                setTimeout(detect, 100);
            }
        };
        
        detect();
    }

    async function captureFace() {
        if (!detectedFaceDescriptor) {
            alert('No face detected. Please try again.');
            return;
        }
        
        const captureBtn = document.getElementById('captureFaceBtn');
        captureBtn.disabled = true;
        captureBtn.textContent = 'Registering...';
        
        try {
            // Convert descriptor to JSON string
            const descriptorArray = Array.from(detectedFaceDescriptor);
            const descriptorJson = JSON.stringify(descriptorArray);
            
            // Send to server
            const response = await fetch('{{ route("profile.register-face") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    face_descriptor: descriptorJson
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                alert('✓ Face registered successfully!');
                closeFaceRegistration();
                location.reload();
            } else {
                alert('Failed to register face. Please try again.');
                captureBtn.disabled = false;
                captureBtn.textContent = 'Capture & Register';
            }
            
        } catch (error) {
            console.error('Error registering face:', error);
            alert('Error registering face. Please try again.');
            captureBtn.disabled = false;
            captureBtn.textContent = 'Capture & Register';
        }
    }

    function closeFaceRegistration() {
        // Stop camera
        if (faceStream) {
            faceStream.getTracks().forEach(track => track.stop());
            faceStream = null;
        }
        
        // Reset UI
        document.getElementById('faceRegistrationModal').classList.add('hidden');
        document.getElementById('faceVideo').srcObject = null;
        document.getElementById('faceStatus').innerHTML = '';
        document.getElementById('captureFaceBtn').disabled = true;
        document.getElementById('captureFaceBtn').textContent = 'Capture & Register';
        document.getElementById('faceDetectionOverlay').classList.add('hidden');
        detectedFaceDescriptor = null;
    }
</script>
@endsection
