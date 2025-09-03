@extends('layouts.guest.navigation')

@section('title', 'Dashboard Pengguna')

@section('content')
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold">Dashboard</h1>
        <p class="mt-2">Selamat datang, {{ auth()->user()->name }}</p>
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
                    <span class="ml-2 text-gray-700 font-medium">Dashboard</span>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-full p-3 mr-4">
                    <i class="fas fa-shopping-bag text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $orderCount }}</h3>
                    <p class="text-gray-600">Pesanan Total</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-full p-3 mr-4">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $completedOrderCount }}</h3>
                    <p class="text-gray-600">Pesanan Selesai</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <div class="flex items-center">
                <div class="bg-yellow-100 rounded-full p-3 mr-4">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $pendingOrderCount }}</h3>
                    <p class="text-gray-600">Pesanan Tertunda</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <div class="flex items-center">
                <div class="bg-purple-100 rounded-full p-3 mr-4">
                    <i class="fas fa-shield-alt text-purple-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $warrantyCount }}</h3>
                    <p class="text-gray-600">Garansi Aktif</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Orders -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-medium text-gray-900">Pesanan Terbaru</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentOrders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#{{ $order->order_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    @if($order->items->count() > 0)
                                        {{ $order->items->first()->product->name }}
                                        @if($order->items->count() > 1)
                                            <span class="text-xs text-gray-500">+{{ $order->items->count() - 1 }} lainnya</span>
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <x-order-status :order="$order" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada pesanan terbaru</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-100">
                    <a href="{{ route('user.orders') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Lihat Semua Pesanan <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Active Warranties -->
        <div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-medium text-gray-900">Garansi Aktif</h2>
                </div>
                <div class="p-6 space-y-6">
                    @forelse($activeWarranties as $warranty)
                    <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-medium text-gray-900">
                                    @if($warranty->getProduct())
                                        {{ $warranty->getProduct()->name }}
                                    @else
                                        Produk tidak tersedia
                                    @endif
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    Hingga: {{ $warranty->end_date->format('d M Y') }}
                                </p>
                                <div class="mt-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                </div>
                            </div>
                            <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                Detail
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <p class="text-gray-500">Tidak ada garansi aktif</p>
                    </div>
                    @endforelse
                </div>
                <div class="p-4 border-t border-gray-100">
                    <a href="{{ route('user.warranties') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Lihat Semua Garansi <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 mt-6">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-medium text-gray-900">Tautan Cepat</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-4">
                        <a href="{{ route('user.profile') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition duration-150">
                            <div class="flex-shrink-0 mr-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user-circle text-blue-600"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">Profil</h3>
                                <p class="text-sm text-gray-600">Kelola informasi profil Anda</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('products.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition duration-150">
                            <div class="flex-shrink-0 mr-3">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-store text-green-600"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">Toko</h3>
                                <p class="text-sm text-gray-600">Jelajahi produk terbaru</p>
                            </div>
                        </a>
                        
                        <a href="{{ route('user.invoices') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition duration-150">
                            <div class="flex-shrink-0 mr-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-file-invoice text-purple-600"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">Faktur</h3>
                                <p class="text-sm text-gray-600">Lihat riwayat faktur Anda</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
