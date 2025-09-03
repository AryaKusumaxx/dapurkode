<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
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
                            
                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-md mb-6">
                                <div class="flex flex-col md:flex-row gap-4 items-start">
                                    <div class="w-full md:w-1/3">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="rounded-md w-full object-cover">
                                        @else
                                            <div class="bg-gray-300 dark:bg-gray-600 rounded-md w-full h-48 flex items-center justify-center">
                                                <span class="text-gray-500 dark:text-gray-400">No Image</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="w-full md:w-2/3">
                                        <h4 class="text-xl font-semibold">{{ $product->name }}</h4>
                                        
                                        @if($variant)
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                Variant: {{ $variant->name }}
                                            </p>
                                        @endif
                                        
                                        @if($warranty)
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Garansi: {{ $warranty->name }} ({{ $warranty->duration_months }} bulan)
                                            </p>
                                        @endif
                                        
                                        <p class="mt-2">{{ Str::limit($product->description, 150) }}</p>
                                        
                                        <div class="mt-3">
                                            <p><span class="font-semibold">Harga Produk:</span> Rp {{ number_format($basePrice, 0, ',', '.') }}</p>
                                            
                                            @if($warranty)
                                                <p><span class="font-semibold">Harga Garansi:</span> Rp {{ number_format($warrantyPrice, 0, ',', '.') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                @if($variant)
                                    <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                                @endif
                                @if($warranty)
                                    <input type="hidden" name="warranty_id" value="{{ $warranty->id }}">
                                @endif
                                
                                <div class="mb-4">
                                    <label for="discount_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kode Diskon (Opsional)</label>
                                    <input type="text" id="discount_code" name="discount_code" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Masukkan kode diskon jika ada">
                                    @error('discount_code')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan (Opsional)</label>
                                    <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Catatan tambahan untuk pesanan Anda..."></textarea>
                                    @error('notes')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="mt-8 md:hidden">
                                    <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-md">
                                        <h4 class="font-bold mb-2">Ringkasan Pesanan</h4>
                                        <div class="space-y-1">
                                            <div class="flex justify-between">
                                                <span>Subtotal</span>
                                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>PPN (11%)</span>
                                                <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="border-t border-gray-300 dark:border-gray-600 my-2 pt-2 flex justify-between font-bold">
                                                <span>Total</span>
                                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Proses Pesanan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <div class="md:col-span-1 hidden md:block">
                            <div class="sticky top-6">
                                <h3 class="text-lg font-bold mb-4">Ringkasan Pesanan</h3>
                                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-md">
                                    <div class="space-y-2 mb-4">
                                        <div class="flex justify-between">
                                            <span>Subtotal</span>
                                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>PPN (11%)</span>
                                            <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="border-t border-gray-300 dark:border-gray-600 my-2 pt-2 flex justify-between font-bold">
                                            <span>Total</span>
                                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    
                                    <button form="checkout-form" type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Proses Pesanan
                                    </button>
                                </div>
                                
                                <div class="mt-4 bg-gray-100 dark:bg-gray-700 p-4 rounded-md">
                                    <h4 class="font-semibold mb-2">Informasi Pembayaran</h4>
                                    <p class="text-sm">Setelah mengkonfirmasi pesanan, Anda akan diarahkan ke halaman pembayaran untuk menyelesaikan transaksi.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
