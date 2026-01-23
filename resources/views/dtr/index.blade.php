@extends('layouts.app')

@section('title', 'Daily Time Record')
@section('page-title', 'Daily Time Record')

@section('content')
<div class="space-y-6">
    <!-- Header with Add Button -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Time Records</h2>
            <p class="text-gray-600 mt-1">Manage your daily time records and track your OJT hours</p>
        </div>
        <button onclick="document.getElementById('addDtrModal').classList.remove('hidden')" 
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add DTR Record
        </button>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Records</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $dtrLogs->total() }}</p>
                </div>
                <div class="p-3 bg-indigo-100 rounded-lg">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Hours</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ number_format($totalHours, 2) }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Remaining Hours</p>
                    <p class="text-2xl font-bold text-orange-600 mt-1">{{ number_format($remainingHours, 2) }}</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-lg">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- DTR Records Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-100">
        <!-- DataTable Controls -->
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-600">Show</span>
                <form method="GET" action="{{ route('dtr.index') }}" id="perPageForm">
                    <input type="hidden" name="search" value="{{ $search ?? '' }}">
                    <select name="per_page" onchange="document.getElementById('perPageForm').submit()"
                            class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </form>
                <span class="text-sm text-gray-600">entries</span>
            </div>
            
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-600">Search:</span>
                <div class="flex items-center space-x-2">
                    <input type="hidden" id="perPageValue" value="{{ request('per_page', 10) }}">
                    <input type="text" id="searchInput" value="{{ $search ?? '' }}"
                           class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-64"
                           placeholder="Search date, day, notes...">
                    <button id="clearSearch" class="px-3 py-1.5 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 transition" style="display: {{ $search ? 'block' : 'none' }}">
                        Clear
                    </button>
                </div>
            </div>
        </div>

        <div id="tableContainer">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 table-fixed">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-28">Day</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Time In</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Time Out</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Break</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Hours</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($dtrLogs as $dtr)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ ($dtrLogs->currentPage() - 1) * $dtrLogs->perPage() + $loop->iteration }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($dtr->date)->format('F d, Y') }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($dtr->date)->format('l') }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $dtr->time_in ? \Carbon\Carbon::parse($dtr->time_in)->format('h:i A') : '-' }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $dtr->time_out ? \Carbon\Carbon::parse($dtr->time_out)->format('h:i A') : '-' }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm text-gray-600">{{ number_format($dtr->break_hours, 2) }} hrs</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm font-semibold text-indigo-600">{{ number_format($dtr->total_hours, 2) }} hrs</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $dtr->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($dtr->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-600 max-w-xs truncate">{{ $dtr->notes ?: '-' }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <p class="text-gray-500 text-lg font-medium">No DTR records yet</p>
                                    <p class="text-gray-400 text-sm mt-1">Click "Add DTR Record" to create your first entry</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($dtrLogs->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Showing {{ $dtrLogs->firstItem() }} to {{ $dtrLogs->lastItem() }} of {{ $dtrLogs->total() }} records
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($dtrLogs->onFirstPage())
                            <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">&lt;</span>
                        @else
                            <a href="{{ $dtrLogs->previousPageUrl() }}" 
                               class="pagination-link px-3 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">&lt;</a>
                        @endif
                        
                        <span class="px-4 py-2 text-sm font-medium text-gray-700">
                            Page {{ $dtrLogs->currentPage() }} of {{ $dtrLogs->lastPage() }}
                        </span>
                        
                        @if($dtrLogs->hasMorePages())
                            <a href="{{ $dtrLogs->nextPageUrl() }}" 
                               class="pagination-link px-3 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">&gt;</a>
                        @else
                            <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">&gt;</span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        </div>
    </div>
</div>

<!-- Add DTR Modal -->
<div id="addDtrModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="document.getElementById('addDtrModal').classList.add('hidden')"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form method="POST" action="{{ route('dtr.store') }}">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-gray-900">Add DTR Record</h3>
                    </div>

                    <div class="space-y-4">
                        <!-- Date -->
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="date" id="date" name="date" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   value="{{ old('date') }}">
                            @error('date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Time In -->
                        <div>
                            <label for="time_in" class="block text-sm font-medium text-gray-700 mb-1">Time In</label>
                            <input type="time" id="time_in" name="time_in" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   value="{{ old('time_in') }}">
                            @error('time_in')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Time Out -->
                        <div>
                            <label for="time_out" class="block text-sm font-medium text-gray-700 mb-1">Time Out</label>
                            <input type="time" id="time_out" name="time_out" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   value="{{ old('time_out') }}">
                            @error('time_out')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Break Hours -->
                        <div>
                            <label for="break_hours" class="block text-sm font-medium text-gray-700 mb-1">Lunch Break</label>
                            <input type="text" id="break_hours_display" readonly
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed"
                                   value="1 Hour">
                            <input type="hidden" name="break_hours" value="1">
                            <p class="mt-1 text-xs text-gray-500">Fixed 1-hour lunch break deduction</p>
                            @error('break_hours')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes (Optional) -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                            <textarea id="notes" name="notes" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                      placeholder="Any additional notes...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" 
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition">
                        Save Record
                    </button>
                    <button type="button" 
                            onclick="document.getElementById('addDtrModal').classList.add('hidden')"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->any())
<script>
    document.getElementById('addDtrModal').classList.remove('hidden');
</script>
@endif

<script>
    const searchInput = document.getElementById('searchInput');
    const clearButton = document.getElementById('clearSearch');
    const perPageValue = document.getElementById('perPageValue');
    const tableContainer = document.getElementById('tableContainer');
    let searchTimeout;
    
    // Load initial table
    loadTable('', 1);
    
    // Real-time search
    searchInput.addEventListener('input', function() {
        const searchValue = this.value;
        
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadTable(searchValue, 1);
            clearButton.style.display = searchValue ? 'block' : 'none';
        }, 100); // Very short delay for smooth typing
    });
    
    // Clear search
    clearButton.addEventListener('click', function() {
        searchInput.value = '';
        loadTable('', 1);
        clearButton.style.display = 'none';
    });
    
    // AJAX table load function
    function loadTable(search, page) {
        const perPage = perPageValue.value;
        const url = `{{ route('dtr.index') }}?search=${encodeURIComponent(search)}&per_page=${perPage}&page=${page}`;
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTable = doc.getElementById('tableContainer');
            
            if (newTable) {
                tableContainer.innerHTML = newTable.innerHTML;
                attachPaginationEvents();
            }
        });
    }
    
    // Attach click events to pagination links
    function attachPaginationEvents() {
        document.querySelectorAll('.pagination-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = new URL(this.href);
                const page = url.searchParams.get('page');
                const search = searchInput.value;
                loadTable(search, page);
            });
        });
    }
</script>
@endsection
