<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-800 dark:text-blue-300 leading-tight">
            {{ __('Pembayaran') }}
        </h2>
    </x-slot>

    <!-- CSS untuk animasi dan styling -->
    <style>
        /* Progress Bar Animation */
        .progress-bar-animate {
            position: relative;
            overflow: hidden;
        }
        
        .progress-bar-animate::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: progress-shine 2s infinite linear;
        }
        
        @keyframes progress-shine {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        
        /* Pulse Animation for Icons */
        .icon-pulse {
            animation: icon-pulse-animation 2s infinite;
        }
        
        @keyframes icon-pulse-animation {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        /* Receipt Animation */
        .receipt-animation {
            animation: receipt-float 3s ease-in-out infinite;
        }
        
        @keyframes receipt-float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        /* Tab styling */
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }

        .tab-button {
            transition: all 0.3s ease;
        }

        .tab-button.active {
            background: linear-gradient(to right, #3182ce, #4f46e5);
            color: white;
            transform: scale(1.05);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .scale-in {
            animation: scaleIn 0.3s ease-in-out;
        }
        
        @keyframes scaleIn {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        /* Blob animations */
        .animate-blob {
            animation: blob-bounce 7s infinite ease;
        }
        
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        
        @keyframes blob-bounce {
            0% {
                transform: translate(0px, 0px) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }
        
        /* Payment method card */
        .payment-method-card {
            transition: all 0.3s ease;
        }
        
        .payment-method-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .payment-method-card.selected {
            border-color: #3182ce;
            background-color: #ebf5ff;
            color: #3182ce;
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .bank-option.selected {
            border-color: #4f46e5;
            color: #4f46e5;
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Alert Messages -->
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
            <div class="mb-10 fade-in">
                <div class="relative z-10">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-10 shadow-inner overflow-hidden">
                        @if($invoice->status === 'unpaid')
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-10 rounded-full shadow-lg flex items-center justify-center relative overflow-hidden progress-bar-animate" style="width: 25%">
                                <span class="text-white text-sm font-bold relative z-10">25%</span>
                            </div>
                        @elseif($invoice->status === 'pending_confirmation')
                            <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 h-10 rounded-full shadow-lg flex items-center justify-center relative overflow-hidden progress-bar-animate" style="width: 65%">
                                <span class="text-white text-sm font-bold relative z-10">65%</span>
                            </div>
                        @elseif($invoice->status === 'paid')
                            <div class="bg-gradient-to-r from-green-400 to-green-500 h-10 rounded-full shadow-lg flex items-center justify-center relative overflow-hidden progress-bar-animate" style="width: 100%">
                                <span class="text-white text-sm font-bold relative z-10">100%</span>
                            </div>
                        @else
                            <div class="bg-gradient-to-r from-red-400 to-red-500 h-10 rounded-full shadow-lg flex items-center justify-center" style="width: 100%">
                                <span class="text-white text-sm font-bold">Dibatalkan</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="flex justify-between mt-8 text-sm font-medium">
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 mb-3 rounded-full flex items-center justify-center shadow-lg {{ $invoice->status === 'unpaid' ? 'bg-blue-600 text-white icon-pulse' : 'bg-green-600 text-white' }}">
                            <i class="fas fa-file-invoice text-xl"></i>
                        </div>
                        <div class="{{ $invoice->status === 'unpaid' ? 'text-blue-600' : 'text-green-600' }} font-bold text-base">Invoice Dibuat</div>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 mb-3 rounded-full flex items-center justify-center shadow-lg {{ in_array($invoice->status, ['pending_confirmation', 'paid']) ? 'bg-yellow-500 text-white icon-pulse' : 'bg-gray-300 text-gray-600' }}">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <div class="{{ in_array($invoice->status, ['pending_confirmation', 'paid']) ? 'text-yellow-600 font-bold' : 'text-gray-500' }} text-base">Menunggu Konfirmasi</div>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-16 h-16 mb-3 rounded-full flex items-center justify-center shadow-lg {{ $invoice->status === 'paid' ? 'bg-green-600 text-white icon-pulse' : 'bg-gray-300 text-gray-600' }}">
                            <i class="fas fa-check text-xl"></i>
                        </div>
                        <div class="{{ $invoice->status === 'paid' ? 'text-green-600 font-bold' : 'text-gray-500' }} text-base">Pembayaran Selesai</div>
                    </div>
                </div>
            </div>
            
            <!-- Tabs Navigation -->
            <div class="mb-8">
                <ul class="flex overflow-x-auto py-3 snap-x space-x-4">
                    <li class="snap-start">
                        <button type="button" class="tab-button transition-all duration-300 inline-flex items-center px-8 py-4 rounded-xl font-medium min-w-[180px] justify-center bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 shadow-md hover:shadow-lg" onclick="showTab('invoice')">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 bg-blue-100 dark:bg-blue-900 shadow-inner">
                                <i class="fa-solid fa-file-invoice text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <span class="text-base">Detail Invoice</span>
                        </button>
                    </li>
                    <li class="snap-start">
                        <button type="button" class="tab-button transition-all duration-300 inline-flex items-center px-8 py-4 rounded-xl font-medium min-w-[180px] justify-center bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 shadow-md hover:shadow-lg" onclick="showTab('order')">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 bg-blue-100 dark:bg-blue-900 shadow-inner">
                                <i class="fa-solid fa-shopping-cart text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <span class="text-base">Detail Order</span>
                        </button>
                    </li>
                    @if($invoice->status === 'unpaid')
                    <li class="snap-start">
                        <button type="button" class="tab-button transition-all duration-300 inline-flex items-center px-8 py-4 rounded-xl font-medium min-w-[200px] justify-center bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 shadow-md hover:shadow-lg" onclick="showTab('payment')">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3 bg-blue-100 dark:bg-blue-900 shadow-inner">
                                <i class="fa-solid fa-credit-card text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <span class="text-base">Upload Pembayaran</span>
                        </button>
                    </li>
                    @endif
                </ul>
            </div>
            
            <!-- Tab Content -->
            <div class="py-6">
                <!-- Invoice Details Tab -->
                <div id="invoice-tab" class="tab-content">
                    @php
                        // Get the latest payment for this invoice
                        $payment = $invoice->payments()->latest()->first();
                    @endphp
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700 scale-in hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                        <!-- Background decoration -->
                        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-blue-100 to-transparent dark:from-blue-900 dark:to-transparent rounded-full opacity-30 -mr-32 -mt-32 z-0"></div>
                        
                        <div class="flex flex-col md:flex-row relative z-10">
                            <div class="w-full md:w-2/3 pr-0 md:pr-8">
                                <div class="mb-8">
                                    <div class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full px-4 py-1.5 text-sm font-bold uppercase tracking-wider mb-3 shadow-sm">Invoice</div>
                                    <h3 class="text-3xl font-extrabold mb-3 text-gray-900 dark:text-white">#{{ $invoice->invoice_number }}</h3>
                                    <span class="text-base text-gray-500 dark:text-gray-400 flex items-center">
                                        <i class="far fa-calendar-alt mr-2"></i>
                                        @if(is_string($invoice->created_at))
                                            {{ $invoice->created_at }}
                                        @else
                                            {{ $invoice->created_at->format('d M Y') }}
                                        @endif
                                    </span>
                                </div>
                                
                                <!-- Status Badge -->
                                <div class="mb-6">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">Status:</span>
                                    @if($invoice->status === 'unpaid')
                                        <span class="inline-flex items-center ml-2 bg-yellow-100 text-yellow-800 rounded-full px-3 py-1 text-sm font-medium">
                                            <i class="fas fa-clock mr-1"></i> Belum Dibayar
                                        </span>
                                    @elseif($invoice->status === 'paid')
                                        <span class="inline-flex items-center ml-2 bg-green-100 text-green-800 rounded-full px-3 py-1 text-sm font-medium">
                                            <i class="fas fa-check-circle mr-1"></i> Lunas
                                        </span>
                                    @elseif($invoice->status === 'pending_confirmation')
                                        <span class="inline-flex items-center ml-2 bg-blue-100 text-blue-800 rounded-full px-3 py-1 text-sm font-medium">
                                            <i class="fas fa-hourglass-half mr-1"></i> Menunggu Konfirmasi
                                        </span>
                                    @elseif($invoice->status === 'cancelled')
                                        <span class="inline-flex items-center ml-2 bg-red-100 text-red-800 rounded-full px-3 py-1 text-sm font-medium">
                                            <i class="fas fa-times-circle mr-1"></i> Dibatalkan
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Payment Information Section (if available) -->
                                @if($payment)
                                <div class="mb-8 bg-gradient-to-r from-indigo-50 to-blue-50 dark:from-gray-700 dark:to-gray-800 rounded-xl p-5 border border-blue-100 dark:border-gray-600 shadow-inner">
                                    <h4 class="text-lg font-bold mb-3 flex items-center text-gray-800 dark:text-gray-200">
                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mr-2">
                                            <i class="fas fa-money-check-alt text-blue-600 dark:text-blue-400"></i>
                                        </div>
                                        Informasi Pembayaran
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Metode Pembayaran</div>
                                            <div class="font-medium">
                                                @if($payment->payment_method === App\Models\Payment::METHOD_BANK_TRANSFER)
                                                    Transfer Bank ({{ strtoupper($payment->bank ?? 'N/A') }})
                                                @elseif($payment->payment_method === App\Models\Payment::METHOD_CREDIT_CARD)
                                                    Kartu Kredit
                                                @elseif($payment->payment_method === App\Models\Payment::METHOD_E_WALLET)
                                                    E-Wallet
                                                @else
                                                    {{ $payment->payment_method }}
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Tanggal Pembayaran</div>
                                            <div class="font-medium">
                                                @if($payment->payment_date)
                                                    @if(is_string($payment->payment_date))
                                                        {{ $payment->payment_date }}
                                                    @else
                                                        {{ $payment->payment_date->format('d M Y, H:i') }}
                                                    @endif
                                                @else
                                                    N/A
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">No. Referensi</div>
                                            <div class="font-medium">{{ $payment->reference_number ?? 'N/A' }}</div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Status Verifikasi</div>
                                            <div class="font-medium">
                                                @if($payment->status === App\Models\Payment::STATUS_PENDING)
                                                    <span class="text-yellow-600 dark:text-yellow-400">Menunggu Verifikasi</span>
                                                @elseif($payment->status === App\Models\Payment::STATUS_VERIFIED)
                                                    <span class="text-green-600 dark:text-green-400">Terverifikasi</span>
                                                @elseif($payment->status === App\Models\Payment::STATUS_REJECTED)
                                                    <span class="text-red-600 dark:text-red-400">Ditolak</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="mb-8">
                                    <h4 class="text-lg font-bold mb-2 text-gray-800 dark:text-gray-200">Informasi Pemesan</h4>
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">Nama</div>
                                                <div class="font-medium">{{ $invoice->order->user->name }}</div>
                                            </div>
                                            <div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">Email</div>
                                                <div class="font-medium">{{ $invoice->order->user->email }}</div>
                                            </div>
                                            @if($invoice->order->phone)
                                            <div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">No. Telepon</div>
                                                <div class="font-medium">{{ $invoice->order->phone }}</div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Price Card -->
                            <div class="w-full md:w-1/3 mt-6 md:mt-0">
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 rounded-xl p-6 border border-blue-100 dark:border-gray-700 shadow-lg">
                                    <h4 class="font-bold text-xl mb-4 text-gray-800 dark:text-white">Total Pembayaran</h4>
                                    <div class="text-3xl font-extrabold text-blue-600 dark:text-blue-400">
                                        Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Termasuk pajak & biaya lainnya</div>
                                    
                                    <hr class="my-4 border-blue-200 dark:border-gray-700">
                                    
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-600 dark:text-gray-300">Subtotal:</span>
                                        <span class="font-medium">Rp {{ number_format($invoice->order->items->sum('subtotal'), 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-600 dark:text-gray-300">Pajak (10%):</span>
                                        <span class="font-medium">Rp {{ number_format($invoice->order->items->sum('subtotal') * 0.1, 0, ',', '.') }}</span>
                                    </div>
                                    
                                    <hr class="my-4 border-blue-200 dark:border-gray-700">
                                    
                                    @if($invoice->status === 'unpaid')
                                    <button type="button" class="w-full py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-bold shadow-md hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 flex items-center justify-center" onclick="showTab('payment')">
                                        <i class="fas fa-credit-card mr-2"></i>
                                        Bayar Sekarang
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Order Details Tab -->
                <div id="order-tab" class="tab-content">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700 scale-in hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                        <!-- Background decoration -->
                        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-indigo-100 to-transparent dark:from-indigo-900 dark:to-transparent rounded-full opacity-20 -mr-32 -mt-32 z-0"></div>
                        
                        <div class="relative z-10">
                            <div class="flex items-center mb-6">
                                <div class="mr-4 w-12 h-12 bg-indigo-100 dark:bg-indigo-800 rounded-full flex items-center justify-center">
                                    <i class="fas fa-shopping-cart text-indigo-600 dark:text-indigo-400 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Order #{{ $invoice->order->order_number }}</h3>
                                    <p class="text-gray-500 dark:text-gray-400">
                                        @if(is_string($invoice->order->created_at))
                                            {{ $invoice->order->created_at }}
                                        @else
                                            {{ $invoice->order->created_at->format('d M Y, H:i') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Order Items -->
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                                    <thead>
                                        <tr class="bg-gray-50 dark:bg-gray-700 text-left">
                                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Produk</th>
                                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Variasi</th>
                                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Garansi</th>
                                            <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($invoice->order->items as $item)
                                        <tr>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-16 w-16">
                                                        @if($item->product && $item->product->image)
                                                            <img class="h-16 w-16 object-cover rounded-md shadow-md" 
                                                                 src="{{ asset('storage/'.$item->product->image) }}" 
                                                                 alt="{{ $item->product->name }}"
                                                                 onerror="this.onerror=null;this.src='{{ asset('images/default-product.svg') }}';">
                                                        @else
                                                            <div class="h-16 w-16 rounded-md bg-gray-200 dark:bg-gray-700 flex items-center justify-center shadow-inner">
                                                                <i class="fas fa-box text-gray-400 dark:text-gray-500 text-2xl"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $item->product ? $item->product->name : $item->product_name ?? 'Produk tidak tersedia' }}
                                                        </div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                @if($item->variant)
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                                        {{ $item->variant->name }}
                                                    </span>
                                                @elseif($item->variant_name)
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                                        {{ $item->variant_name }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-500 dark:text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                @if($item->warranty)
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                                        {{ $item->warranty->duration ?? $item->warranty_months }} Bulan
                                                    </span>
                                                @elseif($item->warranty_months > 0)
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                                        {{ $item->warranty_months }} Bulan
                                                    </span>
                                                @else
                                                    <span class="text-gray-500 dark:text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-5 text-right whitespace-nowrap font-bold text-gray-900 dark:text-gray-100 text-lg">
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                                            <td colspan="3" class="px-6 py-4 text-right font-bold text-base">Total:</td>
                                            <td class="px-6 py-4 text-right font-extrabold text-white text-lg">
                                                Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Upload Tab -->
                @if($invoice->status === 'unpaid')
                <div id="payment-tab" class="tab-content">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700 scale-in hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                        <!-- Background decoration -->
                        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-blue-100 to-transparent dark:from-blue-900 dark:to-transparent rounded-full opacity-30 -mr-32 -mt-32 z-0"></div>
                        <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-tl from-indigo-100 to-transparent dark:from-indigo-900 dark:to-transparent rounded-full opacity-30 -ml-32 -mb-32 z-0"></div>
                        
                        <div class="relative z-10">
                            <h3 class="text-xl font-bold mb-6 flex items-center">
                                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center mr-3 shadow-md">
                                    <i class="fa-solid fa-credit-card text-white"></i>
                                </div>
                                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 text-2xl">Upload Pembayaran</span>
                            </h3>
                        
                            <form action="{{ route('payment.store', $invoice->id) }}" method="post" enctype="multipart/form-data" id="payment-form">
                                @csrf
                                
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Metode Pembayaran</label>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                        <div class="relative">
                                            <input type="radio" id="method_bank" name="payment_method" value="{{ App\Models\Payment::METHOD_BANK_TRANSFER }}" class="sr-only payment-method-input" checked>
                                            <label for="method_bank" class="payment-method-card flex flex-col items-center p-6 h-full border-2 rounded-xl cursor-pointer bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 selected">
                                                <div class="w-16 h-16 mb-4 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-university text-2xl text-blue-600 dark:text-blue-400"></i>
                                                </div>
                                                <div class="text-center">
                                                    <div class="font-bold text-lg mb-1">Transfer Bank</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">BCA, Mandiri, BNI, BRI</div>
                                                </div>
                                                <div class="absolute top-3 right-3 w-5 h-5 bg-blue-600 rounded-full border-2 border-blue-600 flex items-center justify-center check-icon">
                                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            </label>
                                        </div>
                                        
                                        <div class="relative">
                                            <input type="radio" id="method_ewallet" name="payment_method" value="e_wallet" class="sr-only payment-method-input">
                                            <label for="method_ewallet" class="payment-method-card flex flex-col items-center p-6 h-full border-2 rounded-xl cursor-pointer bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400">
                                                <div class="w-16 h-16 mb-4 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-wallet text-2xl text-purple-600 dark:text-purple-400"></i>
                                                </div>
                                                <div class="text-center">
                                                    <div class="font-bold text-lg mb-1">E-Wallet</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">OVO, GoPay, Dana, LinkAja</div>
                                                </div>
                                                <div class="absolute top-3 right-3 w-5 h-5 bg-white rounded-full border-2 border-gray-300 flex items-center justify-center check-icon">
                                                    <svg class="w-3 h-3 text-white hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            </label>
                                        </div>
                                        
                                        <div class="relative">
                                            <input type="radio" id="method_qris" name="payment_method" value="qris" class="sr-only payment-method-input">
                                            <label for="method_qris" class="payment-method-card flex flex-col items-center p-6 h-full border-2 rounded-xl cursor-pointer bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400">
                                                <div class="w-16 h-16 mb-4 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-qrcode text-2xl text-green-600 dark:text-green-400"></i>
                                                </div>
                                                <div class="text-center">
                                                    <div class="font-bold text-lg mb-1">QRIS</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">Scan dengan aplikasi apa saja</div>
                                                </div>
                                                <div class="absolute top-3 right-3 w-5 h-5 bg-white rounded-full border-2 border-gray-300 flex items-center justify-center check-icon">
                                                    <svg class="w-3 h-3 text-white hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    @error('payment_method')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div id="bank-selection" class="mb-6 bg-white dark:bg-gray-800 p-5 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Pilih Bank</label>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        <div>
                                            <input type="radio" id="bank_bca" name="bank" value="{{ App\Models\Payment::BANK_BCA }}" class="sr-only bank-input" checked>
                                            <label for="bank_bca" class="bank-option flex flex-col items-center justify-between p-4 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:text-gray-400 dark:bg-gray-800 dark:border-gray-700 transition-all duration-300 selected">
                                                <i class="fas fa-university text-2xl mb-2"></i>
                                                <div class="w-full text-center font-semibold">BCA</div>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="radio" id="bank_mandiri" name="bank" value="{{ App\Models\Payment::BANK_MANDIRI }}" class="sr-only bank-input">
                                            <label for="bank_mandiri" class="bank-option flex flex-col items-center justify-between p-4 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:text-gray-400 dark:bg-gray-800 dark:border-gray-700 transition-all duration-300">
                                                <i class="fas fa-university text-2xl mb-2"></i>
                                                <div class="w-full text-center font-semibold">Mandiri</div>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="radio" id="bank_bri" name="bank" value="{{ App\Models\Payment::BANK_BRI }}" class="sr-only bank-input">
                                            <label for="bank_bri" class="bank-option flex flex-col items-center justify-between p-4 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:text-gray-400 dark:bg-gray-800 dark:border-gray-700 transition-all duration-300">
                                                <i class="fas fa-university text-2xl mb-2"></i>
                                                <div class="w-full text-center font-semibold">BRI</div>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="radio" id="bank_bni" name="bank" value="{{ App\Models\Payment::BANK_BNI }}" class="sr-only bank-input">
                                            <label for="bank_bni" class="bank-option flex flex-col items-center justify-between p-4 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:text-gray-400 dark:bg-gray-800 dark:border-gray-700 transition-all duration-300">
                                                <i class="fas fa-university text-2xl mb-2"></i>
                                                <div class="w-full text-center font-semibold">BNI</div>
                                            </label>
                                        </div>
                                    </div>
                                    @error('bank')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div id="bank-info" class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg border border-blue-200 dark:border-blue-800 mb-6 shadow-md">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-sm font-medium text-blue-800 dark:text-blue-300">Informasi Rekening</h4>
                                            <div class="bank-info-container mt-2 text-sm text-blue-700 dark:text-blue-400">
                                                <div class="bank-info" id="info-bca">
                                                    <p>Bank BCA</p>
                                                    <p class="font-medium">No. Rekening: 1234567890</p>
                                                    <p>Atas Nama: DapurKode Indonesia</p>
                                                </div>
                                                <div class="bank-info hidden" id="info-mandiri">
                                                    <p>Bank Mandiri</p>
                                                    <p class="font-medium">No. Rekening: 0987654321</p>
                                                    <p>Atas Nama: DapurKode Indonesia</p>
                                                </div>
                                                <div class="bank-info hidden" id="info-bri">
                                                    <p>Bank BRI</p>
                                                    <p class="font-medium">No. Rekening: 2468101214</p>
                                                    <p>Atas Nama: DapurKode Indonesia</p>
                                                </div>
                                                <div class="bank-info hidden" id="info-bni">
                                                    <p>Bank BNI</p>
                                                    <p class="font-medium">No. Rekening: 1357911131</p>
                                                    <p>Atas Nama: DapurKode Indonesia</p>
                                                </div>
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
                                    <label for="proof_image" class="relative flex flex-col items-center justify-center w-full h-40 border-3 border-blue-200 dark:border-blue-800 border-dashed rounded-xl cursor-pointer bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-900 dark:hover:bg-opacity-80 hover:bg-opacity-90 dark:border-opacity-50 dark:hover:border-opacity-70 hover:border-blue-300 dark:hover:border-blue-700 transition-all duration-300 group overflow-hidden">
                                        <!-- Background animation elements -->
                                        <div class="absolute inset-0 overflow-hidden">
                                            <div class="absolute top-0 left-0 w-40 h-40 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
                                            <div class="absolute top-0 right-0 w-40 h-40 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>
                                        </div>
                                        
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6 relative z-10">
                                            <div class="w-16 h-16 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mb-4 transform group-hover:scale-110 transition-all duration-300">
                                                <i class="fa-solid fa-cloud-arrow-up text-blue-500 dark:text-blue-400 text-2xl"></i>
                                            </div>
                                            <p class="mb-2 text-center text-sm font-medium text-blue-700 dark:text-blue-400">
                                                <span class="font-bold">Klik untuk upload</span> atau drag and drop
                                            </p>
                                            <p class="text-xs text-blue-600 dark:text-blue-500">Format: JPG, PNG, atau GIF (Maks. 2MB)</p>
                                        </div>
                                        <input id="proof_image" name="proof_image" type="file" accept="image/*" class="hidden" required onchange="showPreview(this)"/>
                                    </label>
                                </div>
                                
                                <div id="file-preview" class="hidden mt-2">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">File terpilih: </span>
                                    <span id="file-name"></span>
                                </div>
                                
                                <div id="image-preview-container" class="hidden mt-3">
                                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preview:</h4>
                                    <img id="image-preview" class="max-h-48 max-w-full rounded-md border border-gray-200 dark:border-gray-700" />
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
                                <button type="submit" class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-semibold text-lg rounded-xl hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-indigo-300 focus:ring-opacity-50 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex items-center">
                                    <div class="mr-3 w-8 h-8 rounded-full bg-white bg-opacity-20 flex items-center justify-center">
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </div>
                                    <span>Upload Bukti Pembayaran</span>
                                </button>
                            </div>
                            
                            <div class="mt-6 text-center">
                                <a href="/" class="inline-flex items-center px-6 py-2 text-blue-600 hover:text-blue-800 font-medium transition-all duration-300">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Kembali ke Beranda
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            
            @if($invoice->status === 'paid')
            <div id="payment-tab" class="tab-content">
                <!-- Payment Success Content -->
            </div>
            @endif
        </div>
    </div>
</div>

<!-- JavaScript for tabs and form interactions -->
<script>
    // Function to show a specific tab
    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
            tab.style.display = 'none';
        });
        
        // Show the selected tab
        const selectedTab = document.getElementById(tabName + '-tab');
        if (selectedTab) {
            selectedTab.classList.add('active');
            selectedTab.style.display = 'block';
        }
        
        // Update all tab buttons
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active');
        });
        
        // Highlight the clicked tab button
        const buttons = document.querySelectorAll('.tab-button');
        for (let i = 0; i < buttons.length; i++) {
            if (buttons[i].getAttribute('onclick').includes(tabName)) {
                buttons[i].classList.add('active');
            }
        }
    }
    
    // Handle payment method selection
    document.addEventListener('DOMContentLoaded', function() {
        // Set default tab to 'payment'
        showTab('payment');
        
        // Payment method selection
        const methodInputs = document.querySelectorAll('.payment-method-input');
        methodInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Remove selected class from all method cards
                document.querySelectorAll('.payment-method-card').forEach(card => {
                    card.classList.remove('selected');
                    card.querySelector('.check-icon svg').classList.add('hidden');
                    card.querySelector('.check-icon').classList.remove('bg-blue-600', 'border-blue-600');
                    card.querySelector('.check-icon').classList.add('bg-white', 'border-gray-300');
                });
                
                // Add selected class to the selected method card
                const label = document.querySelector(`label[for="${this.id}"]`);
                label.classList.add('selected');
                label.querySelector('.check-icon svg').classList.remove('hidden');
                label.querySelector('.check-icon').classList.remove('bg-white', 'border-gray-300');
                label.querySelector('.check-icon').classList.add('bg-blue-600', 'border-blue-600');
                
                // Show/hide bank selection based on selected method
                const bankSelection = document.getElementById('bank-selection');
                const bankInfo = document.getElementById('bank-info');
                
                if (this.value === '{{ App\Models\Payment::METHOD_BANK_TRANSFER }}') {
                    bankSelection.style.display = 'block';
                    bankInfo.style.display = 'block';
                } else {
                    bankSelection.style.display = 'none';
                    bankInfo.style.display = 'none';
                }
            });
        });
        
        // Bank selection
        const bankInputs = document.querySelectorAll('.bank-input');
        bankInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Remove selected class from all bank options
                document.querySelectorAll('.bank-option').forEach(option => {
                    option.classList.remove('selected');
                });
                
                // Add selected class to the selected bank option
                const label = document.querySelector(`label[for="${this.id}"]`);
                label.classList.add('selected');
                
                // Show the corresponding bank info
                document.querySelectorAll('.bank-info').forEach(info => {
                    info.classList.add('hidden');
                });
                document.getElementById('info-' + this.value).classList.remove('hidden');
            });
        });
    });
    
    // Function to show image preview
    function showPreview(input) {
        if (input.files && input.files[0]) {
            const filePreview = document.getElementById('file-preview');
            const fileName = document.getElementById('file-name');
            const imagePreview = document.getElementById('image-preview');
            const imageContainer = document.getElementById('image-preview-container');
            
            // Update file name
            fileName.textContent = input.files[0].name;
            filePreview.classList.remove('hidden');
            
            // Create preview image
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imageContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</x-app-layout>
