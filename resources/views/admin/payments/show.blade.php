@extends('layouts.admin.app')

@section('title', 'Detail Pembayaran')

@section('header', 'Detail Pembayaran')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.payments.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-900">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Pembayaran
            </a>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Pembayaran</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Detail transaksi dan status pembayaran.
                </p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">ID Pembayaran</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $payment->id }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Invoice</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <a href="{{ route('admin.invoices.show', $payment->invoice) }}" class="text-blue-600 hover:underline">
                                {{ $payment->invoice->invoice_number }}
                            </a>
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Pelanggan</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div>{{ $payment->invoice->order->user->name ?? 'N/A' }}</div>
                            <div class="text-gray-500">{{ $payment->invoice->order->user->email ?? 'N/A' }}</div>
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Jumlah</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Rp {{ number_format($payment->amount, 0, ',', '.') }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Metode Pembayaran</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if($payment->payment_method == 'bank_transfer')
                                Transfer Bank ({{ strtoupper($payment->bank ?? 'N/A') }})
                            @elseif($payment->payment_method == 'credit_card')
                                Kartu Kredit
                            @elseif($payment->payment_method == 'e_wallet')
                                E-Wallet
                            @else
                                {{ $payment->payment_method }}
                            @endif
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Nomor Referensi</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $payment->reference_number ?? 'N/A' }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Tanggal Pembayaran</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $payment->payment_date ? $payment->payment_date->format('d F Y H:i') : 'N/A' }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                            @if($payment->status == 'pending')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Menunggu Verifikasi
                                </span>
                            @elseif($payment->status == 'verified')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Terverifikasi
                                </span>
                                <p class="text-sm text-gray-500 mt-1">
                                    Diverifikasi oleh: {{ $payment->verifier ? $payment->verifier->name : 'System' }} 
                                    pada {{ $payment->verified_at ? $payment->verified_at->format('d F Y H:i') : 'N/A' }}
                                </p>
                            @elseif($payment->status == 'rejected')
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Ditolak
                                </span>
                            @endif
                        </dd>
                    </div>
                    @if($payment->notes)
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Catatan</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $payment->notes }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Proof of Payment -->
        @if($payment->proof_image)
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Bukti Pembayaran</h3>
            </div>
            <div class="border-t border-gray-200 p-6">
                <div class="w-full max-w-lg mx-auto">
                    <a href="{{ asset('storage/' . $payment->proof_image) }}" target="_blank">
                        <img src="{{ asset('storage/' . $payment->proof_image) }}" alt="Bukti Pembayaran" class="w-full h-auto rounded-md shadow">
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Actions -->
        @if($payment->status == 'pending')
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Tindakan</h3>
            </div>
            <div class="border-t border-gray-200 p-6">
                <div class="flex space-x-4">
                    <form action="{{ route('admin.payments.verify', $payment) }}" method="POST">
                        @csrf
                        <!-- Pastikan kita menggunakan method POST -->
                        <input type="hidden" name="_method" value="POST">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-check mr-2"></i>
                            Verifikasi Pembayaran
                        </button>
                    </form>
                    
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" 
                        onclick="document.getElementById('reject-modal').classList.remove('hidden')">
                        <i class="fas fa-times mr-2"></i>
                        Tolak Pembayaran
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Reject Modal -->
        <div id="reject-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 z-50 hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all max-w-lg w-full">
                <form action="{{ route('admin.payments.reject', $payment) }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Tolak Pembayaran</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-4">
                                        Anda yakin ingin menolak pembayaran ini? Pelanggan akan diberitahu tentang penolakan ini.
                                    </p>
                                    <div>
                                        <label for="notes" class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                                        <textarea name="notes" id="notes" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Jelaskan mengapa pembayaran ini ditolak..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Tolak Pembayaran
                        </button>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" 
                            onclick="document.getElementById('reject-modal').classList.add('hidden')">
                            Batal
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
