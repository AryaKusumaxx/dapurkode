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
                            <div id="discount_row" class="justify-between" style="display: none;">
                                <span>Diskon:</span>
                                <span id="discount_value">-Rp 0</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Pajak (11%):</span>
                                <span id="tax_value">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-gray-300 my-2 pt-2 flex justify-between font-bold">
                                <span>Total:</span>
                                <span id="total_value">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            @if($variant)
                                <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                            @endif
                            @if($warranty)
                                <input type="hidden" name="warranty_id" value="{{ $warranty->id }}">
                            @endif
                            
                            <!-- Discount Code with Tukar Button -->
                            <div class="mb-4">
                                <label for="discount_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Diskon (opsional):</label>
                                <div class="flex">
                                    <input type="text" id="discount_code" name="discount_code" class="w-full border border-gray-300 rounded-l-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <button type="button" id="check_discount" class="bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 px-4 rounded-r-md">
                                        Tukar
                                    </button>
                                </div>
                                <div id="discount_message" class="mt-1 text-sm"></div>
                            </div>
                            
                            <!-- Notes -->
                            <div class="mb-6">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional):</label>
                                <textarea id="notes" name="notes" rows="3" class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                            
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-md">
                                Proses Pesanan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkDiscountBtn = document.getElementById('check_discount');
        const discountCodeInput = document.getElementById('discount_code');
        const discountMessage = document.getElementById('discount_message');
        const discountRow = document.getElementById('discount_row');
        const discountValue = document.getElementById('discount_value');
        const taxValue = document.getElementById('tax_value');
        const totalValue = document.getElementById('total_value');
        
        checkDiscountBtn.addEventListener('click', function() {
            const discountCode = discountCodeInput.value.trim();
            
            if (!discountCode) {
                discountMessage.innerHTML = '<span class="text-red-600">Silakan masukkan kode diskon.</span>';
                return;
            }
            
            // Show loading state
            checkDiscountBtn.disabled = true;
            checkDiscountBtn.innerHTML = 'Memeriksa...';
            discountMessage.innerHTML = '<span class="text-blue-600">Memeriksa kode diskon...</span>';
            
            // Call the API
            fetch('{{ route("checkout.check-discount") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    discount_code: discountCode,
                    product_id: '{{ $product->id }}',
                    subtotal: {{ $subtotal }}
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.valid) {
                    // Update the UI with discount info
                    discountRow.style.display = 'flex';
                    discountValue.textContent = '-Rp ' + data.formatted_discount;
                    taxValue.textContent = 'Rp ' + data.formatted_tax;
                    totalValue.textContent = 'Rp ' + data.formatted_total;
                    discountMessage.innerHTML = '<span class="text-green-600">' + data.message + '</span>';
                } else {
                    // Show error
                    discountMessage.innerHTML = '<span class="text-red-600">' + data.message + '</span>';
                    // Reset the discount row if it was showing
                    discountRow.style.display = 'none';
                    taxValue.textContent = 'Rp {{ number_format($tax, 0, ',', '.') }}';
                    totalValue.textContent = 'Rp {{ number_format($total, 0, ',', '.') }}';
                }
            })
            .catch(error => {
                discountMessage.innerHTML = '<span class="text-red-600">Terjadi kesalahan saat memeriksa kode diskon.</span>';
                console.error('Error:', error);
            })
            .finally(() => {
                // Reset button state
                checkDiscountBtn.disabled = false;
                checkDiscountBtn.innerHTML = 'Tukar';
            });
        });
    });
</script>
@endsection
