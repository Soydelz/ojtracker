@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
        <h2 class="text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h2>
        <p class="text-indigo-100">Track your OJT progress and manage your daily time records</p>
        @if(auth()->user()->school)
            <p class="text-indigo-100 mt-1 text-sm">📚 {{ auth()->user()->school }} • {{ auth()->user()->required_hours ?? 590 }} hours ({{ auth()->user()->getRequiredDays() }} days)</p>
        @endif
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total Rendered Hours -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-500 text-sm font-medium mb-1">Total Rendered Hours</h3>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($totalHours, 2) }}</p>
            <p class="text-sm text-gray-500 mt-2">Out of {{ auth()->user()->required_hours ?? 590 }} hours required</p>
        </div>

        <!-- Remaining Hours -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-orange-100 rounded-lg">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-500 text-sm font-medium mb-1">Remaining Hours</h3>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($remainingHours, 2) }}</p>
            <p class="text-sm text-gray-500 mt-2">{{ $remainingDays }} days remaining</p>
        </div>

        <!-- Progress Percentage -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-indigo-100 rounded-lg">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-500 text-sm font-medium mb-1">Overall Progress</h3>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($progressPercentage, 2) }}%</p>
            <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 h-2 rounded-full transition-all duration-500" style="width: {{ min(100, $progressPercentage) }}%"></div>
            </div>
        </div>
    </div>

    <!-- DTR Section & Quick Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Today's DTR -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Today's Time Record</h3>
                <span class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</span>
            </div>

            @if($todayDtr)
                <!-- DTR Status -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Time In</p>
                                <p class="text-lg font-bold text-green-600">{{ $todayDtr->time_in ? \Carbon\Carbon::parse($todayDtr->time_in)->format('h:i A') : 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <div>
                                <p class="text-sm font-medium text-gray-900 text-right">Time Out</p>
                                <p class="text-lg font-bold {{ $todayDtr->time_out ? 'text-red-600' : 'text-gray-400' }} text-right">
                                    {{ $todayDtr->time_out ? \Carbon\Carbon::parse($todayDtr->time_out)->format('h:i A') : 'Not yet' }}
                                </p>
                            </div>
                            @if(!$todayDtr->time_out)
                                <div class="p-2 bg-gray-100 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            @else
                                <div class="p-2 bg-red-100 rounded-lg">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($todayDtr->status === 'completed')
                        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="font-semibold text-green-900">DTR Completed</p>
                                    <p class="text-sm text-green-700">Total hours today: <span class="font-bold">{{ number_format($todayDtr->total_hours, 2) }} hours</span></p>
                                </div>
                            </div>
                        </div>
                    @else
                        <form method="POST" action="{{ route('dtr.timeout') }}" id="timeOutForm">
                            @csrf
                            <div class="mb-4 flex items-center justify-center space-x-2">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" id="manualTimeOut" class="mr-2 rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    <span class="text-sm text-gray-600">Manual time entry</span>
                                </label>
                            </div>
                            <div id="manualTimeOutInput" class="hidden mb-4 flex justify-center">
                                <input type="time" name="manual_time_out" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div class="mb-4">
                                <textarea name="notes" rows="2" placeholder="Notes (optional)" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">{{ $todayDtr->notes ?? '' }}</textarea>
                            </div>
                            <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white py-3 rounded-lg font-semibold hover:from-red-600 hover:to-red-700 transition duration-200 shadow-lg">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    <span>Time Out Now</span>
                                </div>
                            </button>
                        </form>
                    @endif
                </div>
            @else
                <!-- No DTR Today -->
                <div class="text-center py-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mb-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-2">No Time Record Yet</h4>
                    <p class="text-gray-500 mb-6">Click the button below to start your day</p>
                    
                    <form method="POST" action="{{ route('dtr.timein') }}" id="timeInForm">
                        @csrf
                        <div class="mb-4 flex items-center justify-center space-x-2">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" id="manualTimeIn" class="mr-2 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-gray-600">Manual time entry</span>
                            </label>
                        </div>
                        <div id="manualTimeInInput" class="hidden mb-4 flex justify-center">
                            <input type="time" name="manual_time_in" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div class="mb-4">
                            <textarea name="notes" rows="2" placeholder="Notes (optional)" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Time In Now
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Quick Stats -->
        <div class="space-y-6">
            <!-- This Week -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4">This Week</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Days Completed</span>
                        <span class="font-bold text-gray-900">{{ $weekDays }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Total Hours</span>
                        <span class="font-bold text-indigo-600">{{ number_format($weekHours, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- This Month -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4">This Month</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Days Completed</span>
                        <span class="font-bold text-gray-900">{{ $monthDays }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Total Hours</span>
                        <span class="font-bold text-indigo-600">{{ number_format($monthHours, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Activity</h3>
        <div class="space-y-3">
            @forelse($recentDtrs as $dtr)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <div class="flex items-center space-x-4">
                        <div class="p-2 bg-indigo-100 rounded-lg">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($dtr->date)->format('F j, Y') }}</p>
                            <p class="text-sm text-gray-500">
                                {{ $dtr->time_in ? \Carbon\Carbon::parse($dtr->time_in)->format('h:i A') : 'N/A' }} - 
                                {{ $dtr->time_out ? \Carbon\Carbon::parse($dtr->time_out)->format('h:i A') : 'In Progress' }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-900">{{ number_format($dtr->total_hours, 2) }} hrs</p>
                        <span class="inline-block px-2 py-1 text-xs font-medium rounded-full {{ $dtr->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($dtr->status) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p>No DTR records yet. Start tracking your time!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
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
