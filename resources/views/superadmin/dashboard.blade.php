@extends('layouts.superadmin.dashboard')

@section('title', 'Superadmin Dashboard')
@section('page-title', 'System Overview')

@section('page-header')
<div class="md:flex md:items-center md:justify-between">
    <div class="min-w-0 flex-1">
        <h2 class="text-2xl font-bold leading-7 text-gray-200 sm:truncate sm:text-3xl sm:tracking-tight">
            System Overview
        </h2>
    </div>
    <div class="mt-4 flex md:ml-4 md:mt-0">
        <button type="button" onclick="document.getElementById('create-backup-form').submit();" class="ml-3 inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
            <i class="fas fa-database mr-2"></i> Create Backup
        </button>
    </div>
</div>
@endsection

@section('superadmin-content')
<!-- System Stats -->
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <!-- Users Count -->
    <div class="overflow-hidden rounded-lg bg-gray-800 shadow">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-users text-2xl text-red-400"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-gray-400">Total Users</dt>
                        <dd>
                            <div class="text-lg font-medium text-white">{{ $totalUsers }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-700 px-5 py-3">
            <div class="text-sm">
                <a href="{{ route('admin.users.index') }}" class="font-medium text-red-400 hover:text-red-300">View all</a>
            </div>
        </div>
    </div>

    <!-- Products Count -->
    <div class="overflow-hidden rounded-lg bg-gray-800 shadow">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-code text-2xl text-red-400"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-gray-400">Total Products</dt>
                        <dd>
                            <div class="text-lg font-medium text-white">{{ $totalProducts }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-700 px-5 py-3">
            <div class="text-sm">
                <a href="{{ route('admin.products.index') }}" class="font-medium text-red-400 hover:text-red-300">View all</a>
            </div>
        </div>
    </div>

    <!-- Payments Count -->
    <div class="overflow-hidden rounded-lg bg-gray-800 shadow">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-money-bill-wave text-2xl text-red-400"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-gray-400">Total Payments</dt>
                        <dd>
                            <div class="text-lg font-medium text-white">{{ $totalPayments }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-700 px-5 py-3">
            <div class="text-sm">
                <a href="{{ route('admin.payments.index') }}" class="font-medium text-red-400 hover:text-red-300">View all</a>
            </div>
        </div>
    </div>

    <!-- Active Warranties -->
    <div class="overflow-hidden rounded-lg bg-gray-800 shadow">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-shield-alt text-2xl text-red-400"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-gray-400">Active Warranties</dt>
                        <dd>
                            <div class="text-lg font-medium text-white">{{ $activeWarranties }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-700 px-5 py-3">
            <div class="text-sm">
                <a href="#" class="font-medium text-red-400 hover:text-red-300">View all</a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity and System Status -->
<div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
    <!-- Recent Audit Logs -->
    <div class="overflow-hidden rounded-lg bg-gray-800 shadow">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium leading-6 text-white">Recent System Activities</h3>
            <div class="mt-5 max-h-80 overflow-y-auto">
                <ul class="space-y-4">
                    @forelse($recentAuditLogs as $log)
                    <li class="px-4 py-3 bg-gray-700 rounded-lg">
                        <div class="flex justify-between">
                            <div class="text-sm font-medium text-white">{{ $log->action }}</div>
                            <div class="text-xs text-gray-400">{{ $log->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="text-xs text-gray-400 mt-1">by {{ $log->user->name }}</div>
                        @if($log->description)
                            <div class="text-xs text-gray-300 mt-1">{{ Str::limit($log->description, 80) }}</div>
                        @endif
                    </li>
                    @empty
                    <li class="text-gray-400 text-sm">No recent activities</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="bg-gray-700 px-4 py-3 sm:px-6">
            <div class="text-sm">
                <a href="{{ route('superadmin.audit-logs.index') }}" class="font-medium text-red-400 hover:text-red-300">View all audit logs</a>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div>
        <!-- Database Status -->
        <div class="overflow-hidden rounded-lg bg-gray-800 shadow mb-6">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium leading-6 text-white">Database Status</h3>
                <div class="mt-5">
                    <div class="flex justify-between items-center mb-3">
                        <div class="text-sm text-gray-300">Latest Backup:</div>
                        <div class="text-sm text-white">{{ $latestBackup ? $latestBackup->format('Y-m-d H:i') : 'No backups found' }}</div>
                    </div>
                    <div class="flex justify-between items-center mb-3">
                        <div class="text-sm text-gray-300">Backup Size:</div>
                        <div class="text-sm text-white">{{ $backupSize ? $backupSize : 'N/A' }}</div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-300">Status:</div>
                        <div class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                            Healthy
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-700 px-4 py-3 sm:px-6">
                <div class="text-sm">
                    <a href="{{ route('superadmin.backups.index') }}" class="font-medium text-red-400 hover:text-red-300">Manage backups</a>
                </div>
            </div>
        </div>
        
        <!-- System Settings -->
        <div class="overflow-hidden rounded-lg bg-gray-800 shadow">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium leading-6 text-white">System Settings</h3>
                <div class="mt-5">
                    <div class="flex justify-between items-center mb-3">
                        <div class="text-sm text-gray-300">App Version:</div>
                        <div class="text-sm text-white">{{ config('app.version') ?? '1.0.0' }}</div>
                    </div>
                    <div class="flex justify-between items-center mb-3">
                        <div class="text-sm text-gray-300">PHP Version:</div>
                        <div class="text-sm text-white">{{ phpversion() }}</div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-300">Laravel Version:</div>
                        <div class="text-sm text-white">{{ app()->version() }}</div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-700 px-4 py-3 sm:px-6">
                <div class="text-sm">
                    <a href="{{ route('superadmin.settings.index') }}" class="font-medium text-red-400 hover:text-red-300">Manage settings</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Role Management Quick Access -->
<div class="mt-6 overflow-hidden rounded-lg bg-gray-800 shadow">
    <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg font-medium leading-6 text-white">Role Management</h3>
        <div class="mt-5">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($roles as $role)
                <div class="rounded-md bg-gray-700 p-4">
                    <div class="flex justify-between">
                        <div class="text-md font-medium text-white">{{ $role->name }}</div>
                        <div class="inline-flex rounded-full bg-gray-600 px-2 text-xs font-semibold leading-5 text-gray-200">
                            {{ $role->users_count }} users
                        </div>
                    </div>
                    <div class="mt-3 text-sm text-gray-400">
                        {{ Str::limit($role->description ?? 'No description', 60) }}
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('superadmin.roles.edit', $role) }}" class="text-sm font-medium text-red-400 hover:text-red-300">Manage permissions</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="bg-gray-700 px-4 py-3 sm:px-6">
        <div class="text-sm">
            <a href="{{ route('superadmin.roles.index') }}" class="font-medium text-red-400 hover:text-red-300">View all roles</a>
        </div>
    </div>
</div>
@endsection
