@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-cyan-600 rounded-3xl shadow-xl p-8 text-white overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>
        
        <div class="relative z-10">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                    <span class="text-2xl">👋</span>
                </div>
                <h2 class="text-3xl font-bold">Welcome back, {{ auth()->user()->name }}!</h2>
            </div>
            <p class="text-blue-100 text-lg">Track your OJT progress and manage your daily time records</p>
            @if(auth()->user()->school)
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium">📚 {{ auth()->user()->school }}</span>
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium">{{ auth()->user()->required_hours ?? 590 }} hours ({{ auth()->user()->getRequiredDays() }} days)</span>
                </div>
            @endif
        </div>
    </div>

    {{-- Completion Banner --}}
    @if($progressPercentage >= 100)
    <div class="relative bg-gradient-to-r from-green-500 to-emerald-600 rounded-3xl shadow-xl p-8 text-white overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>
        
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div class="flex items-center space-x-5">
                <div class="flex-shrink-0 w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold mb-1">🎉 Congratulations! OJT Complete!</h3>
                    <p class="text-green-100">You have fully rendered all your required OJT hours. Great job, {{ auth()->user()->name }}!</p>
                </div>
            </div>
            <a href="{{ route('certificate.view') }}" class="flex-shrink-0 inline-flex items-center justify-center px-6 py-3 bg-white text-green-700 font-bold rounded-2xl shadow-lg hover:bg-green-50 hover:scale-105 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                View Certificate
            </a>
        </div>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Rendered Hours -->
        <div class="group relative bg-slate-900 rounded-3xl shadow-xl hover:shadow-2xl hover:shadow-green-500/20 p-6 border border-slate-700 overflow-hidden transition-all duration-300 hover:-translate-y-1">
            <!-- Decorative corner accent -->
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-green-400 to-emerald-500 opacity-20 rounded-bl-[60px]"></div>
            <div class="absolute bottom-0 left-0 w-16 h-16 bg-green-400 opacity-10 rounded-tr-[40px]"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-green-400 to-emerald-500 rounded-2xl shadow-lg shadow-green-500/50 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex space-x-1">
                        <span class="w-2 h-2 bg-green-400 rounded-full shadow-sm shadow-green-400"></span>
                        <span class="w-2 h-2 bg-green-300 rounded-full shadow-sm shadow-green-300"></span>
                        <span class="w-2 h-2 bg-green-200 rounded-full shadow-sm shadow-green-200"></span>
                    </div>
                </div>
                <h3 class="text-slate-400 text-xs font-bold mb-2 uppercase tracking-wider">Total Rendered Hours</h3>
                <p class="text-4xl font-black bg-gradient-to-r from-green-400 to-emerald-400 bg-clip-text text-transparent">{{ number_format($totalHours, 2) }}</p>
                <p class="text-sm text-slate-500 mt-2">Out of {{ auth()->user()->required_hours ?? 590 }} hours</p>
            </div>
        </div>

        <!-- Remaining Hours -->
        <div class="group relative bg-slate-900 rounded-3xl shadow-xl hover:shadow-2xl hover:shadow-orange-500/20 p-6 border {{ $progressPercentage >= 100 ? 'border-green-500/30' : 'border-slate-700' }} overflow-hidden transition-all duration-300 hover:-translate-y-1">
            <!-- Decorative corner accent -->
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br {{ $progressPercentage >= 100 ? 'from-green-400 to-emerald-500' : 'from-orange-400 to-red-500' }} opacity-20 rounded-bl-[60px]"></div>
            <div class="absolute bottom-0 left-0 w-16 h-16 {{ $progressPercentage >= 100 ? 'bg-green-400' : 'bg-orange-400' }} opacity-10 rounded-tr-[40px]"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br {{ $progressPercentage >= 100 ? 'from-green-400 to-emerald-500' : 'from-orange-400 to-red-500' }} rounded-2xl shadow-lg {{ $progressPercentage >= 100 ? 'shadow-green-500/50' : 'shadow-orange-500/50' }} group-hover:scale-110 transition-transform">
                        @if($progressPercentage >= 100)
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="flex space-x-1">
                        <span class="w-2 h-2 {{ $progressPercentage >= 100 ? 'bg-green-400 shadow-sm shadow-green-400' : 'bg-orange-400 shadow-sm shadow-orange-400' }} rounded-full"></span>
                        <span class="w-2 h-2 {{ $progressPercentage >= 100 ? 'bg-green-300 shadow-sm shadow-green-300' : 'bg-orange-300 shadow-sm shadow-orange-300' }} rounded-full"></span>
                        <span class="w-2 h-2 {{ $progressPercentage >= 100 ? 'bg-green-200 shadow-sm shadow-green-200' : 'bg-orange-200 shadow-sm shadow-orange-200' }} rounded-full"></span>
                    </div>
                </div>
                <h3 class="text-slate-400 text-xs font-bold mb-2 uppercase tracking-wider">Remaining Hours</h3>
                <p class="text-4xl font-black bg-gradient-to-r {{ $progressPercentage >= 100 ? 'from-green-400 to-emerald-400' : 'from-orange-400 to-red-400' }} bg-clip-text text-transparent">{{ number_format($remainingHours, 2) }}</p>
                <p class="text-sm mt-2 {{ $progressPercentage >= 100 ? 'text-green-400 font-semibold' : 'text-slate-500' }}">
                    {{ $progressPercentage >= 100 ? '🎉 OJT Complete!' : $remainingDays . ' days remaining' }}
                </p>
            </div>
        </div>

        <!-- Progress Percentage -->
        <div class="group relative bg-slate-900 rounded-3xl shadow-xl hover:shadow-2xl hover:shadow-blue-500/20 p-6 border border-slate-700 overflow-hidden transition-all duration-300 hover:-translate-y-1">
            <!-- Decorative corner accent -->
            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-500 opacity-20 rounded-bl-[60px]"></div>
            <div class="absolute bottom-0 left-0 w-16 h-16 bg-blue-500 opacity-10 rounded-tr-[40px]"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl shadow-lg shadow-blue-500/50 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <div class="flex space-x-1">
                        <span class="w-2 h-2 bg-blue-400 rounded-full shadow-sm shadow-blue-400"></span>
                        <span class="w-2 h-2 bg-blue-300 rounded-full shadow-sm shadow-blue-300"></span>
                        <span class="w-2 h-2 bg-cyan-300 rounded-full shadow-sm shadow-cyan-300"></span>
                    </div>
                </div>
                <h3 class="text-slate-400 text-xs font-bold mb-2 uppercase tracking-wider">Overall Progress</h3>
                <p class="text-4xl font-black bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">{{ number_format($progressPercentage, 2) }}%</p>
                <div class="w-full bg-slate-800 rounded-full h-3 mt-3 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-cyan-500 h-3 rounded-full transition-all duration-500 shadow-md shadow-blue-500/50" style="width: {{ min(100, $progressPercentage) }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- DTR Section & Quick Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Today's DTR -->
        <div class="lg:col-span-2 relative bg-slate-900 rounded-3xl shadow-xl border border-slate-700 p-6 overflow-hidden">
            <!-- Decorative wavy line -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-cyan-500 to-teal-500 shadow-sm shadow-cyan-500/50"></div>
            
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse shadow-sm shadow-blue-500"></span>
                    Today's Time Record
                </h3>
                <span class="px-3 py-1 bg-slate-800 rounded-full text-sm text-slate-300 font-medium border border-slate-700">{{ now()->format('l, F j, Y') }}</span>
            </div>

            @if($todayDtr)
                <!-- DTR Status -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-slate-800 rounded-lg border border-slate-700">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-green-500/20 rounded-lg border border-green-500/30">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-300">Time In</p>
                                <p class="text-lg font-bold text-green-400">{{ $todayDtr->time_in ? \Carbon\Carbon::parse($todayDtr->time_in)->format('h:i A') : 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <div>
                                <p class="text-sm font-medium text-slate-300 text-right">Time Out</p>
                                <p class="text-lg font-bold {{ $todayDtr->time_out ? 'text-red-400' : 'text-slate-500' }} text-right">
                                    {{ $todayDtr->time_out ? \Carbon\Carbon::parse($todayDtr->time_out)->format('h:i A') : 'Not yet' }}
                                </p>
                            </div>
                            @if(!$todayDtr->time_out)
                                <div class="p-2 bg-slate-700 rounded-lg border border-slate-600">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            @else
                                <div class="p-2 bg-red-500/20 rounded-lg border border-red-500/30">
                                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($todayDtr->status === 'completed')
                        <div class="p-4 bg-green-500/20 border border-green-500/30 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="font-semibold text-green-400">DTR Completed</p>
                                    <p class="text-sm text-green-300">Total hours today: <span class="font-bold">{{ number_format($todayDtr->total_hours, 2) }} hours</span></p>
                                </div>
                            </div>
                        </div>
                    @else
                        <form method="POST" action="{{ route('dtr.timeout') }}" id="timeOutForm">
                            @csrf
                            <div class="mb-4 flex items-center justify-center space-x-2">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" id="manualTimeOut" class="mr-2 rounded border-slate-600 bg-slate-800 text-red-500 focus:ring-red-500 focus:ring-offset-slate-900">
                                    <span class="text-sm text-slate-300">Manual time entry</span>
                                </label>
                            </div>
                            <div id="manualTimeOutInput" class="hidden mb-4 flex justify-center">
                                <input type="time" name="manual_time_out" class="px-3 py-2 bg-slate-800 border border-slate-600 text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div class="mb-4">
                                <textarea name="notes" rows="2" placeholder="Notes (optional)" class="w-full px-3 py-2 bg-slate-800 border border-slate-600 text-slate-200 placeholder-slate-500 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">{{ $todayDtr->notes ?? '' }}</textarea>
                            </div>
                            <input type="hidden" name="face_photo" id="timeOutFacePhoto">
                            <input type="hidden" name="face_confidence" id="timeOutFaceConfidence">
                            <button type="button" onclick="openFaceVerificationModal('timeout')" class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white py-3 rounded-lg font-semibold hover:from-red-600 hover:to-red-700 transition duration-200 shadow-lg shadow-red-500/30">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span>Verify Face & Time Out</span>
                                </div>
                            </button>
                        </form>
                    @endif
                </div>
            @else
                <!-- No DTR Today -->
                @if($progressPercentage >= 100)
                    {{-- OJT Complete — hide Time In --}}
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-500/20 rounded-full mb-4 border border-green-500/30">
                            <svg class="w-8 h-8 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-green-400 mb-2">OJT Hours Completed!</h4>
                        <p class="text-slate-400">You have rendered all your required OJT hours.<br>No further time-in is needed.</p>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-500/20 rounded-full mb-4 border border-blue-500/30">
                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-white mb-2">No Time Record Yet</h4>
                        <p class="text-slate-400 mb-6">Click the button below to start your day</p>
                        
                        <form method="POST" action="{{ route('dtr.timein') }}" id="timeInForm">
                            @csrf
                            <div class="mb-4 flex items-center justify-center space-x-2">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" id="manualTimeIn" class="mr-2 rounded border-slate-600 bg-slate-800 text-blue-500 focus:ring-blue-500 focus:ring-offset-slate-900">
                                    <span class="text-sm text-slate-300">Manual time entry</span>
                                </label>
                            </div>
                            <div id="manualTimeInInput" class="hidden mb-4 flex justify-center">
                                <input type="time" name="manual_time_in" class="px-3 py-2 bg-slate-800 border border-slate-600 text-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="mb-4">
                                <textarea name="notes" rows="2" placeholder="Notes (optional)" class="w-full px-3 py-2 bg-slate-800 border border-slate-600 text-slate-200 placeholder-slate-500 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                            <input type="hidden" name="face_photo" id="timeInFacePhoto">
                            <input type="hidden" name="face_confidence" id="timeInFaceConfidence">
                            <button type="button" onclick="openFaceVerificationModal('timein')" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-cyan-700 transition duration-200 shadow-lg shadow-blue-500/30">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Verify Face & Time In
                            </button>
                        </form>
                    </div>
                @endif
            @endif
        </div>

        <!-- Quick Stats -->
        <div class="space-y-6">
            <!-- This Week -->
            <div class="group relative bg-slate-900 rounded-3xl shadow-xl hover:shadow-2xl hover:shadow-blue-500/20 p-6 border border-slate-700 overflow-hidden transition-all duration-300 hover:-translate-y-1">
                <!-- Decorative corner -->
                <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-br from-blue-400 to-cyan-500 opacity-20 rounded-bl-[50px]"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-white">This Week</h3>
                        <div class="p-2 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-xl shadow-md shadow-blue-500/50">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-slate-800 rounded-xl border border-slate-700">
                            <span class="text-slate-400 text-sm">Days Completed</span>
                            <span class="font-black text-lg text-white">{{ $weekDays }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-500/20 to-cyan-500/20 rounded-xl border border-blue-500/30">
                            <span class="text-slate-300 text-sm">Total Hours</span>
                            <span class="font-black text-lg bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">{{ number_format($weekHours, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- This Month -->
            <div class="group relative bg-slate-900 rounded-3xl shadow-xl hover:shadow-2xl hover:shadow-teal-500/20 p-6 border border-slate-700 overflow-hidden transition-all duration-300 hover:-translate-y-1">
                <!-- Decorative corner -->
                <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-br from-teal-400 to-emerald-500 opacity-20 rounded-bl-[50px]"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-white">This Month</h3>
                        <div class="p-2 bg-gradient-to-br from-teal-400 to-emerald-500 rounded-xl shadow-md shadow-teal-500/50">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-slate-800 rounded-xl border border-slate-700">
                            <span class="text-slate-400 text-sm">Days Completed</span>
                            <span class="font-black text-lg text-white">{{ $monthDays }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gradient-to-r from-teal-500/20 to-emerald-500/20 rounded-xl border border-teal-500/30">
                            <span class="text-slate-300 text-sm">Total Hours</span>
                            <span class="font-black text-lg bg-gradient-to-r from-teal-400 to-emerald-400 bg-clip-text text-transparent">{{ number_format($monthHours, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="relative bg-slate-900 rounded-3xl shadow-xl p-6 border border-slate-700 overflow-hidden">
        <!-- Decorative wavy line -->
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-cyan-500 to-teal-500 shadow-sm shadow-cyan-500/50"></div>
        
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
            <span class="w-2 h-2 bg-cyan-500 rounded-full mr-2 animate-pulse shadow-sm shadow-cyan-500"></span>
            Recent Activity
        </h3>
        <div class="space-y-3">
            @forelse($recentDtrs as $dtr)
                <div class="group flex items-center justify-between p-4 bg-gradient-to-r from-slate-800 to-slate-800/50 rounded-2xl hover:shadow-lg hover:shadow-blue-500/20 transition-all duration-200 border border-slate-700 hover:border-blue-500/50">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl shadow-md shadow-blue-500/50 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-white">{{ \Carbon\Carbon::parse($dtr->date)->format('F j, Y') }}</p>
                            <p class="text-sm text-slate-400">
                                {{ $dtr->time_in ? \Carbon\Carbon::parse($dtr->time_in)->format('h:i A') : 'N/A' }} - 
                                {{ $dtr->time_out ? \Carbon\Carbon::parse($dtr->time_out)->format('h:i A') : 'In Progress' }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-black bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent mb-1">{{ number_format($dtr->total_hours, 2) }} hrs</p>
                        <span class="inline-block px-3 py-1 text-xs font-bold rounded-full {{ $dtr->status === 'completed' ? 'bg-gradient-to-r from-green-400 to-emerald-500 text-white shadow-sm shadow-green-500/50' : 'bg-gradient-to-r from-yellow-400 to-orange-500 text-white shadow-sm shadow-orange-500/50' }}">
                            {{ ucfirst($dtr->status) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-slate-400">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-slate-800 to-slate-700 rounded-3xl mb-4 border border-slate-600">
                        <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <p class="font-semibold text-slate-300">No DTR records yet!</p>
                    <p class="text-sm mt-1 text-slate-500">Start tracking your time to see activity here.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Face Verification Modal -->
    <div id="faceVerificationModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4">
        <div class="bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full border border-slate-700">
            <div class="p-6">
                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-white">Verify Your Face</h2>
                    <button onclick="closeFaceVerificationModal()" class="text-slate-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Camera Container -->
                <div class="relative bg-slate-900 rounded-lg overflow-hidden mb-4 border border-slate-700" style="aspect-ratio: 4/3;">
                    <video id="verifyFaceVideo" autoplay muted playsinline class="w-full h-full object-cover"></video>
                    
                    <!-- Face Detection Overlay -->
                    <div id="verifyFaceOverlay" class="absolute inset-0 pointer-events-none"></div>
                    
                    <!-- Status Messages -->
                    <div class="absolute top-4 left-4 right-4">
                        <div class="bg-slate-900/90 backdrop-blur-sm rounded-lg px-4 py-2 text-sm font-medium text-center border border-slate-700">
                            <span id="verifyFaceStatus" class="text-cyan-400">Initializing camera...</span>
                        </div>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="bg-gradient-to-br from-blue-500/20 to-cyan-500/20 border border-blue-500/30 rounded-lg p-3 mb-4">
                    <p class="text-sm text-slate-200">
                        <strong class="text-cyan-400">Face Verification:</strong><br>
                        • Your face will be compared with registered face<br>
                        • Match must be ≥60% to proceed<br>
                        • Ensure good lighting and look directly at camera
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <button type="button" onclick="closeFaceVerificationModal()" 
                            class="flex-1 px-4 py-2 border border-slate-600 text-slate-300 rounded-lg hover:bg-slate-700 transition">
                        Cancel
                    </button>
                    <button type="button" id="verifyFaceBtn" onclick="verifyAndSubmit()" disabled
                            class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg hover:from-blue-700 hover:to-cyan-700 transition disabled:opacity-50 disabled:cursor-not-allowed shadow-lg shadow-blue-500/30">
                        Verify & Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tour is now rendered in layouts/app.blade.php --}}
@if(false)
<div id="ojt-tour-overlay" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-[999] flex items-center justify-center p-4">
    <div class="relative bg-slate-900 border border-slate-700 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">

        {{-- Top accent bar --}}
        <div class="h-1 w-full bg-gradient-to-r from-blue-500 via-cyan-500 to-teal-500"></div>

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 pt-5 pb-2">
            <div id="tour-step-badge" class="text-xs font-bold text-cyan-400 uppercase tracking-widest"></div>
            <button onclick="ojt_tour_close()" class="text-slate-500 hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="px-6 pb-4" id="tour-body">
            <div id="tour-emoji" class="text-4xl mb-3"></div>
            <h2 id="tour-title" class="text-xl font-bold text-white mb-2"></h2>
            <p id="tour-desc" class="text-slate-400 text-sm leading-relaxed"></p>

            {{-- Preview card --}}
            <div id="tour-preview" class="mt-4 rounded-xl border border-slate-700 bg-slate-800 p-4 hidden"></div>
        </div>

        {{-- Progress dots --}}
        <div class="flex items-center justify-center gap-1.5 pb-4" id="tour-dots"></div>

        {{-- Footer buttons --}}
        <div class="flex items-center justify-between px-6 pb-6 gap-3">
            <button onclick="ojt_tour_close()" class="text-sm text-slate-500 hover:text-slate-300 transition">Skip — close tour</button>
            <div class="flex gap-2">
                <button id="tour-back-btn" onclick="ojt_tour_prev()" class="hidden px-4 py-2 text-sm font-medium text-slate-300 border border-slate-600 rounded-lg hover:bg-slate-800 transition">← Back</button>
                <button id="tour-next-btn" onclick="ojt_tour_next()" class="px-5 py-2 text-sm font-bold bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg hover:from-blue-700 hover:to-cyan-700 transition shadow-lg shadow-blue-500/30">Next →</button>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    const userName = @json(auth()->user()->name);
    const requiredHours = @json(auth()->user()->required_hours ?? 590);
    const school = @json(auth()->user()->school ?? '');

    const steps = [
        {
            badge: '',
            emoji: '👋',
            title: 'Hey ' + userName + ', welcome to OJTracker!',
            desc: 'A quick walk-through of your dashboard. Use the buttons or press ← → keys to navigate.',
            preview: null,
        },
        {
            badge: 'Step 1 of 5',
            emoji: '📊',
            title: 'Your three key numbers',
            desc: 'At a glance — your Total Rendered Hours, Remaining Hours, and Overall Progress %. These update every time you log a DTR.',
            preview: '<div class="grid grid-cols-3 gap-2 text-center"><div class="bg-slate-900 rounded-lg p-2 border border-slate-700"><p class="text-xs text-slate-500 mb-1">Rendered</p><p class="text-lg font-black text-green-400">0.00</p></div><div class="bg-slate-900 rounded-lg p-2 border border-slate-700"><p class="text-xs text-slate-500 mb-1">Remaining</p><p class="text-lg font-black text-orange-400">' + requiredHours + '</p></div><div class="bg-slate-900 rounded-lg p-2 border border-slate-700"><p class="text-xs text-slate-500 mb-1">Progress</p><p class="text-lg font-black text-cyan-400">0%</p></div></div>',
        },
        {
            badge: 'Step 2 of 5',
            emoji: '⏱',
            title: 'Daily Time Record (DTR)',
            desc: 'Log your Time In and Time Out every day using face recognition. Your total hours are computed automatically — no manual math needed.',
            preview: '<div class="flex items-center justify-between bg-slate-900 rounded-lg p-3 border border-slate-700"><div><p class="text-xs text-slate-500">Time In</p><p class="text-green-400 font-bold text-sm">8:00 AM</p></div><div class="text-slate-600 text-lg">→</div><div><p class="text-xs text-slate-500">Time Out</p><p class="text-red-400 font-bold text-sm">5:00 PM</p></div><div class="bg-green-500/20 border border-green-500/30 rounded-lg px-3 py-1"><p class="text-green-400 font-bold text-sm">8h</p></div></div>',
        },
        {
            badge: 'Step 3 of 5',
            emoji: '✅',
            title: 'Accomplishments',
            desc: 'Log your daily tasks and accomplishments for easy DTR logbook reference. Access it from the sidebar → Accomplishments.',
            preview: '<div class="space-y-2"><div class="flex items-center gap-2 bg-slate-900 rounded-lg p-2 border border-slate-700"><span class="text-green-400 text-sm">✓</span><p class="text-slate-300 text-xs">Assisted supervisor with daily office tasks</p></div><div class="flex items-center gap-2 bg-slate-900 rounded-lg p-2 border border-slate-700"><span class="text-green-400 text-sm">✓</span><p class="text-slate-300 text-xs">Prepared and submitted required documents</p></div></div>',
        },
        {
            badge: 'Step 4 of 5',
            emoji: '📈',
            title: 'Reports & PDF Export',
            desc: 'Generate a full summary report of your DTR logs and export it as PDF for submission to your school or supervisor.',
            preview: '<div class="flex items-center gap-3 bg-slate-900 rounded-lg p-3 border border-slate-700"><div class="p-2 bg-blue-500/20 border border-blue-500/30 rounded-lg"><svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div><div><p class="text-white text-sm font-semibold">DTR Summary Report</p><p class="text-slate-400 text-xs">Export as PDF for submission</p></div></div>',
        },
        {
            badge: 'Step 5 of 5',
            emoji: '🎓',
            title: 'Certificate of Completion',
            desc: 'Once you reach 100% of your required ' + requiredHours + ' hours, a Certificate of Completion will automatically unlock on your dashboard. Download it as an image!',
            preview: '<div class="flex items-center gap-3 bg-gradient-to-r from-green-500/20 to-emerald-500/20 rounded-lg p-3 border border-green-500/30"><div class="text-3xl">🏆</div><div><p class="text-green-400 text-sm font-bold">Certificate Unlocks at 100%</p><p class="text-slate-400 text-xs">Required: ' + requiredHours + ' hours' + (school ? ' · ' + school : '') + '</p></div></div>',
        },
        {
            badge: 'All Done!',
            emoji: '🚀',
            title: "You're all set, " + userName + '!',
            desc: 'You have ' + requiredHours + ' hours to complete — start logging and watch that progress bar climb! You can replay this tour anytime by clicking the 🔄 replay icon in the top navigation bar.',
            preview: null,
        },
    ];

    let current = 0;

    function render() {
        const s = steps[current];
        document.getElementById('tour-step-badge').textContent = s.badge;
        document.getElementById('tour-emoji').textContent = s.emoji;
        document.getElementById('tour-title').textContent = s.title;
        document.getElementById('tour-desc').textContent = s.desc;

        const preview = document.getElementById('tour-preview');
        if (s.preview) {
            preview.innerHTML = s.preview;
            preview.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
        }

        // Dots
        const dotsEl = document.getElementById('tour-dots');
        dotsEl.innerHTML = '';
        steps.forEach((_, i) => {
            const d = document.createElement('span');
            d.className = 'rounded-full transition-all duration-300 ' + (i === current ? 'w-5 h-2 bg-cyan-400' : 'w-2 h-2 bg-slate-600');
            dotsEl.appendChild(d);
        });

        // Back button
        const backBtn = document.getElementById('tour-back-btn');
        if (current === 0) backBtn.classList.add('hidden');
        else backBtn.classList.remove('hidden');

        // Next button label
        const nextBtn = document.getElementById('tour-next-btn');
        nextBtn.textContent = current === steps.length - 1 ? '✓ Close Tour' : 'Next →';
    }

    window.ojt_tour_next = function() {
        if (current < steps.length - 1) { current++; render(); }
        else ojt_tour_close();
    };

    window.ojt_tour_prev = function() {
        if (current > 0) { current--; render(); }
    };

    window.ojt_tour_close = function() {
        document.getElementById('ojt-tour-overlay').remove();
        fetch('{{ route("tour.complete") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
        });
    };

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (!document.getElementById('ojt-tour-overlay')) return;
        if (e.key === 'ArrowRight' || e.key === 'Enter') ojt_tour_next();
        if (e.key === 'ArrowLeft') ojt_tour_prev();
        if (e.key === 'Escape') ojt_tour_close();
    });

    render();
})();
</script>
@endif
{{-- ===================== END TOUR ===================== --}}

<!-- Face-API.js Library -->
<script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.min.js"></script>
<script defer src="{{ asset('js/face-verification.js') }}"></script>

<script>
    // Set user face descriptor from Laravel
    window.addEventListener('load', function() {
        const userDescriptor = @json(auth()->user()->face_descriptor ? json_decode(auth()->user()->face_descriptor) : null);
        if (userDescriptor && typeof setUserFaceDescriptor === 'function') {
            setUserFaceDescriptor(userDescriptor);
        }
    });

    // Toggle manual time in input
    const manualTimeInCheckbox = document.getElementById('manualTimeIn');
    const manualTimeInInput = document.getElementById('manualTimeInInput');
    
    if (manualTimeInCheckbox) {
        manualTimeInCheckbox.addEventListener('change', function() {
            if (this.checked) {
                manualTimeInInput.classList.remove('hidden');
            } else {
                manualTimeInInput.classList.add('hidden');
            }
        });
    }
    
    // Toggle manual time out input
    const manualTimeOutCheckbox = document.getElementById('manualTimeOut');
    const manualTimeOutInput = document.getElementById('manualTimeOutInput');
    
    if (manualTimeOutCheckbox) {
        manualTimeOutCheckbox.addEventListener('change', function() {
            if (this.checked) {
                manualTimeOutInput.classList.remove('hidden');
            } else {
                manualTimeOutInput.classList.add('hidden');
            }
        });
    }
</script>
@endsection
