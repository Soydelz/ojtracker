@extends('layouts.app')

@section('title', 'Accomplishments')
@section('page-title', 'Accomplishments')

@section('content')
<div class="space-y-6">
    <!-- Header with Add Button -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Daily Accomplishments</h2>
            <p class="text-gray-600 mt-1">Track your daily tasks and achievements during your OJT</p>
        </div>
        <button onclick="openAddModal()" 
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Accomplishment
        </button>
    </div>

    <!-- Summary Card -->
    <div class="bg-white rounded-lg shadow p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Total Accomplishments</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalAccomplishments }}</p>
            </div>
            <div class="p-3 bg-indigo-100 rounded-lg">
                <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Accomplishments Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-100">
        <!-- DataTable Controls -->
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-600">Show</span>
                <form method="GET" action="{{ route('accomplishments.index') }}" id="perPageForm">
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
                           placeholder="Search date, task, tools...">
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-28">Day</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task Description</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Tools Used</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($accomplishments as $accomplishment)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ ($accomplishments->currentPage() - 1) * $accomplishments->perPage() + $loop->iteration }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($accomplishment->date)->format('F d, Y') }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($accomplishment->date)->format('l') }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-gray-900">{{ Str::limit($accomplishment->task_description, 100) }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm text-gray-600">{{ $accomplishment->tools_used ?: '-' }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <button onclick='openViewModal(@json($accomplishment->date->format("F d, Y")), @json($accomplishment->date->format("l")), @json($accomplishment->task_description), @json($accomplishment->tools_used))' 
                                            class="text-blue-600 hover:text-blue-900 transition" title="View Details">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                    <button onclick='openEditModal(@json($accomplishment->id), @json($accomplishment->date->format("Y-m-d")), @json($accomplishment->task_description), @json($accomplishment->tools_used))' 
                                            class="text-indigo-600 hover:text-indigo-900 transition" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <p class="text-gray-500 text-lg font-medium">No accomplishments yet</p>
                                    <p class="text-gray-400 text-sm mt-1">Click "Add Accomplishment" to create your first entry</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($accomplishments->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Showing {{ $accomplishments->firstItem() }} to {{ $accomplishments->lastItem() }} of {{ $accomplishments->total() }} records
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($accomplishments->onFirstPage())
                            <span class="px-3 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">&lt;</span>
                        @else
                            <a href="{{ $accomplishments->previousPageUrl() }}" 
                               class="pagination-link px-3 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">&lt;</a>
                        @endif
                        
                        <span class="px-4 py-2 text-sm font-medium text-gray-700">
                            Page {{ $accomplishments->currentPage() }} of {{ $accomplishments->lastPage() }}
                        </span>
                        
                        @if($accomplishments->hasMorePages())
                            <a href="{{ $accomplishments->nextPageUrl() }}" 
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

<!-- Add Accomplishment Modal -->
<div id="addModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeAddModal()"></div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form method="POST" action="{{ route('accomplishments.store') }}">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-gray-900">Add Accomplishment</h3>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="add_date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="date" id="add_date" name="date" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   value="{{ old('date', today()->format('Y-m-d')) }}">
                        </div>

                        <div>
                            <label for="add_task_description" class="block text-sm font-medium text-gray-700 mb-1">Task Description</label>
                            <textarea id="add_task_description" name="task_description" rows="4" required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                      placeholder="Describe what you accomplished today...">{{ old('task_description') }}</textarea>
                        </div>

                        <div>
                            <label for="add_tools_used" class="block text-sm font-medium text-gray-700 mb-1">Tools/Technologies Used (Optional)</label>
                            <input type="text" id="add_tools_used" name="tools_used"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="e.g., Laravel, Tailwind CSS, MySQL"
                                   value="{{ old('tools_used') }}">
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" 
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition">
                        Save Accomplishment
                    </button>
                    <button type="button" onclick="closeAddModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Accomplishment Modal -->
<div id="editModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeEditModal()"></div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form method="POST" id="editForm">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-gray-900">Edit Accomplishment</h3>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="edit_date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="date" id="edit_date" name="date" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label for="edit_task_description" class="block text-sm font-medium text-gray-700 mb-1">Task Description</label>
                            <textarea id="edit_task_description" name="task_description" rows="4" required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                      placeholder="Describe what you accomplished today..."></textarea>
                        </div>

                        <div>
                            <label for="edit_tools_used" class="block text-sm font-medium text-gray-700 mb-1">Tools/Technologies Used (Optional)</label>
                            <input type="text" id="edit_tools_used" name="tools_used"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="e.g., Laravel, Tailwind CSS, MySQL">
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" 
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition">
                        Update Accomplishment
                    </button>
                    <button type="button" onclick="closeEditModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Accomplishment Modal -->
<div id="viewModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeViewModal()"></div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-gray-900">Accomplishment Details</h3>
                    </div>
                    <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 font-medium uppercase">Date</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1" id="view_date"></p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium uppercase">Day</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1" id="view_day"></p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Task Description</label>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-900 whitespace-pre-wrap" id="view_task_description"></p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tools/Technologies Used</label>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p class="text-sm text-gray-900" id="view_tools_used"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeViewModal()"
                        class="w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto sm:text-sm transition">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Modal functions
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }
    
    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
    }
    
    function openViewModal(date, day, task, tools) {
        document.getElementById('viewModal').classList.remove('hidden');
        document.getElementById('view_date').textContent = date;
        document.getElementById('view_day').textContent = day;
        document.getElementById('view_task_description').textContent = task;
        document.getElementById('view_tools_used').textContent = tools || 'N/A';
    }
    
    function closeViewModal() {
        document.getElementById('viewModal').classList.add('hidden');
    }
    
    function openEditModal(id, date, task, tools) {
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editForm').action = `/accomplishments/${id}`;
        document.getElementById('edit_date').value = date;
        document.getElementById('edit_task_description').value = task;
        document.getElementById('edit_tools_used').value = tools;
    }
    
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
    
    // Real-time search
    const searchInput = document.getElementById('searchInput');
    const clearButton = document.getElementById('clearSearch');
    const perPageValue = document.getElementById('perPageValue');
    const tableContainer = document.getElementById('tableContainer');
    let searchTimeout;
    
    loadTable('', 1);
    
    searchInput.addEventListener('input', function() {
        const searchValue = this.value;
        
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            loadTable(searchValue, 1);
            clearButton.style.display = searchValue ? 'block' : 'none';
        }, 100);
    });
    
    clearButton.addEventListener('click', function() {
        searchInput.value = '';
        loadTable('', 1);
        clearButton.style.display = 'none';
    });
    
    function loadTable(search, page) {
        const perPage = perPageValue.value;
        const url = `{{ route('accomplishments.index') }}?search=${encodeURIComponent(search)}&per_page=${perPage}&page=${page}`;
        
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

@if($errors->any())
<script>
    document.getElementById('addModal').classList.remove('hidden');
</script>
@endif
@endsection
