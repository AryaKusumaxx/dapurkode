@extends('layouts.superadmin.dashboard')

@section('title', 'Audit Logs')
@section('page-title', 'Audit Logs')

@section('page-header')
<div class="md:flex md:items-center md:justify-between">
    <div class="min-w-0 flex-1">
        <h2 class="text-2xl font-bold leading-7 text-gray-200 sm:truncate sm:text-3xl sm:tracking-tight">
            Audit Logs
        </h2>
        <p class="mt-1 text-sm text-gray-400">
            Review system activities and user actions
        </p>
    </div>
    <div class="mt-4 flex md:ml-4 md:mt-0">
        <form action="{{ route('superadmin.audit-logs.export') }}" method="POST">
            @csrf
            <button type="submit" class="inline-flex items-center rounded-md bg-gray-700 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                <i class="fas fa-file-export mr-2"></i> Export Logs
            </button>
        </form>
        <button type="button" onclick="document.getElementById('clear-logs-form').submit();" class="ml-3 inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
            <i class="fas fa-trash mr-2"></i> Clear Logs
        </button>
        <form id="clear-logs-form" action="{{ route('superadmin.audit-logs.clear') }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection

@section('superadmin-content')
<!-- Search and Filters -->
<div class="bg-gray-800 rounded-lg shadow px-5 py-6 sm:px-6 mb-6">
    <form action="{{ route('superadmin.audit-logs.index') }}" method="GET">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Search -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-300">Search</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="bg-gray-700 text-white block w-full pl-10 pr-12 sm:text-sm border-gray-600 rounded-md focus:ring-red-500 focus:border-red-500" placeholder="Search logs...">
                </div>
            </div>
            
            <!-- Action Filter -->
            <div>
                <label for="action" class="block text-sm font-medium text-gray-300">Action</label>
                <select id="action" name="action" class="mt-1 block w-full bg-gray-700 text-white border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    <option value="">All Actions</option>
                    <option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>Create</option>
                    <option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>Update</option>
                    <option value="delete" {{ request('action') == 'delete' ? 'selected' : '' }}>Delete</option>
                    <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login</option>
                    <option value="logout" {{ request('action') == 'logout' ? 'selected' : '' }}>Logout</option>
                </select>
            </div>
            
            <!-- User Filter -->
            <div>
                <label for="user" class="block text-sm font-medium text-gray-300">User</label>
                <select id="user" name="user_id" class="mt-1 block w-full bg-gray-700 text-white border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Date Range Filter -->
            <div>
                <label for="date" class="block text-sm font-medium text-gray-300">Date Range</label>
                <select id="date" name="date_range" class="mt-1 block w-full bg-gray-700 text-white border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    <option value="">All Time</option>
                    <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="yesterday" {{ request('date_range') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                    <option value="this_week" {{ request('date_range') == 'this_week' ? 'selected' : '' }}>This Week</option>
                    <option value="last_week" {{ request('date_range') == 'last_week' ? 'selected' : '' }}>Last Week</option>
                    <option value="this_month" {{ request('date_range') == 'this_month' ? 'selected' : '' }}>This Month</option>
                    <option value="last_month" {{ request('date_range') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                </select>
            </div>
            
            <!-- Actions -->
            <div class="lg:col-span-4 flex items-end justify-start">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-filter mr-2"></i> Apply Filters
                </button>
                <a href="{{ route('superadmin.audit-logs.index') }}" class="ml-3 inline-flex items-center px-4 py-2 border border-gray-600 text-sm font-medium rounded-md text-gray-300 bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-times mr-2"></i> Clear Filters
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Audit Logs Table -->
<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-700 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-900">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                User
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Action
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Entity
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                IP Address
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Date & Time
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                        @forelse($auditLogs as $log)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $log->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($log->user && $log->user->avatar)
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . $log->user->avatar) }}" alt="{{ $log->user ? $log->user->name : 'System' }}">
                                    </div>
                                    @else
                                    <div class="flex-shrink-0 h-8 w-8 rounded-full bg-red-600 flex items-center justify-center text-white">
                                        {{ $log->user ? substr($log->user->name, 0, 1) : 'S' }}
                                    </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-white">
                                            {{ $log->user ? $log->user->name : 'System' }}
                                        </div>
                                        <div class="text-sm text-gray-400">
                                            {{ $log->user ? $log->user->email : 'system@dapurkode.com' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $log->action === 'create' ? 'bg-green-100 text-green-800' : 
                                       ($log->action === 'update' ? 'bg-blue-100 text-blue-800' : 
                                       ($log->action === 'delete' ? 'bg-red-100 text-red-800' : 
                                       ($log->action === 'login' ? 'bg-purple-100 text-purple-800' : 
                                       ($log->action === 'logout' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')))) }}">
                                    {{ ucfirst($log->action) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $log->auditable_type ? class_basename($log->auditable_type) : 'N/A' }}
                                {{ $log->auditable_id ? '#'.$log->auditable_id : '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $log->ip_address ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $log->created_at->format('M d, Y H:i:s') }}
                                <div class="text-xs text-gray-400">
                                    {{ $log->created_at->diffForHumans() }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button type="button" class="text-red-400 hover:text-red-300" onclick="showLogDetails({{ $log->id }})">
                                    View Details
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 text-center">
                                No audit logs found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $auditLogs->links() }}
</div>

<!-- Log Details Modal -->
<div id="log-details-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-history text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                            Audit Log Details
                        </h3>
                        <div class="mt-4">
                            <div class="bg-gray-700 rounded-md p-4 text-sm text-gray-300 overflow-auto max-h-96">
                                <div id="log-details-content">
                                    Loading...
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal()">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function showLogDetails(logId) {
        // In a real app, you would fetch the log details via AJAX
        document.getElementById('log-details-modal').classList.remove('hidden');
        document.getElementById('log-details-content').innerHTML = 'Loading log details for ID ' + logId + '...';
        
        // Simulating an AJAX call
        setTimeout(() => {
            document.getElementById('log-details-content').innerHTML = `
                <div class="space-y-3">
                    <div>
                        <h4 class="text-white font-semibold">Log ID</h4>
                        <p>${logId}</p>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold">Changes</h4>
                        <pre class="text-xs text-gray-300 bg-gray-800 p-2 rounded mt-1">
{
  "name": "Product Name",
  "price": {
    "old": "99.99",
    "new": "89.99"
  },
  "description": {
    "old": "Old product description",
    "new": "Updated product description with more details"
  },
  "updated_at": "2023-04-25 14:32:45"
}
                        </pre>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold">User Agent</h4>
                        <p>Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36</p>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold">URL</h4>
                        <p>/admin/products/5/edit</p>
                    </div>
                </div>
            `;
        }, 500);
    }
    
    function closeModal() {
        document.getElementById('log-details-modal').classList.add('hidden');
    }
</script>
@endsection
