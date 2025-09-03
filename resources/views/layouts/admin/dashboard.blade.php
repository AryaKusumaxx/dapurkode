@extends('layouts.app')

@section('title', isset($title) ? $title : 'Admin Dashboard')

@section('navigation')
<nav x-data="{ open: false, openSidebar: false }" class="bg-gray-800 border-b border-gray-700">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Hamburger menu for sidebar (mobile) -->
                <button @click="openSidebar = ! openSidebar" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 md:hidden hover:text-gray-300 hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': openSidebar, 'inline-flex': ! openSidebar }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! openSidebar, 'inline-flex': openSidebar }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="block h-12 w-auto">
                        <img src="{{ asset('storage/images/dapurkode.png') }}" alt="DapurKode" class="h-8 w-auto">
                    </a>
                </div>

                <!-- Page title -->
                <div class="hidden md:flex md:items-center md:ml-6">
                    <h1 class="text-xl font-semibold text-white">@yield('page-title', 'Admin Dashboard')</h1>
                </div>
            </div>

            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <!-- View Website -->
                <a href="{{ route('welcome') }}" target="_blank" class="p-1 text-gray-300 rounded-full hover:bg-gray-700 hover:text-white focus:outline-none focus:shadow-outline focus:text-white transition duration-150 ease-in-out" title="View Website">
                    <i class="fas fa-external-link-alt"></i>
                </a>
                
                <!-- Notification bell -->
                <div x-data="{ open: false }" class="ml-3 relative">
                    <button @click="open = !open" class="p-1 text-gray-400 rounded-full hover:bg-gray-700 hover:text-white focus:outline-none focus:shadow-outline focus:text-white transition duration-150 ease-in-out" title="Notifications">
                        <i class="fas fa-bell"></i>
                    </button>
                    
                    <!-- Notification panel -->
                    <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" style="display: none;">
                        <div class="py-2">
                            <div class="px-4 py-2 text-xs text-gray-400 border-b border-gray-200 font-semibold">
                                Notifications
                            </div>
                            <!-- Sample notifications -->
                            <a href="#" class="block px-4 py-3 hover:bg-gray-100 border-b border-gray-200">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 h-6 w-6 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="ml-3 w-0 flex-1">
                                        <p class="text-sm font-medium text-gray-900">New user registration</p>
                                        <p class="text-xs text-gray-500">5 minutes ago</p>
                                    </div>
                                </div>
                            </a>
                            <a href="#" class="block px-4 py-3 hover:bg-gray-100 border-b border-gray-200">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 h-6 w-6 rounded-full bg-green-500 flex items-center justify-center text-white text-xs">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <div class="ml-3 w-0 flex-1">
                                        <p class="text-sm font-medium text-gray-900">New payment received</p>
                                        <p class="text-xs text-gray-500">1 hour ago</p>
                                    </div>
                                </div>
                            </a>
                            <!-- View all link -->
                            <div class="px-4 py-2 text-center text-xs">
                                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">View all notifications</a>
                            </div>
                        </div>
                    </div>
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

                    <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-30" style="display: none;">
                        <div class="py-1">
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ Auth::user()->name }}
                            </div>
                            
                            <!-- User Dashboard -->
                            <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">User Dashboard</a>
                            
                            <!-- Profile -->
                            <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            
                            <!-- Superadmin Dashboard Link (if applicable) -->
                            @if(Auth::user()->hasRole('superadmin'))
                            <a href="{{ route('superadmin.roles.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Superadmin Panel</a>
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
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-300 hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150 ease-in-out">
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
        <div class="pt-4 pb-1 border-t border-gray-700">
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
                    <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-400">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('admin.dashboard') ? 'border-blue-400 text-blue-300 bg-gray-700' : 'border-transparent text-gray-300 hover:bg-gray-700 hover:border-gray-500' }} text-base font-medium">
                    Dashboard
                </a>
                
                <!-- Users -->
                <a href="{{ route('admin.users.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('admin.users.*') ? 'border-blue-400 text-blue-300 bg-gray-700' : 'border-transparent text-gray-300 hover:bg-gray-700 hover:border-gray-500' }} text-base font-medium">
                    Users
                </a>
                
                <!-- Products -->
                <a href="{{ route('admin.products.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('admin.products.*') ? 'border-blue-400 text-blue-300 bg-gray-700' : 'border-transparent text-gray-300 hover:bg-gray-700 hover:border-gray-500' }} text-base font-medium">
                    Products
                </a>
                
                <!-- Orders -->
                <a href="{{ route('admin.orders.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('admin.orders.*') ? 'border-blue-400 text-blue-300 bg-gray-700' : 'border-transparent text-gray-300 hover:bg-gray-700 hover:border-gray-500' }} text-base font-medium">
                    Orders
                </a>
                
                <!-- Payments -->
                <a href="{{ route('admin.payments.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('admin.payments.*') ? 'border-blue-400 text-blue-300 bg-gray-700' : 'border-transparent text-gray-300 hover:bg-gray-700 hover:border-gray-500' }} text-base font-medium">
                    Payments
                </a>
                
                <!-- User Dashboard -->
                <a href="{{ route('user.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-300 hover:bg-gray-700 hover:border-gray-500 text-base font-medium">
                    User Dashboard
                </a>
                
                <!-- Back to Website -->
                <a href="{{ route('welcome') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-300 hover:bg-gray-700 hover:border-gray-500 text-base font-medium">
                    Back to Website
                </a>
                
                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-300 hover:bg-gray-700 hover:border-gray-500 text-base font-medium">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Sidebar -->
