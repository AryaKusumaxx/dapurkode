@extends('layouts.admin.app')

@section('title', 'Detail Garansi')

@section('content')
<div x-data="{ activeTab: 'details' }" class="container mx-auto px-4 py-6">
    <!-- Notification System -->
    <div id="notifications" class="fixed top-5 right-5 z-50">
        @if(session('success'))
        <div x-data="{ show: true }" 
             x-init="setTimeout(() => show = false, 5000)" 
             x-show="show" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform translate-y-2"
             class="bg-green-50 border-l-4 border-green-400 p-4 mb-4 rounded-md shadow-lg" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button @click="show = false" class="inline-flex text-green-500 hover:text-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 rounded-md">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div x-data="{ show: true }" 
             x-init="setTimeout(() => show = false, 5000)" 
             x-show="show" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform translate-y-2"
             class="bg-red-50 border-l-4 border-red-400 p-4 mb-4 rounded-md shadow-lg" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button @click="show = false" class="inline-flex text-red-500 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 rounded-md">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Hero Section with Status Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
        <div class="md:flex">
            <div class="p-8 md:w-2/3">
                <div class="flex justify-between">
                    <div>
                        <div class="uppercase tracking-wide text-sm text-indigo-600 font-semibold">Garansi #{{ $warranty->id }}</div>
                        <h1 class="mt-2 text-3xl font-bold text-gray-900 leading-tight">
                            {{ $warranty->orderItem && $warranty->orderItem->product ? $warranty->orderItem->product->name : 'Produk Tidak Tersedia' }}
                        </h1>
                        <p class="mt-2 text-gray-600">
                            {{ $warranty->orderItem && $warranty->orderItem->variant_name ? $warranty->orderItem->variant_name : '' }}
                        </p>
                        <div class="mt-4">
                            @if($warranty->isActive())
                                <span class="relative inline-block">
                                    <span class="flex h-3 w-3">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                                    </span>
                                </span>
                                <span class="ml-2 font-medium text-green-600">Aktif</span>
                                <span class="ml-2 text-gray-600">Berlaku hingga: {{ $warranty->end_date->format('d M Y') }}</span>
                                <span class="ml-2 text-sm text-blue-600">({{ now()->diffForHumans($warranty->end_date, ['parts' => 2]) }} lagi)</span>
                            @else
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                                    <span class="mr-1">●</span>
                                    Kadaluarsa
                                </span>
                                <span class="ml-2 text-gray-600">Berakhir pada: {{ $warranty->end_date->format('d M Y') }}</span>
                                <span class="ml-2 text-sm text-gray-500">({{ now()->diffForHumans($warranty->end_date) }})</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="hidden md:block">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.warranties.download', $warranty) }}" class="group inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 active:bg-indigo-800 transition duration-150 ease-in-out">
                                <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download Sertifikat
                            </a>
                            <a href="{{ route('admin.warranties.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-lg font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 active:bg-gray-300 transition duration-150 ease-in-out">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="md:w-1/3 bg-gradient-to-br from-indigo-500 to-purple-600 text-white p-8 flex items-center justify-center">
                @if($warranty->isActive())
                    <div class="text-center">
                        @php
                            $daysLeft = now()->diffInDays($warranty->end_date);
                            $totalDays = $warranty->start_date->diffInDays($warranty->end_date);
                            $percentage = ($totalDays > 0) ? (($totalDays - $daysLeft) / $totalDays) * 100 : 0;
                        @endphp
                        
                        <div class="relative inline-flex items-center justify-center">
                            <svg class="w-32 h-32" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="18" cy="18" r="16" fill="none" stroke="#ffffff33" stroke-width="2"></circle>
                                <circle cx="18" cy="18" r="16" fill="none" stroke="#fff" stroke-width="2" stroke-dasharray="100" stroke-dashoffset="{{ 100 - $percentage }}" transform="rotate(-90 18 18)"></circle>
                                <text x="18" y="18" text-anchor="middle" dominant-baseline="middle" fill="#fff" font-size="0.35em" font-weight="bold" class="uppercase">Garansi</text>
                                <text x="18" y="21" text-anchor="middle" dominant-baseline="middle" fill="#fff" font-size="0.2em">Aktif</text>
                            </svg>
                        </div>
                        <p class="mt-3 text-xl font-bold">{{ $daysLeft }} hari tersisa</p>
                        <p class="text-sm opacity-80">dari total {{ $totalDays }} hari</p>
                    </div>
                @else
                    <div class="text-center">
                        <div class="inline-block p-4 rounded-full bg-white bg-opacity-10 mb-3">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-1">Garansi Kadaluarsa</h3>
                        <p class="text-sm opacity-80">Berakhir {{ $warranty->end_date->diffForHumans() }}</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Mobile Buttons -->
        <div class="md:hidden px-8 pb-6 flex space-x-2">
            <a href="{{ route('admin.warranties.download', $warranty) }}" class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 active:bg-indigo-800 transition duration-150 ease-in-out">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Download
            </a>
            <a href="{{ route('admin.warranties.index') }}" class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-gray-200 border border-transparent rounded-lg font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 active:bg-gray-300 transition duration-150 ease-in-out">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>
    
    <!-- Tab Navigation -->
    <div class="mb-6">
        <nav class="flex space-x-4 overflow-x-auto pb-2" aria-label="Tabs">
            <button @click="activeTab = 'details'" :class="{ 'bg-indigo-100 text-indigo-700': activeTab === 'details', 'text-gray-500 hover:text-gray-700': activeTab !== 'details' }" class="px-3 py-2 font-medium text-sm rounded-md transition duration-150 ease-in-out flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Detail Garansi
            </button>
            <button @click="activeTab = 'history'" :class="{ 'bg-indigo-100 text-indigo-700': activeTab === 'history', 'text-gray-500 hover:text-gray-700': activeTab !== 'history' }" class="px-3 py-2 font-medium text-sm rounded-md transition duration-150 ease-in-out flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Riwayat
            </button>
            <button @click="activeTab = 'invoice'" :class="{ 'bg-indigo-100 text-indigo-700': activeTab === 'invoice', 'text-gray-500 hover:text-gray-700': activeTab !== 'invoice' }" class="px-3 py-2 font-medium text-sm rounded-md transition duration-150 ease-in-out flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Invoice
            </button>
            <button @click="activeTab = 'actions'" :class="{ 'bg-indigo-100 text-indigo-700': activeTab === 'actions', 'text-gray-500 hover:text-gray-700': activeTab !== 'actions' }" class="px-3 py-2 font-medium text-sm rounded-md transition duration-150 ease-in-out flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Tindakan
            </button>
        </nav>
    </div>

    <!-- Tab Content -->
    <div>
        <!-- Details Tab -->
        <div x-show="activeTab === 'details'" class="bg-white rounded-xl shadow-md overflow-hidden p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Detail Informasi Garansi</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Nomor Serial</h3>
                        <p class="mt-1 text-base font-semibold text-gray-900">{{ $warranty->serial_number }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Tanggal Mulai</h3>
                        <p class="mt-1 text-base font-semibold text-gray-900">{{ $warranty->start_date->format('d M Y') }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Tanggal Berakhir</h3>
                        <p class="mt-1 text-base font-semibold text-gray-900">{{ $warranty->end_date->format('d M Y') }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Durasi</h3>
                        <p class="mt-1 text-base font-semibold text-gray-900">{{ $warranty->duration }} bulan</p>
                    </div>
                </div>
                
                <div>
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Customer</h3>
                        <p class="mt-1 text-base font-semibold text-gray-900">
                            {{ $warranty->orderItem && $warranty->orderItem->order && $warranty->orderItem->order->user ? $warranty->orderItem->order->user->name : 'Tidak tersedia' }}
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Email</h3>
                        <p class="mt-1 text-base font-semibold text-gray-900">
                            {{ $warranty->orderItem && $warranty->orderItem->order && $warranty->orderItem->order->user ? $warranty->orderItem->order->user->email : 'Tidak tersedia' }}
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Nomor Telepon</h3>
                        <p class="mt-1 text-base font-semibold text-gray-900">
                            {{ $warranty->orderItem && $warranty->orderItem->order && $warranty->orderItem->order->user && $warranty->orderItem->order->user->phone ? $warranty->orderItem->order->user->phone : 'Tidak tersedia' }}
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Nomor Order</h3>
                        <p class="mt-1 text-base font-semibold text-gray-900">
                            @if($warranty->orderItem && $warranty->orderItem->order)
                                <a href="{{ route('admin.orders.show', $warranty->orderItem->order) }}" class="text-indigo-600 hover:text-indigo-800 underline">#{{ $warranty->orderItem->order->order_number }}</a>
                            @else
                                Tidak tersedia
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
            @if(!empty($warranty->notes))
            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h3 class="font-medium text-yellow-800 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Catatan Garansi
                </h3>
                <div class="mt-2 text-sm text-yellow-700 whitespace-pre-wrap">{{ $warranty->notes }}</div>
            </div>
            @endif
        </div>
        
        <!-- History Tab -->
        <div x-show="activeTab === 'history'" class="bg-white rounded-xl shadow-md overflow-hidden p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Riwayat Garansi</h2>
            
            <div class="relative">
                <!-- Timeline -->
                <div class="absolute left-4 top-0 h-full border-l-2 border-gray-200"></div>
                
                <!-- Timeline Items -->
                <div class="space-y-8 relative">
                    <!-- Creation Event -->
                    <div class="relative pl-10">
                        <div class="absolute left-0 top-0 bg-indigo-500 rounded-full w-8 h-8 flex items-center justify-center text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div class="bg-indigo-50 rounded-lg p-4">
                            <h3 class="text-base font-bold text-indigo-800">Garansi Dibuat</h3>
                            <time datetime="{{ $warranty->created_at->format('Y-m-d') }}" class="block text-sm text-indigo-600 mb-1">{{ $warranty->created_at->format('d M Y, H:i') }}</time>
                            <p class="text-sm text-gray-600">Garansi untuk produk {{ $warranty->orderItem && $warranty->orderItem->product ? $warranty->orderItem->product->name : 'Produk Tidak Tersedia' }} telah dibuat dengan durasi {{ $warranty->duration }} bulan.</p>
                        </div>
                    </div>
                    
                    <!-- Activation Event -->
                    <div class="relative pl-10">
                        <div class="absolute left-0 top-0 bg-green-500 rounded-full w-8 h-8 flex items-center justify-center text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <h3 class="text-base font-bold text-green-800">Garansi Aktif</h3>
                            <time datetime="{{ $warranty->start_date->format('Y-m-d') }}" class="block text-sm text-green-600 mb-1">{{ $warranty->start_date->format('d M Y, H:i') }}</time>
                            <p class="text-sm text-gray-600">Garansi dimulai dan diaktifkan.</p>
                        </div>
                    </div>
                    
                    @if($warranty->end_date->isPast())
                    <!-- Expiration Event -->
                    <div class="relative pl-10">
                        <div class="absolute left-0 top-0 bg-red-500 rounded-full w-8 h-8 flex items-center justify-center text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div class="bg-red-50 rounded-lg p-4">
                            <h3 class="text-base font-bold text-red-800">Garansi Berakhir</h3>
                            <time datetime="{{ $warranty->end_date->format('Y-m-d') }}" class="block text-sm text-red-600 mb-1">{{ $warranty->end_date->format('d M Y, H:i') }}</time>
                            <p class="text-sm text-gray-600">Masa garansi telah berakhir.</p>
                        </div>
                    </div>
                    @else
                    <!-- Future Expiration Event -->
                    <div class="relative pl-10">
                        <div class="absolute left-0 top-0 bg-gray-300 rounded-full w-8 h-8 flex items-center justify-center text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 border border-dashed border-gray-300">
                            <h3 class="text-base font-bold text-gray-600">Garansi Akan Berakhir</h3>
                            <time datetime="{{ $warranty->end_date->format('Y-m-d') }}" class="block text-sm text-gray-500 mb-1">{{ $warranty->end_date->format('d M Y, H:i') }}</time>
                            <p class="text-sm text-gray-500">{{ $warranty->end_date->diffForHumans(['parts' => 2]) }} lagi</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Invoice Tab -->
        <div x-show="activeTab === 'invoice'" class="bg-white rounded-xl shadow-md overflow-hidden p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Detail Invoice</h2>
            
            @if($warranty->orderItem && $warranty->orderItem->order && $warranty->orderItem->order->invoice)
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-base font-semibold text-gray-700">
                                Invoice #{{ $warranty->orderItem->order->invoice->invoice_number }}
                            </h3>
                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                @if($warranty->orderItem->order->invoice->status === 'paid') bg-green-100 text-green-800
                                @elseif($warranty->orderItem->order->invoice->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($warranty->orderItem->order->invoice->status === 'canceled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($warranty->orderItem->order->invoice->status) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="px-4 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <div class="text-sm font-medium text-gray-500">Tanggal Invoice</div>
                                <div class="mt-1">{{ $warranty->orderItem->order->invoice->created_at->format('d M Y') }}</div>
                            </div>
                            
                            <div>
                                <div class="text-sm font-medium text-gray-500">Total Pembayaran</div>
                                <div class="mt-1 font-bold text-lg">
                                    {{ 'Rp ' . number_format($warranty->orderItem->order->invoice->grand_total, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Produk Terkait</h4>
                            <div class="bg-gray-50 rounded-lg p-3 flex items-center">
                                <div class="flex-1">
                                    <div class="font-medium">{{ $warranty->orderItem->product ? $warranty->orderItem->product->name : 'Produk Tidak Tersedia' }}</div>
                                    @if($warranty->orderItem->variant_name)
                                        <div class="text-sm text-gray-600">{{ $warranty->orderItem->variant_name }}</div>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <div class="font-medium">
                                        {{ 'Rp ' . number_format($warranty->orderItem->price, 0, ',', '.') }}
                                    </div>
                                    <div class="text-sm text-gray-600">x{{ $warranty->orderItem->quantity }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('admin.invoices.show', $warranty->orderItem->order->invoice) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat Invoice Lengkap
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">Tidak Ada Invoice Tersedia</h3>
                    <p class="text-gray-500 mt-1">Data invoice terkait garansi ini tidak ditemukan.</p>
                </div>
            @endif
        </div>
        
        <!-- Actions Tab -->
        <div x-show="activeTab === 'actions'" class="bg-white rounded-xl shadow-md overflow-hidden p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Tindakan Garansi</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Extend Warranty -->
                <div class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition duration-150">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 rounded-full p-2 mr-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Perpanjang Garansi</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">Perpanjang masa garansi untuk pelanggan ini dengan menambahkan durasi tambahan ke periode garansi saat ini.</p>
                    <button onclick="alert('Fitur perpanjangan garansi sedang dalam pengembangan.')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-200 disabled:opacity-25 transition ease-in-out duration-150">
                        Perpanjang Garansi
                    </button>
                </div>
                
                <!-- Update Status -->
                <div class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition duration-150">
                    <div class="flex items-center mb-4">
                        <div class="bg-yellow-100 rounded-full p-2 mr-3">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Update Status</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">Ubah status garansi atau tambahkan catatan terkait kondisi produk dan garansi.</p>
                    <button onclick="toggleModal('statusModal')" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-200 disabled:opacity-25 transition ease-in-out duration-150">
                        Update Status
                    </button>
                </div>
                
                <!-- Download Certificate -->
                <div class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition duration-150">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 rounded-full p-2 mr-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Sertifikat Garansi</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">Download sertifikat garansi atau kirimkan ke email pelanggan.</p>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.warranties.download', $warranty) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring ring-green-200 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download
                        </a>
                        <button onclick="alert('Fitur email sertifikat garansi sedang dalam pengembangan.')" class="inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-600 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-200 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Email
                        </button>
                    </div>
                </div>
                
                <!-- Delete Warranty -->
                <div class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition duration-150">
                    <div class="flex items-center mb-4">
                        <div class="bg-red-100 rounded-full p-2 mr-3">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Hapus Garansi</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">Hapus data garansi ini dari sistem. Tindakan ini tidak dapat dibatalkan.</p>
                    <button onclick="alert('Fitur hapus garansi sedang dalam pengembangan.')" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring ring-red-200 disabled:opacity-25 transition ease-in-out duration-150">
                        Hapus Garansi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div id="modalBackdrop" onclick="toggleModal('statusModal')" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Update Status Garansi
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Ubah status garansi atau tambahkan catatan terkait kondisi produk.
                            </p>
                        </div>
                    </div>
                </div>
                
                <form action="{{ route('admin.warranties.update-status', $warranty) }}" method="POST" class="mt-5">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="active" {{ $warranty->isActive() ? 'selected' : '' }}>Aktif</option>
                            <option value="expired" {{ !$warranty->isActive() ? 'selected' : '' }}>Kadaluarsa</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                        <textarea id="notes" name="notes" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Tambahkan catatan tentang kondisi produk atau garansi...">{{ $warranty->notes }}</textarea>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Simpan
                        </button>
                        <button type="button" onclick="toggleModal('statusModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal.classList.contains('hidden')) {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    } else {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
}
</script>
@endsection
