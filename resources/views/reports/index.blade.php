@extends('layouts.app')

@section('title', 'Reports')
@section('page-title', 'Reports')

@section('content')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">OJT Reports</h2>
            <p class="text-gray-600 mt-1">Generate and export your OJT progress reports</p>
        </div>
        
        <!-- Export PDF Button -->
        <form method="POST" action="{{ route('reports.export-pdf') }}">
            @csrf
            <input type="hidden" name="filter" value="{{ $filter }}">
            <input type="hidden" name="start_date" value="{{ $startDate }}">
            <input type="hidden" name="end_date" value="{{ $endDate }}">
            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-pink-600 text-white font-semibold rounded-lg hover:from-red-700 hover:to-pink-700 transition duration-200 shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export to PDF
            </button>
        </form>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Filter Reports</h3>
        
        <form method="GET" action="{{ route('reports.index') }}" id="filterForm">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Preset Filters -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quick Filter</label>
                    <select name="filter" id="filterSelect" onchange="handleFilterChange()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="this_week" {{ $filter == 'this_week' ? 'selected' : '' }}>This Week</option>
                        <option value="this_month" {{ $filter == 'this_month' ? 'selected' : '' }}>This Month</option>
                        <option value="last_month" {{ $filter == 'last_month' ? 'selected' : '' }}>Last Month</option>
                        <option value="custom" {{ $filter == 'custom' ? 'selected' : '' }}>Custom Range</option>
                    </select>
                </div>

                <!-- Start Date -->
                <div id="startDateDiv" class="{{ $filter != 'custom' ? 'hidden' : '' }}">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                    <input type="date" name="start_date" id="startDate" value="{{ $startDate }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- End Date -->
                <div id="endDateDiv" class="{{ $filter != 'custom' ? 'hidden' : '' }}">
                    <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                    <input type="date" name="end_date" id="endDate" value="{{ $endDate }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Apply Button -->
                <div class="flex items-end">
                    <button type="submit" class="w-full px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                        Apply Filter
                    </button>
                </div>
            </div>
        </form>

        <!-- Current Period Display -->
        <div class="mt-4 p-3 bg-indigo-50 rounded-lg border border-indigo-100">
            <p class="text-sm text-indigo-900">
                <span class="font-semibold">Showing data from:</span> 
                {{ $start->format('F d, Y') }} to {{ $end->format('F d, Y') }}
            </p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Hours</p>
                    <p class="text-3xl font-bold text-indigo-600 mt-1">{{ number_format($totalHours, 2) }}</p>
                </div>
                <div class="p-3 bg-indigo-100 rounded-lg">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Days Completed</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $daysCompleted }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Accomplishments</p>
                    <p class="text-3xl font-bold text-purple-600 mt-1">{{ $accomplishmentsCount }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Avg Hours/Day</p>
                    <p class="text-3xl font-bold text-orange-600 mt-1">{{ number_format($avgHoursPerDay, 2) }}</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-lg">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Overall Progress Chart -->
        <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Overall OJT Progress</h3>
            <div class="relative" style="height: 300px;">
                <canvas id="progressChart"></canvas>
            </div>
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    <span class="font-semibold text-indigo-600">{{ number_format(auth()->user()->getTotalRenderedHours(), 2) }}</span> 
                    of 
                    <span class="font-semibold">{{ auth()->user()->required_hours ?? 590 }}</span> hours completed
                </p>
            </div>
        </div>

        <!-- Period Hours Trend Chart -->
        <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Hours Trend (Selected Period)</h3>
            <div class="relative" style="height: 300px;">
                <canvas id="periodChart"></canvas>
            </div>
        </div>
    </div>

    <!-- DTR Records Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900">Daily Time Records</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Day</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hours</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($dtrRecords as $dtr)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $dtr->date->format('F d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $dtr->date->format('l') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $dtr->time_in ? \Carbon\Carbon::parse($dtr->time_in)->format('h:i A') : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $dtr->time_out ? \Carbon\Carbon::parse($dtr->time_out)->format('h:i A') : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-600">{{ number_format($dtr->total_hours, 2) }} hrs</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($dtr->status == 'completed')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-gray-500 font-medium">No DTR records found for this period</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Accomplishments Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900">Accomplishments</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tools Used</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($accomplishments as $accomplishment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $accomplishment->date->format('F d, Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ Str::limit($accomplishment->task_description, 80) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $accomplishment->tools_used ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <p class="text-gray-500 font-medium">No accomplishments found for this period</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function handleFilterChange() {
        const filter = document.getElementById('filterSelect').value;
        const startDateDiv = document.getElementById('startDateDiv');
        const endDateDiv = document.getElementById('endDateDiv');
        
        if (filter === 'custom') {
            startDateDiv.classList.remove('hidden');
            endDateDiv.classList.remove('hidden');
        } else {
            startDateDiv.classList.add('hidden');
            endDateDiv.classList.add('hidden');
        }
    }

    // Chart Data
    const totalRequired = {{ auth()->user()->required_hours ?? 590 }};
    const allDtrRecords = @json(auth()->user()->dtrLogs()->orderBy('date')->get(['date', 'total_hours']));
    const periodDtrRecords = @json($dtrRecords);

    // Overall OJT Progress Line Chart (Cumulative)
    let cumulativeHours = 0;
    const progressDates = allDtrRecords.map(dtr => {
        const date = new Date(dtr.date);
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    });
    const progressData = allDtrRecords.map(dtr => {
        cumulativeHours += parseFloat(dtr.total_hours) || 0;
        return cumulativeHours;
    });

    const progressCtx = document.getElementById('progressChart').getContext('2d');
    const progressChart = new Chart(progressCtx, {
        type: 'line',
        data: {
            labels: progressDates,
            datasets: [{
                label: 'Cumulative Hours',
                data: progressData,
                borderColor: '#6366F1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }, {
                label: 'Required Hours',
                data: new Array(progressDates.length).fill(totalRequired),
                borderColor: '#EF4444',
                borderWidth: 2,
                borderDash: [5, 5],
                fill: false,
                pointRadius: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + ' hrs';
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y.toFixed(2) + ' hrs';
                        }
                    }
                }
            }
        }
    });

    // Period Hours Trend Line Chart
    const periodDates = periodDtrRecords.map(dtr => {
        const date = new Date(dtr.date);
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    }).reverse();
    const periodHours = periodDtrRecords.map(dtr => parseFloat(dtr.total_hours) || 0).reverse();

    const periodCtx = document.getElementById('periodChart').getContext('2d');
    const periodChart = new Chart(periodCtx, {
        type: 'line',
        data: {
            labels: periodDates,
            datasets: [{
                label: 'Daily Hours',
                data: periodHours,
                borderColor: '#8B5CF6',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + ' hrs';
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Hours: ' + context.parsed.y.toFixed(2);
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
