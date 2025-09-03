@extends('layouts.app')

@section('title', isset($title) ? $title : 'Home')

@section('navigation')
<nav x-data="{ open: false }" class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}" class="block h-12 w-auto">
                        <img src="{{ asset('storage/images/dapurkode.png') }}" alt="DapurKode" class="h-10 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:ml-10 sm:flex">
                    <a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'border-b-2 border-blue-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                        Home
                    </a>
                    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'border-b-2 border-blue-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                        Products
                    </a>
                    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'border-b-2 border-blue-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                        About
                    </a>
                    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'border-b-2 border-blue-500 text-gray-900' : 'text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                        Contact
                    </a>
                </div>
            </div>

            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <!-- Authentication Links -->
                @guest
                    <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">Log in</a>
                    <a href="{{ route('register') }}" class="ml-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">Register</a>
                @else
                    <!-- Notification Icon -->
                    <div x-data="{ open: false }" class="ml-3 relative">
                        <button @click="open = !open" class="p-1 rounded-full text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 relative">
                            <span class="sr-only">View notifications</span>
                            <!-- Notification Icon -->
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <!-- Badge indicator -->
                            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                        </button>
                        
                        <!-- Notification dropdown -->
                        <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" style="display: none;">
                            <div class="py-2 px-4 border-b border-gray-100">
                                <h3 class="text-sm font-medium text-gray-900">Notifikasi</h3>
                            </div>
                            <div class="max-h-64 overflow-y-auto">
                                <a href="#" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 bg-blue-500 h-8 w-8 rounded-full flex items-center justify-center text-white">
                                            <i class="fas fa-tag text-xs"></i>
                                        </div>
                                        <div class="ml-3 w-0 flex-1">
                                            <p class="text-sm font-medium text-gray-900">Pembayaran berhasil!</p>
                                            <p class="text-sm text-gray-500">Pembayaran untuk pesanan #ORD12345 telah dikonfirmasi.</p>
                                            <p class="mt-1 text-xs text-gray-400">2 jam yang lalu</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 bg-green-500 h-8 w-8 rounded-full flex items-center justify-center text-white">
                                            <i class="fas fa-box text-xs"></i>
                                        </div>
                                        <div class="ml-3 w-0 flex-1">
                                            <p class="text-sm font-medium text-gray-900">Produk dikirim!</p>
                                            <p class="text-sm text-gray-500">Pesanan Anda #ORD12344 telah dikirim.</p>
                                            <p class="mt-1 text-xs text-gray-400">1 hari yang lalu</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="py-1 border-t border-gray-100">
                                <a href="#" class="block px-4 py-2 text-sm text-center text-blue-600 hover:bg-gray-50">
                                    Lihat semua notifikasi
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Profile Dropdown -->
                    <div x-data="{ open: false }" class="ml-3 relative">
                        <div>
                            <button @click="open = ! open" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </div>

                        <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" style="display: none;">
                            <div class="py-1">
                                <!-- User Account Section -->
                                <div class="px-4 py-2 text-xs text-gray-500 border-b border-gray-100">
                                    Akun Pengguna
                                </div>
                                
                                <!-- Dashboard Link -->
                                <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-tachometer-alt w-5 inline-block"></i> Dashboard
                                </a>
                                
                                <!-- Profile Link -->
                                <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user-circle w-5 inline-block"></i> Profil Saya
                                </a>
                                
                                <!-- Orders Link -->
                                <a href="{{ route('user.orders') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-shopping-bag w-5 inline-block"></i> Daftar Pesanan
                                </a>
                                
                                <!-- Invoices Link -->
                                <a href="{{ route('user.invoices') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-file-invoice-dollar w-5 inline-block"></i> Faktur
                                </a>
                                
                                <!-- Warranties Link -->
                                <a href="{{ route('user.warranties') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-shield-alt w-5 inline-block"></i> Garansi
                                </a>

                                <!-- Admin Section (if applicable) -->
                                @if(Auth::user()->hasRole(['admin', 'superadmin']))
                                <div class="border-t border-gray-100 mt-2 pt-2">
                                    <div class="px-4 py-2 text-xs text-gray-500">
                                        Administrasi
                                    </div>
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user-shield w-5 inline-block"></i> Admin Dashboard
                                    </a>
                                </div>
                                @endif
                                
                                <!-- Superadmin Section (if applicable) -->
                                @if(Auth::user()->hasRole('superadmin'))
                                <a href="{{ route('superadmin.roles.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user-lock w-5 inline-block"></i> Kelola Role
                                </a>
                                @endif

                                <!-- Logout -->
                                <div class="border-t border-gray-100 mt-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt w-5 inline-block"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endguest
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
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                Home
            </a>
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                Products
            </a>
            <a href="#" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                About
            </a>
            <a href="#" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                Contact
            </a>
        </div>

        <!-- Mobile Authentication Links -->
        @guest
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <svg class="h-10 w-10 fill-current text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">Guest</div>
                        <div class="text-sm font-medium text-gray-500">Not logged in</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        Register
                    </a>
                </div>
            </div>
        @else
            <div class="pt-4 pb-3 border-t border-gray-200">
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
                    <!-- User Account Section -->
                    <div class="px-4 py-2 text-xs text-gray-500">
                        Akun Pengguna
                    </div>
                
                    <!-- Dashboard Link -->
                    <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        <i class="fas fa-tachometer-alt w-5 inline-block"></i> Dashboard
                    </a>
                    
                    <!-- Profile Link -->
                    <a href="{{ route('user.profile') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        <i class="fas fa-user-circle w-5 inline-block"></i> Profil Saya
                    </a>
                    
                    <!-- Orders Link -->
                    <a href="{{ route('user.orders') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        <i class="fas fa-shopping-bag w-5 inline-block"></i> Daftar Pesanan
                    </a>
                    
                    <!-- Invoices Link -->
                    <a href="{{ route('user.invoices') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        <i class="fas fa-file-invoice-dollar w-5 inline-block"></i> Faktur
                    </a>
                    
                    <!-- Warranties Link -->
                    <a href="{{ route('user.warranties') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        <i class="fas fa-shield-alt w-5 inline-block"></i> Garansi
                    </a>
                    
                    <!-- Admin Dashboard Link (if applicable) -->
                    @if(Auth::user()->hasRole(['admin', 'superadmin']))
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        Admin Dashboard
                    </a>
                    @endif
                    
                    <!-- Superadmin Dashboard Link (if applicable) -->
                    @if(Auth::user()->hasRole('superadmin'))
                    <a href="{{ route('superadmin.roles.index') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        Role Management
                    </a>
                    @endif
                    
                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        @endguest
    </div>
</nav>
@endsection
