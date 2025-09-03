@extends('layouts.guest.navigation')

@section('title', 'Checkout')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Checkout</h1>
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <h3 class="text-lg font-bold mb-4">Detail Pesanan</h3>
                    
                    <div class="bg-gray-100 p-4 rounded-md mb-6">
                        <div class="flex flex-col md:flex-row gap-4 items-start">
                            <div class="w-full md:w-1/3">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="rounded-md w-full object-cover">
                                @else
                                    <div class="bg-gray-300 rounded-md w-full h-48 flex items-center justify-center">
                                        <span class="text-gray-500">No Image</span>
                                    </div>
                                @endif
                            </div>
                            <div class="w-full md:w-2/3">
                                <h4 class="text-xl font-semibold">{{ $product->name }}</h4>
                                
                                @if($variant)
                                    <p class="text-sm text-gray-500 mt-1">
                                        Variant: {{ $variant->name }}
                                    </p>
                                @endif
                                
                                @if($warranty)
                                    <p class="text-sm text-gray-500">
                                        Warranty: {{ $warranty->name }} (+Rp {{ number_format($warrantyPrice, 0, ',', '.') }})
                                    </p>
                                @endif
                                
                                <div class="mt-4">
                                    <p class="font-medium">Harga Dasar: Rp {{ number_format($basePrice, 0, ',', '.') }}</p>
                                    @if($warrantyPrice > 0)
                                        <p>Tambahan Garansi: Rp {{ number_format($warrantyPrice, 0, ',', '.') }}</p>
                                    @endif
                                    <p>Subtotal: Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                                    <p>Pajak (11%): Rp {{ number_format($tax, 0, ',', '.') }}</p>
                                    <p class="text-lg font-bold mt-2">Total: Rp {{ number_format($total, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="md:col-span-1">
                    <div class="bg-gray-100 p-4 rounded-md">
                        <h3 class="text-lg font-bold mb-4">Ringkasan Pesanan</h3>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between">
                                <span>Subtotal:</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Pajak (11%):</span>
                                <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-gray-300 my-2 pt-2 flex justify-between font-bold">
                                <span>Total:</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <!-- Login Required Notice -->
                        <div class="bg-blue-50 border border-blue-300 text-blue-800 p-4 rounded-md mb-4">
                            <p class="font-medium">Login diperlukan untuk melanjutkan pembelian</p>
                            <p class="text-sm mt-1">Silahkan login atau daftar untuk melanjutkan proses checkout.</p>
                        </div>
                        
                        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md w-full block text-center mb-3">
                            Login untuk Melanjutkan
                        </a>
                        
                        <a href="{{ route('register') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-md w-full block text-center">
                            Daftar Akun Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
