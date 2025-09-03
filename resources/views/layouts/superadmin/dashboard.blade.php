@extends('layouts.app')

@section('title', isset($title) ? $title : 'Superadmin Panel')

@section('navigation')
<nav x-data="{ open: false, openSidebar: false }" class="bg-gray-900 border-b border-gray-800">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Hamburger menu for sidebar (mobile) -->
                <button @click="openSidebar = ! openSidebar" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 md:hidden hover:text-gray-300 hover:bg-gray-800 focus:outline-none focus:bg-gray-800 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': openSidebar, 'inline-flex': ! openSidebar }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! openSidebar, 'inline-flex': openSidebar }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('superadmin.roles.index') }}" class="block h-12 w-auto">
                        <img src="{{ asset('storage/images/dapurkode.png') }}" alt="DapurKode" class="h-8 w-auto">
                    </a>
                </div>

                <!-- Page title -->
                <div class="hidden md:flex md:items-center md:ml-6">
                    <h1 class="text-xl font-semibold text-red-400">@yield('page-title', 'Superadmin Panel')</h1>
                </div>
            </div>

            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <!-- View Website -->
                <a href="{{ route('welcome') }}" target="_blank" class="p-1 text-gray-300 rounded-full hover:bg-gray-800 hover:text-white focus:outline-none focus:shadow-outline focus:text-white transition duration-150 ease-in-out" title="View Website">
                    <i class="fas fa-external-link-alt"></i>
                </a>
                
                <!-- View Admin Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="ml-3 p-1 text-gray-300 rounded-full hover:bg-gray-800 hover:text-white focus:outline-none focus:shadow-outline focus:text-white transition duration-150 ease-in-out" title="Admin Dashboard">
                    <i class="fas fa-tachometer-alt"></i>
                </a>

                <!-- User dropdown -->
                <div x-data="{ open: false }" class="ml-3 relative">
                    <div>
                        <button @click="open = ! open" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                            @if(Auth::user()->avatar)
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                            @else
                                <div class="h-8 w-8 rounded-full bg-red-600 flex items-center justify-center text-white font-semibold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                        </button>
                    </div>

                    <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-30" style="display: none;">
                        <div class="py-1">
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ Auth::user()->name }}
                            </div>
                            
                            <!-- User Dashboard -->
                            <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">User Dashboard</a>
                            
                            <!-- Admin Dashboard -->
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Dashboard</a>
                            
                            <!-- Profile -->
                            <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            
                            <div class="border-t border-gray-100"></div>
                            
                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-300 hover:bg-gray-800 focus:outline-none focus:bg-gray-800 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-4 pb-1 border-t border-gray-800">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    @if(Auth::user()->avatar)
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                    @else
                        <div class="h-10 w-10 rounded-full bg-red-600 flex items-center justify-center text-white font-semibold text-xl">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-400">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Role Management -->
                <a href="{{ route('superadmin.roles.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('superadmin.roles.*') ? 'border-red-500 text-red-300 bg-gray-800' : 'border-transparent text-gray-300 hover:bg-gray-800 hover:border-gray-600' }} text-base font-medium">
                    Role Management
                </a>
                
                <!-- Audit Logs -->
                <a href="{{ route('superadmin.audit-logs.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('superadmin.audit-logs.*') ? 'border-red-500 text-red-300 bg-gray-800' : 'border-transparent text-gray-300 hover:bg-gray-800 hover:border-gray-600' }} text-base font-medium">
                    Audit Logs
                </a>
                
                <!-- System Settings -->
                <a href="{{ route('superadmin.settings.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('superadmin.settings.*') ? 'border-red-500 text-red-300 bg-gray-800' : 'border-transparent text-gray-300 hover:bg-gray-800 hover:border-gray-600' }} text-base font-medium">
                    System Settings
                </a>
                
                <!-- Database Backup -->
                <a href="{{ route('superadmin.backups.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('superadmin.backups.*') ? 'border-red-500 text-red-300 bg-gray-800' : 'border-transparent text-gray-300 hover:bg-gray-800 hover:border-gray-600' }} text-base font-medium">
                    Database Backups
                </a>
                
                <!-- Admin Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-300 hover:bg-gray-800 hover:border-gray-600 text-base font-medium">
                    Admin Dashboard
                </a>
                
                <!-- User Dashboard -->
                <a href="{{ route('user.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-300 hover:bg-gray-800 hover:border-gray-600 text-base font-medium">
                    User Dashboard
                </a>
                
                <!-- Back to Website -->
                <a href="{{ route('welcome') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-300 hover:bg-gray-800 hover:border-gray-600 text-base font-medium">
                    Back to Website
                </a>
                
                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-300 hover:bg-gray-800 hover:border-gray-600 text-base font-medium">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<aside :class="{'translate-x-0': openSidebar, '-translate-x-full': ! openSidebar}" class="transform md:translate-x-0 fixed z-20 inset-y-0 left-0 w-64 bg-gray-900 pt-16 pb-4 overflow-y-auto transition-transform duration-200 ease-in-out md:static md:inset-0">
    <div class="px-6 pt-4">
        <div class="flex items-center">
            @if(Auth::user()->avatar)
                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
            @else
                <div class="h-10 w-10 rounded-full bg-red-600 flex items-center justify-center text-white font-semibold text-xl">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            @endif
            <div class="ml-3">
                <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                <p class="text-xs font-medium text-gray-400">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
    <nav class="mt-8">
        <div class="px-6">
            <h3 class="text-xs font-semibold text-red-400 uppercase tracking-wider">System</h3>
            <div class="mt-3 space-y-1">
                <!-- Role Management -->
                <a href="{{ route('superadmin.roles.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('superadmin.roles.*') ? 'text-white bg-gray-800' : 'text-gray-300 hover:text-white hover:bg-gray-800' }}">
                    <i class="fas fa-user-shield mr-3 text-lg {{ request()->routeIs('superadmin.roles.*') ? 'text-red-400' : 'text-gray-500 group-hover:text-gray-400' }}"></i>
                    Role Management
                </a>
                
                <!-- Audit Logs -->
                <a href="{{ route('superadmin.audit-logs.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('superadmin.audit-logs.*') ? 'text-white bg-gray-800' : 'text-gray-300 hover:text-white hover:bg-gray-800' }}">
                    <i class="fas fa-history mr-3 text-lg {{ request()->routeIs('superadmin.audit-logs.*') ? 'text-red-400' : 'text-gray-500 group-hover:text-gray-400' }}"></i>
                    Audit Logs
                </a>
                
                <!-- System Settings -->
                <a href="{{ route('superadmin.settings.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('superadmin.settings.*') ? 'text-white bg-gray-800' : 'text-gray-300 hover:text-white hover:bg-gray-800' }}">
                    <i class="fas fa-cogs mr-3 text-lg {{ request()->routeIs('superadmin.settings.*') ? 'text-red-400' : 'text-gray-500 group-hover:text-gray-400' }}"></i>
                    System Settings
                </a>
            </div>
        </div>
        
        <div class="px-6 mt-6">
            <h3 class="text-xs font-semibold text-red-400 uppercase tracking-wider">Database</h3>
            <div class="mt-3 space-y-1">
                <!-- Database Backup -->
                <a href="{{ route('superadmin.backups.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('superadmin.backups.*') ? 'text-white bg-gray-800' : 'text-gray-300 hover:text-white hover:bg-gray-800' }}">
                    <i class="fas fa-database mr-3 text-lg {{ request()->routeIs('superadmin.backups.*') ? 'text-red-400' : 'text-gray-500 group-hover:text-gray-400' }}"></i>
                    Backups
                </a>
                
                <!-- Create Backup -->
                <button onclick="document.getElementById('create-backup-form').submit();" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md w-full text-left text-gray-300 hover:text-white hover:bg-gray-800">
                    <i class="fas fa-plus-circle mr-3 text-lg text-gray-500 group-hover:text-gray-400"></i>
                    Create Backup
                </button>
                <form id="create-backup-form" action="{{ route('superadmin.backups.create') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
        
        <div class="px-6 mt-6">
            <h3 class="text-xs font-semibold text-red-400 uppercase tracking-wider">Dashboards</h3>
            <div class="mt-3 space-y-1">
                <!-- Admin Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-300 hover:text-white hover:bg-gray-800">
                    <i class="fas fa-tachometer-alt mr-3 text-lg text-gray-500 group-hover:text-gray-400"></i>
                    Admin Dashboard
                </a>
                
                <!-- User Dashboard -->
                <a href="{{ route('user.dashboard') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-300 hover:text-white hover:bg-gray-800">
                    <i class="fas fa-user mr-3 text-lg text-gray-500 group-hover:text-gray-400"></i>
                    User Dashboard
                </a>
                
                <!-- Back to Website -->
                <a href="{{ route('welcome') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-300 hover:text-white hover:bg-gray-800">
                    <i class="fas fa-globe mr-3 text-lg text-gray-500 group-hover:text-gray-400"></i>
                    Back to Website
                </a>
            </div>
        </div>
    </nav>
</aside>
@endsection

@section('content')
<div class="md:pl-64">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @hasSection('page-header')
            <div class="mb-6">
                @yield('page-header')
            </div>
        @endif

        <!-- Main content goes here -->
        @yield('superadmin-content')
    </div>
</div>
@endsection
