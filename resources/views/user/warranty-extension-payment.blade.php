@extends('layouts.guest.navigation')

@section('title', 'Pembayaran Perpanjangan Garansi')

@section('content')
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold">Pembayaran Perpanjangan Garansi</h1>
        <p class="mt-2">Selesaikan pembayaran untuk perpanjangan garansi produk Anda</p>
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
                    <span class="ml-2 text-gray-700 font-medium">Pembayaran Perpanjangan</span>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-xl font-semibold text-gray-900">Metode Pembayaran</h2>
                    <p class="mt-1 text-sm text-gray-500">Pilih metode pembayaran untuk melanjutkan</p>
                </div>
                
                <div class="bg-white p-6">
                    <form action="{{ route('user.warranty.extension.payment.process', $extension) }}" method="POST" class="space-y-6" x-data="{ paymentMethod: 'bank_transfer' }">
                        @csrf
                        
                        <!-- Metode Pembayaran -->
                        <div>
                            <label class="text-base font-medium text-gray-900">Pilih Metode Pembayaran</label>
                            <fieldset class="mt-4">
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input id="bank_transfer" name="payment_method" type="radio" checked x-model="paymentMethod" value="bank_transfer" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="bank_transfer" class="ml-3 block text-sm font-medium text-gray-700">
                                            Transfer Bank
                                        </label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="credit_card" name="payment_method" type="radio" x-model="paymentMethod" value="credit_card" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="credit_card" class="ml-3 block text-sm font-medium text-gray-700">
                                            Kartu Kredit
                                        </label>
                                    </div>
                                </div>
                            </fieldset>
                            
                            @error('payment_method')
                            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Bank Transfer Fields -->
                        <div x-show="paymentMethod === 'bank_transfer'" class="space-y-4 border-t border-gray-200 pt-4">
                            <div>
                                <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank Tujuan</label>
                                <select id="bank_name" name="bank_name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="bca">BCA</option>
                                    <option value="bni">BNI</option>
                                    <option value="mandiri">Mandiri</option>
                                    <option value="bri">BRI</option>
                                </select>
                                @error('bank_name')
                                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="payment_proof" class="block text-sm font-medium text-gray-700">Bukti Pembayaran</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="payment_proof" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Upload bukti</span>
                                                <input id="payment_proof" name="payment_proof" type="file" class="sr-only">
                                            </label>
                                            <p class="pl-1">atau seret dan lepas</p>
                                        </div>
                                        <p class="text-xs text-gray-500">
                                            PNG, JPG, GIF hingga 2MB
                                        </p>
                                    </div>
                                </div>
                                @error('payment_proof')
                                <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Credit Card Fields (for demo only) -->
                        <div x-show="paymentMethod === 'credit_card'" class="space-y-4 border-t border-gray-200 pt-4">
                            <div>
                                <label for="card_number" class="block text-sm font-medium text-gray-700">Nomor Kartu</label>
                                <input type="text" name="card_number" id="card_number" placeholder="1234 5678 9012 3456" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="expiry_date" class="block text-sm font-medium text-gray-700">Tanggal Kadaluarsa</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YY" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                                    <input type="text" name="cvv" id="cvv" placeholder="123" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                            
                            <div>
                                <label for="cardholder_name" class="block text-sm font-medium text-gray-700">Nama Pemegang Kartu</label>
                                <input type="text" name="cardholder_name" id="cardholder_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="pt-5 border-t border-gray-200">
                            <div class="flex justify-end">
                                <a href="{{ route('user.warranty.show', $warranty) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Batal
                                </a>
                                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Bayar Sekarang
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6 sticky top-6">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Ringkasan Pembayaran</h2>
                </div>
                
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-md flex items-center justify-center">
                            <i class="fas fa-box text-gray-500"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="text-sm font-medium text-gray-900">
                                @if($warranty->getProduct())
                                    {{ $warranty->getProduct()->name }}
                                @else
                                    Produk tidak tersedia
                                @endif
                            </div>
                            <div class="text-sm text-gray-500">{{ $warranty->orderItem->variant_name ?? 'Tidak ada varian' }}</div>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Perpanjangan</span>
                            <span class="text-sm text-gray-900">{{ $extension->months }} bulan ({{ $extension->months * 30 }} hari)</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Tanggal Mulai</span>
                            <span class="text-sm text-gray-900">{{ $extension->previous_end_date->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Tanggal Berakhir</span>
                            <span class="text-sm text-gray-900">{{ $extension->new_end_date->format('d M Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 mt-4 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-base font-medium text-gray-900">Total Pembayaran</span>
                            <span class="text-base font-bold text-indigo-600">Rp {{ number_format($extension->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-6 bg-gray-50 p-4 rounded-md">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs text-gray-500">
                                    Perpanjangan garansi akan aktif setelah pembayaran diverifikasi oleh tim kami.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
@endpush
