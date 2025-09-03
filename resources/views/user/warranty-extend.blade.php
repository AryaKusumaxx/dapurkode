@extends('layouts.guest.navigation')

@section('title', 'Perpanjang Garansi')

@section('content')
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold">Perpanjang Garansi</h1>
        <p class="mt-2">Perpanjang masa garansi produk Anda</p>
    </div>
</div>

<div class="bg-gray-50 border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ route('welcome') }}" class="text-gray-500 hover:text-gray-700">Beranda</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('user.dashboard') }}" class="ml-2 text-gray-500 hover:text-gray-700">Dashboard</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('user.warranties') }}" class="ml-2 text-gray-500 hover:text-gray-700">Daftar Garansi</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('user.warranty.show', $warranty) }}" class="ml-2 text-gray-500 hover:text-gray-700">Detail Garansi</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-2 text-gray-700 font-medium">Perpanjang Garansi</span>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif
    
    @if(session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-semibold text-gray-900">Perpanjang Garansi</h2>
            <p class="mt-1 text-sm text-gray-500">Pilih paket perpanjangan garansi yang sesuai untuk produk Anda</p>
        </div>
        
        <div class="bg-white overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 bg-gray-100 rounded-md flex items-center justify-center">
                        <i class="fas fa-box text-gray-500"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            @if($product)
                                {{ $product->name }}
                            @else
                                Produk tidak tersedia
                            @endif
                        </h3>
                        <p class="text-sm text-gray-500">{{ $warranty->orderItem->variant_name ?? 'Tidak ada varian' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-5">
                <div class="mb-4">
                    <h4 class="text-base font-medium text-gray-900">Informasi Garansi Saat Ini</h4>
                    <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500">Tanggal Mulai</p>
                            <p class="text-sm font-medium">{{ $warranty->start_date->format('d M Y') }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500">Tanggal Berakhir</p>
                            <p class="text-sm font-medium">{{ $warranty->end_date->format('d M Y') }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500">Sisa Masa Garansi</p>
                            <p class="text-sm font-medium">{{ $warranty->remainingDays() }} hari</p>
                        </div>
                    </div>
                </div>
                
                <form action="{{ route('user.warranty.extend.process', $warranty) }}" method="POST" class="mt-6">
                    @csrf
                    
                    <div class="space-y-4">
                        <label class="text-base font-medium text-gray-900">Pilih Paket Perpanjangan</label>
                        
                        <div x-data="{ selectedOption: null }" class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($options as $key => $option)
                            <div>
                                <label 
                                    class="relative block p-4 border rounded-lg cursor-pointer focus:outline-none"
                                    :class="{ 'border-indigo-600 border-2 ring-2 ring-indigo-600': selectedOption === {{ $key }} }"
                                >
                                    <input 
                                        type="radio" 
                                        name="months" 
                                        value="{{ $option['months'] }}" 
                                        class="sr-only" 
                                        x-on:change="selectedOption = {{ $key }}"
                                        required
                                    >
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="text-lg font-medium text-gray-900">{{ $option['months'] }} Bulan</span>
                                            <span class="block text-sm text-gray-500">({{ $option['days'] }} hari)</span>
                                        </div>
                                        <svg 
                                            class="h-5 w-5 text-indigo-600"
                                            x-show="selectedOption === {{ $key }}"
                                            xmlns="http://www.w3.org/2000/svg" 
                                            viewBox="0 0 20 20" 
                                            fill="currentColor"
                                            style="display: none;"
                                        >
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">Perpanjang garansi produk Anda selama {{ $option['months'] }} bulan</p>
                                    <div class="mt-2 flex items-center justify-between">
                                        <span class="text-xl font-semibold text-gray-900">Rp {{ number_format($option['price'], 0, ',', '.') }}</span>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        
                        @error('months')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('user.warranty.show', $warranty) }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Lanjutkan ke Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
@endpush
