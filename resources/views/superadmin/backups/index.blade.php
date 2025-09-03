@extends('layouts.superadmin.dashboard')

@section('title', 'Database Backups')
@section('page-title', 'Database Backups')

@section('page-header')
<div class="md:flex md:items-center md:justify-between">
    <div class="min-w-0 flex-1">
        <h2 class="text-2xl font-bold leading-7 text-gray-200 sm:truncate sm:text-3xl sm:tracking-tight">
            Database Backups
        </h2>
        <p class="mt-1 text-sm text-gray-400">
            Manage database backups and restore points
        </p>
    </div>
    <div class="mt-4 flex md:ml-4 md:mt-0">
        <button type="button" onclick="document.getElementById('create-backup-form').submit();" class="ml-3 inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
            <i class="fas fa-database mr-2"></i> Create Backup
        </button>
    </div>
</div>
@endsection

@section('superadmin-content')
<!-- Backup Settings -->
<div class="bg-gray-800 shadow sm:rounded-lg mb-6">
    <div class="px-4 py-5 sm:px-6 border-b border-gray-700">
        <h3 class="text-lg leading-6 font-medium text-white">Backup Settings</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-400">Configure backup behavior and schedule</p>
    </div>
    <div class="px-4 py-5 sm:p-6">
        <form action="{{ route('superadmin.backups.settings') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <!-- Auto Backup -->
                <div class="sm:col-span-3">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="auto_backup" name="settings[auto_backup]" type="checkbox" 
                                {{ ($settings['auto_backup'] ?? true) ? 'checked' : '' }}
                                class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-600 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="auto_backup" class="font-medium text-gray-300">Enable Automatic Backups</label>
                            <p class="text-gray-400">When enabled, the system will automatically create backups based on the schedule</p>
                        </div>
                    </div>
                </div>

                <!-- Backup Schedule -->
                <div class="sm:col-span-3">
                    <label for="backup_frequency" class="block text-sm font-medium text-gray-300">Backup Frequency</label>
                    <div class="mt-1">
                        <select id="backup_frequency" name="settings[backup_frequency]" class="bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-600 rounded-md">
                            <option value="daily" {{ ($settings['backup_frequency'] ?? 'daily') == 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ ($settings['backup_frequency'] ?? '') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ ($settings['backup_frequency'] ?? '') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        </select>
                    </div>
                </div>

                <!-- Retention Period -->
                <div class="sm:col-span-3">
                    <label for="backup_retention" class="block text-sm font-medium text-gray-300">Retention Period (days)</label>
                    <div class="mt-1">
                        <input type="number" name="settings[backup_retention]" id="backup_retention" value="{{ $settings['backup_retention'] ?? '30' }}" min="1" class="bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-600 rounded-md">
                    </div>
                    <p class="mt-2 text-sm text-gray-400">Backups older than this many days will be automatically deleted</p>
                </div>

                <!-- Backup Storage -->
                <div class="sm:col-span-3">
                    <label for="backup_storage" class="block text-sm font-medium text-gray-300">Backup Storage</label>
                    <div class="mt-1">
                        <select id="backup_storage" name="settings[backup_storage]" class="bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-600 rounded-md">
                            <option value="local" {{ ($settings['backup_storage'] ?? 'local') == 'local' ? 'selected' : '' }}>Local Storage</option>
                            <option value="s3" {{ ($settings['backup_storage'] ?? '') == 's3' ? 'selected' : '' }}>Amazon S3</option>
                            <option value="dropbox" {{ ($settings['backup_storage'] ?? '') == 'dropbox' ? 'selected' : '' }}>Dropbox</option>
                        </select>
                    </div>
                </div>

                <!-- Save Settings Button -->
                <div class="sm:col-span-6 text-right">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Save Backup Settings
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Existing Backups -->
<div class="bg-gray-800 shadow sm:rounded-lg mb-6">
    <div class="px-4 py-5 sm:px-6 border-b border-gray-700">
        <h3 class="text-lg leading-6 font-medium text-white">Existing Backups</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-400">View and manage database backups</p>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-900">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        File Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Date Created
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Size
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Type
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-700">
                @forelse($backups as $backup)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                        {{ $backup->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                        {{ $backup->created_at->format('Y-m-d H:i:s') }}
                        <div class="text-xs text-gray-400">
                            {{ $backup->created_at->diffForHumans() }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                        {{ $backup->size_formatted }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $backup->is_auto ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            {{ $backup->is_auto ? 'Automatic' : 'Manual' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('superadmin.backups.download', $backup->id) }}" class="text-red-400 hover:text-red-300 mr-3">
                            <i class="fas fa-download"></i> Download
                        </a>
                        <a href="{{ route('superadmin.backups.restore', $backup->id) }}" class="text-yellow-400 hover:text-yellow-300 mr-3" onclick="return confirm('Are you sure you want to restore this backup? This will overwrite your current database.')">
                            <i class="fas fa-undo"></i> Restore
                        </a>
                        <form action="{{ route('superadmin.backups.destroy', $backup->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this backup?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 text-center">
                        No backups found. <a href="#" onclick="document.getElementById('create-backup-form').submit();" class="text-red-400 hover:text-red-300">Create your first backup</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(count($backups) > 0)
    <div class="px-4 py-3 bg-gray-900 border-t border-gray-700 sm:px-6">
        {{ $backups->links() }}
    </div>
    @endif
</div>

<!-- Backup Statistics -->
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <!-- Total Backups -->
    <div class="overflow-hidden rounded-lg bg-gray-800 shadow">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-database text-2xl text-red-400"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-gray-400">Total Backups</dt>
                        <dd>
                            <div class="text-lg font-medium text-white">{{ $totalBackups }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Backup -->
    <div class="overflow-hidden rounded-lg bg-gray-800 shadow">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-calendar-alt text-2xl text-red-400"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-gray-400">Latest Backup</dt>
                        <dd>
                            <div class="text-lg font-medium text-white">{{ $latestBackup ? $latestBackup->format('Y-m-d') : 'Never' }}</div>
                            @if($latestBackup)
                                <div class="text-sm text-gray-400">{{ $latestBackup->diffForHumans() }}</div>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Storage Used -->
    <div class="overflow-hidden rounded-lg bg-gray-800 shadow">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-hdd text-2xl text-red-400"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-gray-400">Storage Used</dt>
                        <dd>
                            <div class="text-lg font-medium text-white">{{ $totalStorageUsed }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Next Scheduled Backup -->
    <div class="overflow-hidden rounded-lg bg-gray-800 shadow">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-clock text-2xl text-red-400"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-gray-400">Next Scheduled</dt>
                        <dd>
                            <div class="text-lg font-medium text-white">{{ $nextScheduledBackup ? $nextScheduledBackup->format('Y-m-d') : 'Not Scheduled' }}</div>
                            @if($nextScheduledBackup)
                                <div class="text-sm text-gray-400">{{ $nextScheduledBackup->diffForHumans() }}</div>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Manual Backup Form -->
<form id="create-backup-form" action="{{ route('superadmin.backups.create') }}" method="POST" class="hidden">
    @csrf
</form>
@endsection
