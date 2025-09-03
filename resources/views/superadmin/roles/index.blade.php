@extends('layouts.superadmin.dashboard')

@section('title', 'Role Management')
@section('page-title', 'Role Management')

@section('page-header')
<div class="md:flex md:items-center md:justify-between">
    <div class="min-w-0 flex-1">
        <h2 class="text-2xl font-bold leading-7 text-gray-200 sm:truncate sm:text-3xl sm:tracking-tight">
            Role Management
        </h2>
        <p class="mt-1 text-sm text-gray-400">
            Manage user roles and permissions across the application
        </p>
    </div>
    <div class="mt-4 flex md:ml-4 md:mt-0">
        <button type="button" onclick="window.location.href='{{ route('superadmin.roles.create') }}'" class="ml-3 inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
            <i class="fas fa-plus-circle mr-2"></i> Create New Role
        </button>
    </div>
</div>
@endsection

@section('superadmin-content')
<!-- Search and Filters -->
<div class="bg-gray-800 rounded-lg shadow px-5 py-6 sm:px-6 mb-6">
    <form action="{{ route('superadmin.roles.index') }}" method="GET">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Search -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-300">Search Roles</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="bg-gray-700 text-white block w-full pl-10 pr-12 sm:text-sm border-gray-600 rounded-md focus:ring-red-500 focus:border-red-500" placeholder="Search by name...">
                </div>
            </div>
            
            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-300">Status</label>
                <select id="status" name="status" class="mt-1 block w-full bg-gray-700 text-white border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            
            <!-- Actions -->
            <div class="flex items-end justify-start">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <i class="fas fa-filter mr-2"></i> Apply Filters
                </button>
                <a href="{{ route('superadmin.roles.index') }}" class="ml-3 inline-flex items-center px-4 py-2 border border-gray-600 text-sm font-medium rounded-md text-gray-300 bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="fas fa-times mr-2"></i> Clear
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Roles List -->
<div class="bg-gray-800 shadow overflow-hidden sm:rounded-md">
    <div class="bg-gray-900 px-4 py-3 border-b border-gray-700 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-white">
            Roles
        </h3>
    </div>
    <ul role="list" class="divide-y divide-gray-700">
        @forelse($roles as $role)
        <li>
            <div class="block hover:bg-gray-750">
                <div class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-red-600 flex items-center justify-center">
                                <i class="fas {{ $role->name == 'superadmin' ? 'fa-user-shield' : ($role->name == 'admin' ? 'fa-user-cog' : 'fa-user') }} text-white"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-md font-medium text-white">{{ $role->name }}</p>
                                <p class="text-sm text-gray-400">{{ $role->users_count }} users with this role</p>
                            </div>
                        </div>
                        <div class="ml-2 flex-shrink-0 flex">
                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $role->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $role->is_active ? 'Active' : 'Inactive' }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-2 sm:flex sm:justify-between">
                        <div class="sm:flex">
                            <p class="flex items-center text-sm text-gray-400">
                                <i class="fas fa-key flex-shrink-0 mr-1.5 text-gray-500"></i>
                                {{ $role->permissions_count }} permissions
                            </p>
                            <p class="mt-2 flex items-center text-sm text-gray-400 sm:mt-0 sm:ml-6">
                                <i class="fas fa-calendar flex-shrink-0 mr-1.5 text-gray-500"></i>
                                Created {{ $role->created_at->format('M d, Y') }}
                            </p>
                        </div>
                        <div class="mt-2 flex items-center text-sm text-gray-400 sm:mt-0">
                            <a href="{{ route('superadmin.roles.edit', $role) }}" class="text-red-400 hover:text-red-300 mr-4">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            @if(!in_array($role->name, ['superadmin', 'admin', 'user']))
                            <form action="{{ route('superadmin.roles.destroy', $role) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </li>
        @empty
        <li>
            <div class="px-4 py-4 sm:px-6 text-gray-400 text-center">
                No roles found.
            </div>
        </li>
        @endforelse
    </ul>
    
    <!-- Pagination -->
    <div class="bg-gray-900 px-4 py-3 border-t border-gray-700 sm:px-6">
        {{ $roles->links() }}
    </div>
</div>
@endsection
