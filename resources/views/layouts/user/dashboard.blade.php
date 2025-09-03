@extends('layouts.app')

@section('title', isset($title) ? $title : 'Dashboard')

@section('navigation')
<nav x-data="{ open: false, openSidebar: false }" class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Hamburger menu for sidebar (mobile) -->
                <button @click="openSidebar = ! openSidebar" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 md:hidden hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': openSidebar, 'inline-flex': ! openSidebar }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! openSidebar, 'inline-flex': openSidebar }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}" class="block h-12 w-auto">
                        <img src="{{ asset('storage/images/dapurkode.png') }}" alt="DapurKode" class="h-10 w-auto">
                    </a>
                </div>

                <!-- Page title -->
                <div class="hidden md:flex md:items-center md:ml-6">
                    <h1 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                </div>
            </div>

            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <!-- Notification bell -->
                <div class="ml-3 relative">
                    <button class="p-1 text-gray-400 rounded-full hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:shadow-outline focus:text-gray-500">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>
                </div>

                <!-- User dropdown -->
                <div x-data="{ open: false }" class="ml-3 relative">
                    <div>
                        <button @click="open = ! open" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                            @if(Auth::user()->avatar)
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                            @else
                                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                        </button>
                    </div>

                    <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" style="display: none;">
                        <div class="py-1">
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ Auth::user()->name }}
                            </div>
                            
                            <!-- User Dashboard -->
                            <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                            
                            <!-- Profile -->
                            <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            
                            <!-- Admin Dashboard Link (if applicable) -->
                            @if(Auth::user()->hasRole(['admin', 'superadmin']))
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Dashboard</a>
                            @endif
                            
                            <!-- Superadmin Dashboard Link (if applicable) -->
                            @if(Auth::user()->hasRole('superadmin'))
                            <a href="{{ route('superadmin.roles.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Role Management</a>
                            @endif
                            
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
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
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
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    @if(Auth::user()->avatar)
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                    @else
                        <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold text-xl">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- User Dashboard -->
                <a href="{{ route('user.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('user.dashboard') ? 'border-blue-400 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium">
                    Dashboard
                </a>
                
                <!-- Orders -->
                <a href="{{ route('user.orders') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('user.orders') ? 'border-blue-400 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium">
                    My Orders
                </a>
                
                <!-- Invoices -->
                <a href="{{ route('user.invoices') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('user.invoices') ? 'border-blue-400 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium">
                    My Invoices
                </a>
                
                <!-- Warranties -->
                <a href="{{ route('user.warranties') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('user.warranties') ? 'border-blue-400 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium">
                    My Warranties
                </a>
                
                <!-- Profile -->
                <a href="{{ route('user.profile') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('user.profile') ? 'border-blue-400 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium">
                    Profile
                </a>
                
                <!-- Back to Website -->
                <a href="{{ route('welcome') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 text-base font-medium">
                    Back to Website
                </a>
                
                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 text-base font-medium">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<aside :class="{'translate-x-0': openSidebar, '-translate-x-full': ! openSidebar}" class="transform md:translate-x-0 fixed z-20 inset-y-0 left-0 w-64 bg-white border-r border-gray-200 pt-16 pb-4 overflow-y-auto transition-transform duration-200 ease-in-out md:static md:inset-0">
    <div class="px-6 pt-4">
        <div class="flex items-center">
            @if(Auth::user()->avatar)
                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
            @else
                <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold text-xl">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            @endif
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                <p class="text-xs font-medium text-gray-500">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
    <nav class="mt-8">
        <div class="px-6">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Dashboard</h3>
            <div class="mt-3 space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('user.dashboard') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('user.dashboard') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }}">
                    <i class="fas fa-tachometer-alt mr-3 text-lg {{ request()->routeIs('user.dashboard') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}"></i>
                    Dashboard
                </a>
                
                <!-- Orders -->
                <a href="{{ route('user.orders') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('user.orders') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }}">
                    <i class="fas fa-shopping-bag mr-3 text-lg {{ request()->routeIs('user.orders') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}"></i>
                    My Orders
                </a>
                
                <!-- Invoices -->
                <a href="{{ route('user.invoices') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('user.invoices') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }}">
                    <i class="fas fa-file-invoice-dollar mr-3 text-lg {{ request()->routeIs('user.invoices') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}"></i>
                    My Invoices
                </a>
                
                <!-- Warranties -->
                <a href="{{ route('user.warranties') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('user.warranties') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }}">
                    <i class="fas fa-shield-alt mr-3 text-lg {{ request()->routeIs('user.warranties') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}"></i>
                    My Warranties
                </a>
            </div>
        </div>
        
        <div class="px-6 mt-6">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Account</h3>
            <div class="mt-3 space-y-2">
                <!-- Profile -->
                <a href="{{ route('user.profile') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('user.profile') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }}">
                    <i class="fas fa-user mr-3 text-lg {{ request()->routeIs('user.profile') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}"></i>
                    Profile
                </a>
                
                <!-- Change Password -->
                <a href="{{ route('user.password.form') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('user.password.*') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }}">
                    <i class="fas fa-key mr-3 text-lg {{ request()->routeIs('user.password.*') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}"></i>
                    Change Password
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
        @yield('user-content')
    </div>
</div>
@endsection
