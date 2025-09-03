<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pembayaran') }}
        </h2>
    </x-slot>

    <!-- Include animations component -->
    @include('components.animations')

    @php
        // Inisialisasi payment di awal untuk digunakan di seluruh halaman
        $payment = $invoice->payments()->latest()->first();
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alerts -->
            @if (session('success'))
            <div class="mb-6 fade-in">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-md flex items-center justify-between" role="alert">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button type="button" class="text-green-500 hover:text-green-600 focus:outline-none" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            @endif
            
            @if (session('error'))
            <div class="mb-6 fade-in">
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-md flex items-center justify-between" role="alert">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                    <button type="button" class="text-red-500 hover:text-red-600 focus:outline-none" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            @endif
            
            <!-- Payment Process Progress Bar -->
            <div class="mb-8 fade-in">
                <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5">
                    @if($invoice->status === 'unpaid')
                        <div class="bg-blue-500 h-2.5 rounded-full" style="width: 25%"></div>
                    @elseif($invoice->status === 'pending_confirmation')
                        <div class="bg-yellow-500 h-2.5 rounded-full" style="width: 65%"></div>
                    @elseif($invoice->status === 'paid')
                        <div class="bg-green-500 h-2.5 rounded-full" style="width: 100%"></div>
                    @else
                        <div class="bg-red-500 h-2.5 rounded-full" style="width: 100%"></div>
                    @endif
                </div>
                <div class="flex justify-between mt-2 text-xs text-gray-600 dark:text-gray-400">
                    <div class="{{ $invoice->status === 'unpaid' ? 'text-blue-600 font-medium' : 'text-green-600' }}">Invoice Dibuat</div>
                    <div class="{{ in_array($invoice->status, ['pending_confirmation', 'paid']) ? 'text-green-600 font-medium' : '' }}">Menunggu Konfirmasi</div>
                    <div class="{{ $invoice->status === 'paid' ? 'text-green-600 font-medium' : '' }}">Pembayaran Selesai</div>
                </div>
            </div>
            
            <div x-data="{ activeTab: 'invoice' }" class="mb-8">
                <!-- Tabs -->
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                        <li class="mr-2">
                            <button @click="activeTab = 'invoice'" :class="activeTab === 'invoice' ? 'border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300'" class="inline-block p-4 rounded-t-lg">
                                <i class="fa-solid fa-file-invoice mr-2"></i>
                                Detail Invoice
                            </button>
                        </li>
                        <li class="mr-2">
                            <button @click="activeTab = 'order'" :class="activeTab === 'order' ? 'border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300'" class="inline-block p-4 rounded-t-lg">
                                <i class="fa-solid fa-shopping-cart mr-2"></i>
                                Detail Order
                            </button>
                        </li>
                        @if($invoice->status === 'unpaid')
                        <li class="mr-2">
                            <button @click="activeTab = 'payment'" :class="activeTab === 'payment' ? 'border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300'" class="inline-block p-4 rounded-t-lg">
                                <i class="fa-solid fa-credit-card mr-2"></i>
                                Upload Pembayaran
                            </button>
                        </li>
                        @endif
                    </ul>
                </div>
                
                <!-- Tab Contents -->
                <div class="py-6">
                    <!-- Invoice Details Tab -->
                    <div x-show="activeTab === 'invoice'" x-transition:enter="fade-in" x-transition:leave="fade-out" class="tab-content" :class="activeTab === 'invoice' ? 'active' : 'hidden'">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700 scale-in">
                            <div class="flex flex-col md:flex-row">
                                <div class="w-full md:w-2/3 pr-0 md:pr-6">
                                    <div class="flex justify-between items-center mb-6">
                                        <h3 class="text-xl font-bold">Invoice #{{ $invoice->invoice_number }}</h3>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $invoice->created_at->format('d M Y') }}</span>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm font-semibold mb-1 text-gray-600 dark:text-gray-400">Tanggal Pembuatan</p>
                                            <p>{{ $invoice->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold mb-1 text-gray-600 dark:text-gray-400">Jatuh Tempo</p>
                                            <p>{{ $invoice->due_date->format('d M Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold mb-1 text-gray-600 dark:text-gray-400">Status</p>
                                            <p>
                                                @if ($invoice->status === 'unpaid')
                                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium py-0.5 px-2 rounded-full">Belum Dibayar</span>
                                                @elseif ($invoice->status === 'pending_confirmation')
                                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium py-0.5 px-2 rounded-full">Menunggu Konfirmasi</span>
                                                @elseif ($invoice->status === 'paid')
                                                    <span class="bg-green-100 text-green-800 text-xs font-medium py-0.5 px-2 rounded-full">Sudah Dibayar</span>
                                                @elseif ($invoice->status === 'cancelled')
                                                    <span class="bg-red-100 text-red-800 text-xs font-medium py-0.5 px-2 rounded-full">Dibatalkan</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold mb-1 text-gray-600 dark:text-gray-400">Metode Pembayaran</p>
                                            <p>
                                                @if($payment && $payment->method)
                                                    @if($payment->method === \App\Models\Payment::METHOD_BANK_TRANSFER)
                                                        Transfer Bank 
                                                        @if($payment->bank)
                                                            ({{ $payment->bank }})
                                                        @endif
                                                    @else
                                                        {{ $payment->method }}
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="w-full md:w-1/3 mt-6 md:mt-0">
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md border border-gray-200 dark:border-gray-600 receipt-animation">
                                        <div class="text-center mb-2">
                                            <span class="text-sm uppercase font-semibold text-gray-500 dark:text-gray-400">Total Pembayaran</span>
                                        </div>
                                        <div class="text-center">
                                            <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                                                Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="border-t border-dashed border-gray-300 dark:border-gray-600 my-3"></div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Subtotal</span>
                                            <span class="text-sm">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    
                                    @if($invoice->status === 'unpaid')
                                    <div class="mt-4">
                                        <button @click="activeTab = 'payment'" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md font-medium transition-colors duration-300 flex items-center justify-center">
                                            <i class="fas fa-credit-card mr-2"></i>
                                            Bayar Sekarang
                                        </button>
                                    </div>
                                    @elseif($invoice->status === 'paid')
                                    <div class="mt-4 bg-green-100 text-green-800 p-3 rounded-md text-sm">
                                        <div class="flex items-center">
                                            <i class="fas fa-check-circle mr-2"></i>
                                            <span>Pembayaran berhasil dikonfirmasi pada 
                                                {{ $payment && $payment->updated_at ? $payment->updated_at->format('d M Y H:i') : $invoice->updated_at->format('d M Y H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                    @elseif($invoice->status === 'pending_confirmation')
                                    <div class="mt-4 bg-yellow-100 text-yellow-800 p-3 rounded-md text-sm">
                                        <div class="flex items-center">
                                            <i class="fas fa-clock mr-2"></i>
                                            <span>Menunggu konfirmasi pembayaran</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Details Tab -->
                    <div x-show="activeTab === 'order'" x-transition:enter="fade-in" x-transition:leave="fade-out" class="tab-content" :class="activeTab === 'order' ? 'active' : 'hidden'">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700 scale-in">
                            <h3 class="text-xl font-bold mb-4">Order #{{ $invoice->order->id }}</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead>
                                        <tr class="bg-gray-50 dark:bg-gray-700">
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Produk</th>
                                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Harga</th>
                                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Garansi</th>
                                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($invoice->order->items as $item)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors slide-in">
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if($item->product->image)
                                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-10 h-10 object-cover rounded-md mr-3">
                                                    @else
                                                        <div class="w-10 h-10 bg-gray-200 rounded-md flex items-center justify-center mr-3">
                                                            <i class="fas fa-image text-gray-400"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ $item->product->name }}</div>
                                                        @if($item->variant)
                                                        <span class="text-sm text-gray-500 dark:text-gray-400 block">
                                                            Variant: {{ $item->variant->name }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 text-right whitespace-nowrap text-gray-700 dark:text-gray-300">
                                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-4 text-right whitespace-nowrap text-gray-700 dark:text-gray-300">
                                                @if($item->warranty)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                                        {{ $item->warranty->name }}
                                                    </span>
                                                    <div class="text-sm mt-1">Rp {{ number_format($item->warranty_price, 0, ',', '.') }}</div>
                                                @else
                                                    <span class="text-gray-500 dark:text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 text-right whitespace-nowrap font-semibold text-gray-900 dark:text-gray-100">
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gray-50 dark:bg-gray-700">
                                            <td colspan="3" class="px-4 py-3 text-right font-semibold">Total:</td>
                                            <td class="px-4 py-3 text-right font-bold text-indigo-600 dark:text-indigo-400">
                                                Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Upload Tab -->
                    @if($invoice->status === 'unpaid')
                    <div x-show="activeTab === 'payment'" x-transition:enter="fade-in" x-transition:leave="fade-out" class="tab-content" :class="activeTab === 'payment' ? 'active' : 'hidden'">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700 scale-in">
                            <h3 class="text-xl font-bold mb-6 flex items-center">
                                <i class="fa-solid fa-receipt mr-2 text-indigo-500"></i>
                                Upload Bukti Pembayaran
                            </h3>
                            
                            <form action="{{ route('payment.store', $invoice->id) }}" method="post" enctype="multipart/form-data" x-data="{ selectedMethod: '', selectedBank: '', fileName: '', showPreview: false, previewSrc: '' }">
                                @csrf
                                
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Metode Pembayaran</label>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <input type="radio" id="method_bank" name="payment_method" value="{{ App\Models\Payment::METHOD_BANK_TRANSFER }}" class="hidden peer" required x-model="selectedMethod">
                                            <label for="method_bank" class="payment-method-card flex items-center p-4 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-indigo-400 peer-checked:border-indigo-600 peer-checked:text-indigo-600 hover:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                                <i class="fas fa-university mr-3 text-xl"></i>
                                                <div class="flex flex-col">
                                                    <div class="font-semibold">Transfer Bank</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">BCA, Mandiri, BNI, BRI</div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    @error('payment_method')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div x-show="selectedMethod === '{{ App\Models\Payment::METHOD_BANK_TRANSFER }}'" x-transition:enter="fade-in" x-transition:leave="fade-out" class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Pilih Bank</label>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        <div>
                                            <input type="radio" id="bank_bca" name="bank" value="{{ App\Models\Payment::BANK_BCA }}" class="hidden peer" required x-model="selectedBank">
                                            <label for="bank_bca" class="flex flex-col items-center justify-between p-4 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-indigo-400 peer-checked:border-indigo-600 peer-checked:text-indigo-600 hover:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 payment-method-card">
                                                <i class="fas fa-university text-2xl mb-2"></i>
                                                <div class="w-full text-center font-semibold">BCA</div>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="radio" id="bank_mandiri" name="bank" value="{{ App\Models\Payment::BANK_MANDIRI }}" class="hidden peer" x-model="selectedBank">
                                            <label for="bank_mandiri" class="flex flex-col items-center justify-between p-4 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-indigo-400 peer-checked:border-indigo-600 peer-checked:text-indigo-600 hover:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 payment-method-card">
                                                <i class="fas fa-university text-2xl mb-2"></i>
                                                <div class="w-full text-center font-semibold">Mandiri</div>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="radio" id="bank_bri" name="bank" value="{{ App\Models\Payment::BANK_BRI }}" class="hidden peer" x-model="selectedBank">
                                            <label for="bank_bri" class="flex flex-col items-center justify-between p-4 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-indigo-400 peer-checked:border-indigo-600 peer-checked:text-indigo-600 hover:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 payment-method-card">
                                                <i class="fas fa-university text-2xl mb-2"></i>
                                                <div class="w-full text-center font-semibold">BRI</div>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="radio" id="bank_bni" name="bank" value="{{ App\Models\Payment::BANK_BNI }}" class="hidden peer" x-model="selectedBank">
                                            <label for="bank_bni" class="flex flex-col items-center justify-between p-4 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-indigo-400 peer-checked:border-indigo-600 peer-checked:text-indigo-600 hover:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 payment-method-card">
                                                <i class="fas fa-university text-2xl mb-2"></i>
                                                <div class="w-full text-center font-semibold">BNI</div>
                                            </label>
                                        </div>
                                    </div>
                                    @error('bank')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div x-show="selectedBank !== ''" x-transition:enter="slide-up" class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg border border-blue-200 dark:border-blue-800 mb-6">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-blue-800 dark:text-blue-300">Informasi Rekening</h4>
                                            <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                                                <template x-if="selectedBank === '{{ App\Models\Payment::BANK_BCA }}'">
                                                    <div>
                                                        <p>Bank BCA</p>
                                                        <p class="font-medium">No. Rekening: 1234567890</p>
                                                        <p>Atas Nama: DapurKode Indonesia</p>
                                                    </div>
                                                </template>
                                                <template x-if="selectedBank === '{{ App\Models\Payment::BANK_MANDIRI }}'">
                                                    <div>
                                                        <p>Bank Mandiri</p>
                                                        <p class="font-medium">No. Rekening: 0987654321</p>
                                                        <p>Atas Nama: DapurKode Indonesia</p>
                                                    </div>
                                                </template>
                                                <template x-if="selectedBank === '{{ App\Models\Payment::BANK_BRI }}'">
                                                    <div>
                                                        <p>Bank BRI</p>
                                                        <p class="font-medium">No. Rekening: 2468101214</p>
                                                        <p>Atas Nama: DapurKode Indonesia</p>
                                                    </div>
                                                </template>
                                                <template x-if="selectedBank === '{{ App\Models\Payment::BANK_BNI }}'">
                                                    <div>
                                                        <p>Bank BNI</p>
                                                        <p class="font-medium">No. Rekening: 1357911131</p>
                                                        <p>Atas Nama: DapurKode Indonesia</p>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-6">
                                    <label for="reference_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Referensi / Nomor Transaksi</label>
                                    <input type="text" id="reference_number" name="reference_number" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Nomor transaksi dari bank / e-wallet">
                                    @error('reference_number')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="mb-6">
                                    <label for="proof_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bukti Pembayaran</label>
                                    <div class="flex items-center justify-center w-full">
                                        <label for="proof_image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <i class="fa-solid fa-cloud-arrow-up mb-3 text-gray-400 text-xl"></i>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Format: JPG, PNG, atau GIF (Maks. 2MB)</p>
                                            </div>
                                            <input id="proof_image" name="proof_image" type="file" accept="image/*" class="hidden" required 
                                                @change="
                                                    fileName = $event.target.files[0].name;
                                                    const file = $event.target.files[0];
                                                    if (file) {
                                                        const reader = new FileReader();
                                                        reader.onload = (e) => {
                                                            previewSrc = e.target.result;
                                                            showPreview = true;
                                                        };
                                                        reader.readAsDataURL(file);
                                                    }
                                                "
                                            />
                                        </label>
                                    </div>
                                    <div x-show="fileName" class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                        <span class="font-medium">File terpilih: </span><span x-text="fileName"></span>
                                    </div>
                                    <div x-show="showPreview" class="mt-3">
                                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preview:</h4>
                                        <img :src="previewSrc" class="max-h-48 max-w-full rounded-md border border-gray-200 dark:border-gray-700" />
                                    </div>
                                    @error('proof_image')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="mb-6">
                                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan (Opsional)</label>
                                    <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Catatan tambahan untuk pembayaran ini..."></textarea>
                                    @error('notes')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="flex justify-end">
                                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 flex items-center">
                                        <i class="fa-solid fa-paper-plane mr-2"></i>
                                        Upload Bukti Pembayaran
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
                    
                    @if($invoice->status === 'paid')
                    <div x-show="activeTab === 'payment'" x-transition:enter="fade-in" x-transition:leave="fade-out" class="tab-content" :class="activeTab === 'payment' ? 'active' : 'hidden'">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700 scale-in">
                            <div class="text-center">
                                <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52" width="40" height="40">
                                        <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none" stroke="#4CAF50" stroke-width="3"/>
                                        <path class="checkmark-check" fill="none" stroke="#FFFFFF" stroke-width="3" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-green-600 dark:text-green-400 mb-2">Pembayaran Berhasil</h3>
                                <p class="text-gray-600 dark:text-gray-300">Terima kasih atas pembayaran Anda. Pesanan Anda sedang diproses.</p>
                                
                                <div class="mt-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600 mx-auto max-w-md receipt-animation">
                                    <div class="text-center mb-3">
                                        <h4 class="text-lg font-bold">Detail Pembayaran</h4>
                                    </div>
                                    <div class="border-b border-dashed border-gray-300 dark:border-gray-600 mb-3 pb-3">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600 dark:text-gray-400">ID Pembayaran:</span>
                                            <span>
                                                {{ $payment ? $payment->id : '-' }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between text-sm mt-1">
                                            <span class="text-gray-600 dark:text-gray-400">Tanggal Pembayaran:</span>
                                            <span>{{ $payment && $payment->created_at ? $payment->created_at->format('d M Y H:i') : $invoice->updated_at->format('d M Y H:i') }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm mt-1">
                                            <span class="text-gray-600 dark:text-gray-400">Metode Pembayaran:</span>
                                            <span>
                                                @if($payment && $payment->method === \App\Models\Payment::METHOD_BANK_TRANSFER)
                                                    Transfer Bank ({{ $payment->bank ?? 'Unknown' }})
                                                @elseif($payment && $payment->method)
                                                    {{ $payment->method }}
                                                @else
                                                    Unknown
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex justify-between font-bold">
                                        <span>Total:</span>
                                        <span class="text-indigo-600 dark:text-indigo-400">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
