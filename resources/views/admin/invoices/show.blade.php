@extends('layouts.admin.app')

@section('title', 'Detail Invoice')

@section('header', 'Detail Invoice')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6">
                    <a href="{{ route('admin.invoices.index') }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Invoice
                    </a>
                </div>
                
                <!-- Invoice Header -->
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Invoice #{{ $invoice->invoice_number }}</h2>
                        <p class="text-gray-600">
                            Status: 
                            @if($invoice->status == 'unpaid')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">Belum Dibayar</span>
                            @elseif($invoice->status == 'paid')
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">Sudah Dibayar</span>
                            @elseif($invoice->status == 'cancelled')
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">Dibatalkan</span>
                            @elseif($invoice->status == 'overdue')
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">Jatuh Tempo</span>
                            @elseif($invoice->status == 'pending_confirmation')
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">Menunggu Konfirmasi</span>
                            @endif
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-700">Tanggal Invoice: {{ $invoice->created_at->format('d M Y') }}</p>
                        <p class="text-gray-700">Jatuh Tempo: {{ $invoice->due_date->format('d M Y') }}</p>
                        @if($invoice->pdf_path)
                            <a href="{{ asset('storage/' . $invoice->pdf_path) }}" target="_blank" class="inline-flex items-center mt-2 px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                                <i class="fas fa-download mr-2"></i> Download PDF
                            </a>
                        @endif
                    </div>
                </div>
                
                <!-- Customer Info -->
                <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-md">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Informasi Pelanggan</h3>
                        <p class="mb-1"><span class="font-medium">Nama:</span> {{ $invoice->order->user->name }}</p>
                        <p class="mb-1"><span class="font-medium">Email:</span> {{ $invoice->order->user->email }}</p>
                        <p><span class="font-medium">No. Order:</span> 
                            <a href="{{ route('admin.orders.show', $invoice->order) }}" class="text-blue-600 hover:underline">
                                {{ $invoice->order->order_number }}
                            </a>
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-md">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Ringkasan Biaya</h3>
                        <div class="flex justify-between mb-1">
                            <span>Subtotal:</span>
                            <span>Rp {{ number_format($invoice->order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span>Diskon:</span>
                            <span>- Rp {{ number_format($invoice->order->discount_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between font-bold border-t border-gray-200 pt-2 mt-2">
                            <span>Total:</span>
                            <span>Rp {{ number_format($invoice->amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Order Items -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Item</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Varian</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($invoice->order->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($item->product && $item->product->image)
                                                <img class="h-10 w-10 rounded-md object-cover mr-3" src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-md bg-gray-200 mr-3"></div>
                                            @endif
                                            <div>
                                                <div class="font-medium text-gray-900">
                                                    {{ $item->product_name }}
                                                </div>
                                                @if($item->warranty_months)
                                                    <div class="text-xs text-gray-500">
                                                        Garansi {{ $item->warranty_months }} Bulan
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->variant_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Payments -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Pembayaran</h3>
                    
                    @if($invoice->payments->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($invoice->payments as $payment)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            #{{ $payment->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $payment->payment_date->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($payment->payment_method == 'bank_transfer')
                                                Transfer Bank ({{ $payment->bank }})
                                            @elseif($payment->payment_method == 'credit_card')
                                                Kartu Kredit
                                            @elseif($payment->payment_method == 'e_wallet')
                                                E-Wallet
                                            @else
                                                {{ $payment->payment_method }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($payment->status == 'pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Menunggu
                                                </span>
                                            @elseif($payment->status == 'verified')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Terverifikasi
                                                </span>
                                            @elseif($payment->status == 'rejected')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Ditolak
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.payments.show', $payment) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded-md text-center text-gray-500">
                            Belum ada pembayaran untuk invoice ini.
                        </div>
                    @endif
                </div>
                
                <!-- Notes -->
                @if($invoice->notes)
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Catatan</h3>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p class="text-gray-700">{{ $invoice->notes }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
