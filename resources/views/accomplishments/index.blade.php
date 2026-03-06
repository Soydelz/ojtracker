@extends('layouts.app')

@section('title', 'Accomplishments')
@section('page-title', 'Accomplishments')

@section('content')
<div class="space-y-6">
    <!-- Header with Add Button -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-white">Daily Accomplishments</h2>
            <p class="text-slate-400 mt-1">Track your daily tasks and achievements during your OJT</p>
        </div>
        <button onclick="openAddModal()" 
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-cyan-700 transition duration-200 shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/50">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Accomplishment
        </button>
    </div>

    <!-- Summary Card -->
    <div class="bg-slate-900 rounded-3xl shadow-xl p-6 border border-slate-700 hover:shadow-2xl hover:shadow-blue-500/20 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-400">Total Accomplishments</p>
                <p class="text-3xl font-bold text-white mt-1">{{ $totalAccomplishments }}</p>
            </div>
            <div class="p-3 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl shadow-lg shadow-blue-500/30">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Accomplishments Table -->
    <div class="bg-slate-900 rounded-3xl shadow-xl overflow-hidden border border-slate-700">
        <!-- DataTable Controls -->
        <div class="px-6 py-4 border-b border-slate-700 flex items-center justify-between bg-slate-800/50">
            <div class="flex items-center space-x-2">
                <span class="text-sm text-slate-400">Show</span>
                <form method="GET" action="{{ route('accomplishments.index') }}" id="perPageForm">
                    <input type="hidden" name="search" value="{{ $search ?? '' }}">
                    <select name="per_page" onchange="document.getElementById('perPageForm').submit()"
                            class="px-3 py-1.5 bg-slate-800 border border-slate-600 rounded-lg text-sm text-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </form>
                <span class="text-sm text-slate-400">entries</span>
            </div>
            
            <div class="flex items-center space-x-2">
                <span class="text-sm text-slate-400">Search:</span>
                <div class="flex items-center space-x-2">
                    <input type="hidden" id="perPageValue" value="{{ request('per_page', 10) }}">
                    <input type="text" id="searchInput" value="{{ $search ?? '' }}"
                           class="px-3 py-1.5 bg-slate-800 border border-slate-600 rounded-lg text-sm text-slate-200 placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64"
                           placeholder="Search date, task, tools...">
                    <button id="clearSearch" class="px-3 py-1.5 bg-slate-700 text-white text-sm font-medium rounded-lg hover:bg-slate-600 transition" style="display: {{ $search ? 'block' : 'none' }}">
                        Clear
                    </button>
                </div>
            </div>
        </div>

        <div id="tableContainer">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-700 table-fixed">
                <thead class="bg-slate-800">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider w-12">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider w-40">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider w-28">Day</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Task Description</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider w-48">Tools Used</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider w-32">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-slate-900 divide-y divide-slate-700">
                    @forelse($accomplishments as $accomplishment)
                        <tr class="hover:bg-slate-800/50 transition">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm font-semibold text-white">{{ ($accomplishments->currentPage() - 1) * $accomplishments->perPage() + $loop->iteration }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm font-medium text-white">{{ \Carbon\Carbon::parse($accomplishment->date)->format('F d, Y') }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm text-slate-300">{{ \Carbon\Carbon::parse($accomplishment->date)->format('l') }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm text-white font-medium">{{ Str::limit($accomplishment->task_description, 100) }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm text-slate-300">{{ $accomplishment->tools_used ?: '-' }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <button onclick='openViewModal(@json($accomplishment->date->format("F d, Y")), @json($accomplishment->date->format("l")), @json($accomplishment->task_description), @json($accomplishment->tools_used))' 
                                            class="text-cyan-400 hover:text-cyan-300 transition" title="View Details">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                    <button onclick='openEditModal(@json($accomplishment->id), @json($accomplishment->date->format("Y-m-d")), @json($accomplishment->task_description), @json($accomplishment->tools_used))' 
                                            class="text-blue-400 hover:text-blue-300 transition" title="Edit">
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
                                    <svg class="w-16 h-16 text-slate-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <p class="text-slate-400 text-lg font-medium">No accomplishments yet</p>
                                    <p class="text-slate-500 text-sm mt-1">Click "Add Accomplishment" to create your first entry</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($accomplishments->hasPages())
            <div class="px-6 py-4 border-t border-slate-700 bg-slate-800/30">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-slate-400">
                        Showing {{ $accomplishments->firstItem() }} to {{ $accomplishments->lastItem() }} of {{ $accomplishments->total() }} records
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($accomplishments->onFirstPage())
                            <span class="px-3 py-2 bg-slate-800 text-slate-500 rounded-lg cursor-not-allowed">&lt;</span>
                        @else
                            <a href="{{ $accomplishments->previousPageUrl() }}" 
                               class="pagination-link px-3 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg  hover:from-blue-700 hover:to-cyan-700 shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/50 transition-all">&lt;</a>
                        @endif
                        
                        <span class="px-4 py-2 text-sm font-medium text-slate-200">
                            Page {{ $accomplishments->currentPage() }} of {{ $accomplishments->lastPage() }}
                        </span>
                        
                        @if($accomplishments->hasMorePages())
                            <a href="{{ $accomplishments->nextPageUrl() }}" 
                               class="pagination-link px-3 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-lg hover:from-blue-700 hover:to-cyan-700 shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/50 transition-all">&gt;</a>
                        @else
                            <span class="px-3 py-2 bg-slate-800 text-slate-500 rounded-lg cursor-not-allowed">&gt;</span>
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
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-75" onclick="closeAddModal()"></div>

        <div class="inline-block align-bottom bg-slate-800 rounded-2xl text-left overflow-hidden shadow-2xl shadow-blue-500/20 transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-700">
            <form method="POST" action="{{ route('accomplishments.store') }}">
                @csrf
                <div class="bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 shadow-lg shadow-blue-500/30">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-white">Add Accomplishment</h3>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="add_date" class="block text-sm font-medium text-slate-300 mb-1">Date</label>
                            <input type="date" id="add_date" name="date" required
                                   class="w-full px-3 py-2 bg-slate-900 border border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-200"
                                   value="{{ old('date', today()->format('Y-m-d')) }}">
                        </div>

                        <div>
                            <label for="add_task_description" class="block text-sm font-medium text-slate-300 mb-1">Task Description</label>
                            <textarea id="add_task_description" name="task_description" rows="4" required
                                      class="w-full px-3 py-2 bg-slate-900 border border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-200 placeholder-slate-400"
                                      placeholder="Describe what you accomplished today...">{{ old('task_description') }}</textarea>
                        </div>

                        <div>
                            <label for="add_tools_used" class="block text-sm font-medium text-slate-300 mb-1">Tools/Technologies Used (Optional)</label>
                            <input type="text" id="add_tools_used" name="tools_used"
                                   class="w-full px-3 py-2 bg-slate-900 border border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-200 placeholder-slate-400"
                                   placeholder="e.g., Laravel, Tailwind CSS, MySQL"
                                   value="{{ old('tools_used') }}">
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" 
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-lg px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-base font-medium text-white hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/50 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                        Save Accomplishment
                    </button>
                    <button type="button" onclick="closeAddModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-600 shadow-sm px-4 py-2 bg-slate-800 text-base font-medium text-slate-300 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm transition">
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
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-75" onclick="closeEditModal()"></div>

        <div class="inline-block align-bottom bg-slate-800 rounded-2xl text-left overflow-hidden shadow-2xl shadow-blue-500/20 transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-700">
            <form method="POST" id="editForm">
                @csrf
                @method('PUT')
                <div class="bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 shadow-lg shadow-blue-500/30">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-white">Edit Accomplishment</h3>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="edit_date" class="block text-sm font-medium text-slate-300 mb-1">Date</label>
                            <input type="date" id="edit_date" name="date" required
                                   class="w-full px-3 py-2 bg-slate-900 border border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-200">
                        </div>

                        <div>
                            <label for="edit_task_description" class="block text-sm font-medium text-slate-300 mb-1">Task Description</label>
                            <textarea id="edit_task_description" name="task_description" rows="4" required
                                      class="w-full px-3 py-2 bg-slate-900 border border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-200 placeholder-slate-400"
                                      placeholder="Describe what you accomplished today..."></textarea>
                        </div>

                        <div>
                            <label for="edit_tools_used" class="block text-sm font-medium text-slate-300 mb-1">Tools/Technologies Used (Optional)</label>
                            <input type="text" id="edit_tools_used" name="tools_used"
                                   class="w-full px-3 py-2 bg-slate-900 border border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-slate-200 placeholder-slate-400"
                                   placeholder="e.g., Laravel, Tailwind CSS, MySQL">
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" 
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-lg px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-base font-medium text-white hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/50 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                        Update Accomplishment
                    </button>
                    <button type="button" onclick="closeEditModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-600 shadow-sm px-4 py-2 bg-slate-800 text-base font-medium text-slate-300 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm transition">
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
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-75" onclick="closeViewModal()"></div>

        <div class="inline-block align-bottom bg-slate-800 rounded-2xl text-left overflow-hidden shadow-2xl shadow-cyan-500/20 transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-700">
            <div class="bg-slate-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-gradient-to-br from-cyan-500 to-blue-500 shadow-lg shadow-cyan-500/30">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-lg font-medium text-white">Accomplishment Details</h3>
                    </div>
                    <button onclick="closeViewModal()" class="text-slate-400 hover:text-slate-200 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div class="bg-slate-900 p-4 rounded-xl border border-slate-700">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-slate-400 font-medium uppercase">Date</p>
                                <p class="text-sm font-semibold text-white mt-1" id="view_date"></p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-medium uppercase">Day</p>
                                <p class="text-sm font-semibold text-white mt-1" id="view_day"></p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Task Description</label>
                        <div class="bg-slate-900 p-4 rounded-xl border border-slate-700">
                            <p class="text-sm text-slate-200 whitespace-pre-wrap" id="view_task_description"></p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Tools/Technologies Used</label>
                        <div class="bg-slate-900 p-4 rounded-xl border border-slate-700">
                            <p class="text-sm text-slate-200" id="view_tools_used"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeViewModal()"
                        class="w-full inline-flex justify-center rounded-lg border border-slate-600 shadow-sm px-4 py-2 bg-slate-800 text-base font-medium text-slate-300 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 sm:w-auto sm:text-sm transition">
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
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok: ' + response.status);
            return response.text();
        })
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTable = doc.getElementById('tableContainer');
            
            if (newTable) {
                tableContainer.innerHTML = newTable.innerHTML;
                attachPaginationEvents();
            }
        })
        .catch(err => {
            console.error('Pagination error:', err);
        });
    }
    
    function attachPaginationEvents() {
        document.querySelectorAll('.pagination-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation(); // Prevent layout's global click handler from showing the page loader
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