<aside :class="{'translate-x-0': openSidebar, '-translate-x-full': ! openSidebar}" class="transform md:translate-x-0 fixed z-20 inset-y-0 left-0 w-64 bg-gray-800 pt-16 pb-4 overflow-y-auto transition-transform duration-200 ease-in-out md:static md:inset-0">
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
                <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                <p class="text-xs font-medium text-gray-400">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
    <nav class="mt-8">
        <div class="px-6">
            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Dashboard</h3>
            <div class="mt-3 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'text-white bg-gray-900' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <i class="fas fa-tachometer-alt mr-3 text-lg {{ request()->routeIs('admin.dashboard') ? 'text-blue-400' : 'text-gray-500 group-hover:text-gray-400' }}"></i>
                    Dashboard
                </a>
                
                <!-- Users -->
                <a href="{{ route('admin.users.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.users.*') ? 'text-white bg-gray-900' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <i class="fas fa-users mr-3 text-lg {{ request()->routeIs('admin.users.*') ? 'text-blue-400' : 'text-gray-500 group-hover:text-gray-400' }}"></i>
                    Users
                </a>
            </div>
        </div>
        
        <div class="px-6 mt-6">
            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Products</h3>
            <div class="mt-3 space-y-1">
                <!-- Products List -->
                <a href="{{ route('admin.products.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.products.*') ? 'text-white bg-gray-900' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <i class="fas fa-boxes mr-3 text-lg {{ request()->routeIs('admin.products.*') ? 'text-blue-400' : 'text-gray-500 group-hover:text-gray-400' }}"></i>
                    Products
                </a>
                
                <!-- Create Product -->
                <a href="{{ route('admin.products.create') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.products.create') ? 'text-white bg-gray-900' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <i class="fas fa-plus-circle mr-3 text-lg {{ request()->routeIs('admin.products.create') ? 'text-blue-400' : 'text-gray-500 group-hover:text-gray-400' }}"></i>
                    Add Product
                </a>
            </div>
        </div>
        
        <div class="px-6 mt-6">
            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Orders</h3>
            <div class="mt-3 space-y-1">
                <!-- All Orders -->
                <a href="{{ route('admin.orders.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ (request()->routeIs('admin.orders.index') && request()->query('status') == null) ? 'text-white bg-gray-900' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <i class="fas fa-shopping-cart mr-3 text-lg {{ (request()->routeIs('admin.orders.index') && request()->query('status') == null) ? 'text-blue-400' : 'text-gray-500 group-hover:text-gray-400' }}"></i>
                    All Orders
                </a>
                
                <!-- Pending Orders -->
                <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ (request()->routeIs('admin.orders.index') && request()->query('status') == 'pending') ? 'text-white bg-gray-900' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <i class="fas fa-clock mr-3 text-lg {{ (request()->routeIs('admin.orders.index') && request()->query('status') == 'pending') ? 'text-blue-400' : 'text-gray-500 group-hover:text-gray-400' }}"></i>
                    Pending
                </a>
                
                <!-- Paid Orders -->
                <a href="{{ route('admin.orders.index', ['status' => 'paid']) }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ (request()->routeIs('admin.orders.index') && request()->query('status') == 'paid') ? 'text-white bg-gray-900' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <i class="fas fa-check-circle mr-3 text-lg {{ (request()->routeIs('admin.orders.index') && request()->query('status') == 'paid') ? 'text-blue-400' : 'text-gray-500 group-hover:text-gray-400' }}"></i>
                    Paid
                </a>
                
                <!-- Completed Orders -->
                <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ (request()->routeIs('admin.orders.index') && request()->query('status') == 'completed') ? 'text-white bg-gray-900' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <i class="fas fa-flag-checkered mr-3 text-lg {{ (request()->routeIs('admin.orders.index') && request()->query('status') == 'completed') ? 'text-blue-400' : 'text-gray-500 group-hover:text-gray-400' }}"></i>
                    Completed
                </a>
                
                <!-- Cancelled Orders -->
                <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ (request()->routeIs('admin.orders.index') && request()->query('status') == 'cancelled') ? 'text-white bg-gray-900' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <i class="fas fa-times-circle mr-3 text-lg {{ (request()->routeIs('admin.orders.index') && request()->query('status') == 'cancelled') ? 'text-blue-400' : 'text-gray-500 group-hover:text-gray-400' }}"></i>
                    Cancelled
                </a>
            </div>
        </div>
        
        <div class="px-6 mt-6">
            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Payments</h3>
            <div class="mt-3 space-y-1">
                <!-- Pending Payments -->
                <a href="{{ route('admin.payments.index', ['status' => 'pending']) }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ (request()->routeIs('admin.payments.index') && request()->query('status') == 'pending') ? 'text-white bg-gray-900' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <i class="fas fa-hourglass-half mr-3 text-lg {{ (request()->routeIs('admin.payments.index') && request()->query('status') == 'pending') ? 'text-blue-400' : 'text-gray-500 group-hover:text-gray-400' }}"></i>
                    Pending
                </a>
                
                <!-- Verified Payments -->
                <a href="{{ route('admin.payments.index', ['status' => 'verified']) }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ (request()->routeIs('admin.payments.index') && request()->query('status') == 'verified') ? 'text-white bg-gray-900' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <i class="fas fa-check mr-3 text-lg {{ (request()->routeIs('admin.payments.index') && request()->query('status') == 'verified') ? 'text-blue-400' : 'text-gray-500 group-hover:text-gray-400' }}"></i>
                    Verified
                </a>
                
                <!-- Rejected Payments -->
                <a href="{{ route('admin.payments.index', ['status' => 'rejected']) }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ (request()->routeIs('admin.payments.index') && request()->query('status') == 'rejected') ? 'text-white bg-gray-900' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                    <i class="fas fa-ban mr-3 text-lg {{ (request()->routeIs('admin.payments.index') && request()->query('status') == 'rejected') ? 'text-blue-400' : 'text-gray-500 group-hover:text-gray-400' }}"></i>
                    Rejected
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
        @yield('admin-content')
    </div>
</div>
@endsection
