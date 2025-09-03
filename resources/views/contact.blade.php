@extends('layouts.guest.navigation')

@section('title', 'Kontak Kami')

@section('content')
<!-- Contact Header -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6">Hubungi Kami</h1>
        <p class="text-xl max-w-3xl mx-auto">Ada pertanyaan atau butuh bantuan? Tim kami siap membantu Anda</p>
    </div>
</div>

<!-- Breadcrumb -->
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
                    <span class="ml-2 text-gray-700 font-medium">Kontak Kami</span>
                </li>
            </ol>
        </nav>
    </div>
</div>

<!-- Contact Content -->
<div class="py-12 md:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
            <!-- Contact Info -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi Kontak</h2>
                
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-1">Lokasi Kantor</h3>
                            <p class="text-gray-600">Jl. Raya Gawok No 2,<br>Kabupaten Sukoharjo,<br>Jawa Tengah 57556</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-1">Telepon</h3>
                            <p class="text-gray-600">+62 21 1234 5678</p>
                            <p class="text-gray-600">+62 812 3456 7890 (WhatsApp)</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-1">Email</h3>
                            <p class="text-gray-600">info@dapurkode.com</p>
                            <p class="text-gray-600">support@dapurkode.com</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-1">Jam Kerja</h3>
                            <p class="text-gray-600">Senin - Jumat: 09.00 - 17.00</p>
                            <p class="text-gray-600">Sabtu: 09.00 - 13.00</p>
                            <p class="text-gray-600">Minggu: Tutup</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-blue-600">
                            <span class="sr-only">Facebook</span>
                            <i class="fab fa-facebook-f fa-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-pink-600">
                            <span class="sr-only">Instagram</span>
                            <i class="fab fa-instagram fa-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-400">
                            <span class="sr-only">Twitter</span>
                            <i class="fab fa-twitter fa-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-red-600">
                            <span class="sr-only">YouTube</span>
                            <i class="fab fa-youtube fa-lg"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-700">
                            <span class="sr-only">LinkedIn</span>
                            <i class="fab fa-linkedin-in fa-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="mt-12 lg:mt-0 lg:col-span-2">
                <div class="bg-gray-50 rounded-lg shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>
                    
                    @if(session('success'))
                    <div class="mb-6 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded relative">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif
                    
                    <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" id="name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" id="email" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <input type="text" name="phone" id="phone" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
                            <input type="text" name="subject" id="subject" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                            <textarea name="message" id="message" rows="5" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required></textarea>
                            @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="privacy" name="privacy" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" required>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="privacy" class="text-gray-600">Saya setuju bahwa data saya akan diproses sesuai dengan <a href="{{ route('privacy-policy') }}" class="text-blue-600 hover:text-blue-800">Kebijakan Privasi</a>.</label>
                            </div>
                        </div>
                        
                        <div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-md font-medium shadow-sm transition duration-200">
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Map Section -->
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Lokasi Kami</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Temukan kami di Lokasi Berikut</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="aspect-w-16 aspect-h-9">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.0340573391413!2d110.77019637485432!3d-7.57126597478397!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a158bab28cee1%3A0xbdf582bbed3b3c2a!2sDapur%20Kode%20-%20Jasa%20Pembuatan%20Website!5e0!3m2!1sid!2sid!4v1755858778538!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Section -->
<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Pertanyaan Umum</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Jawaban untuk pertanyaan yang sering diajukan</p>
        </div>
        
        <div class="max-w-3xl mx-auto space-y-4">
            <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                <button 
                    @click="open = !open" 
                    class="flex justify-between items-center w-full px-4 py-3 text-left font-medium text-gray-900 focus:outline-none">
                    <span>Bagaimana cara menjadi penjual di DapurKode?</span>
                    <i class="fas" :class="{ 'fa-chevron-up': open, 'fa-chevron-down': !open }"></i>
                </button>
                <div 
                    x-show="open" 
                    x-transition:enter="transition ease-out duration-200" 
                    x-transition:enter-start="opacity-0 transform scale-95" 
                    x-transition:enter-end="opacity-100 transform scale-100" 
                    x-transition:leave="transition ease-in duration-150" 
                    x-transition:leave-start="opacity-100 transform scale-100" 
                    x-transition:leave-end="opacity-0 transform scale-95" 
                    class="px-4 pb-4">
                    <p class="text-gray-700">Untuk menjadi penjual di DapurKode, Anda perlu mendaftar akun, memverifikasi identitas Anda, dan mengisi formulir aplikasi penjual. Tim kami akan meninjau aplikasi Anda dan menghubungi Anda dalam 3-5 hari kerja.</p>
                </div>
            </div>
            
            <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                <button 
                    @click="open = !open" 
                    class="flex justify-between items-center w-full px-4 py-3 text-left font-medium text-gray-900 focus:outline-none">
                    <span>Apa saja jenis produk yang bisa saya jual di DapurKode?</span>
                    <i class="fas" :class="{ 'fa-chevron-up': open, 'fa-chevron-down': !open }"></i>
                </button>
                <div 
                    x-show="open" 
                    x-transition:enter="transition ease-out duration-200" 
                    x-transition:enter-start="opacity-0 transform scale-95" 
                    x-transition:enter-end="opacity-100 transform scale-100" 
                    x-transition:leave="transition ease-in duration-150" 
                    x-transition:leave-start="opacity-100 transform scale-100" 
                    x-transition:leave-end="opacity-0 transform scale-95" 
                    class="px-4 pb-4">
                    <p class="text-gray-700">DapurKode fokus pada produk digital seperti template website, tema, plugin, aplikasi, UI kit, ikon, grafik, dan produk digital lainnya yang berhubungan dengan pengembangan web, mobile, dan desain UI/UX.</p>
                </div>
            </div>
            
            <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                <button 
                    @click="open = !open" 
                    class="flex justify-between items-center w-full px-4 py-3 text-left font-medium text-gray-900 focus:outline-none">
                    <span>Berapa biaya komisi untuk penjual?</span>
                    <i class="fas" :class="{ 'fa-chevron-up': open, 'fa-chevron-down': !open }"></i>
                </button>
                <div 
                    x-show="open" 
                    x-transition:enter="transition ease-out duration-200" 
                    x-transition:enter-start="opacity-0 transform scale-95" 
                    x-transition:enter-end="opacity-100 transform scale-100" 
                    x-transition:leave="transition ease-in duration-150" 
                    x-transition:leave-start="opacity-100 transform scale-100" 
                    x-transition:leave-end="opacity-0 transform scale-95" 
                    class="px-4 pb-4">
                    <p class="text-gray-700">Komisi standar untuk penjual adalah 25% dari harga produk. Namun, komisi dapat bervariasi tergantung pada volume penjualan dan status penjual. Penjual eksklusif dengan volume tinggi bisa mendapatkan tingkat komisi yang lebih rendah.</p>
                </div>
            </div>
            
            <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                <button 
                    @click="open = !open" 
                    class="flex justify-between items-center w-full px-4 py-3 text-left font-medium text-gray-900 focus:outline-none">
                    <span>Bagaimana cara pembayaran untuk pembelian produk?</span>
                    <i class="fas" :class="{ 'fa-chevron-up': open, 'fa-chevron-down': !open }"></i>
                </button>
                <div 
                    x-show="open" 
                    x-transition:enter="transition ease-out duration-200" 
                    x-transition:enter-start="opacity-0 transform scale-95" 
                    x-transition:enter-end="opacity-100 transform scale-100" 
                    x-transition:leave="transition ease-in duration-150" 
                    x-transition:leave-start="opacity-100 transform scale-100" 
                    x-transition:leave-end="opacity-0 transform scale-95" 
                    class="px-4 pb-4">
                    <p class="text-gray-700">DapurKode menerima pembayaran melalui kartu kredit/debit (Visa, Mastercard), transfer bank, e-wallet (GoPay, OVO, DANA), dan virtual account. Kami juga menerima pembayaran melalui PayPal untuk transaksi internasional.</p>
                </div>
            </div>
            
            <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                <button 
                    @click="open = !open" 
                    class="flex justify-between items-center w-full px-4 py-3 text-left font-medium text-gray-900 focus:outline-none">
                    <span>Apakah ada garansi untuk produk yang dibeli?</span>
                    <i class="fas" :class="{ 'fa-chevron-up': open, 'fa-chevron-down': !open }"></i>
                </button>
                <div 
                    x-show="open" 
                    x-transition:enter="transition ease-out duration-200" 
                    x-transition:enter-start="opacity-0 transform scale-95" 
                    x-transition:enter-end="opacity-100 transform scale-100" 
                    x-transition:leave="transition ease-in duration-150" 
                    x-transition:leave-start="opacity-100 transform scale-100" 
                    x-transition:leave-end="opacity-0 transform scale-95" 
                    class="px-4 pb-4">
                    <p class="text-gray-700">Ya, semua produk di DapurKode memiliki garansi selama 30 hari. Jika produk tidak berfungsi sebagaimana mestinya atau tidak sesuai dengan deskripsi, Anda bisa meminta pengembalian dana. Beberapa produk juga menawarkan opsi perpanjangan garansi dengan biaya tambahan.</p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('faq') }}" class="inline-flex items-center text-blue-600 font-medium hover:text-blue-800">
                Lihat semua FAQ
                <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="py-16 bg-blue-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-6">Punya Pertanyaan Lain?</h2>
        <p class="text-xl mb-8 max-w-3xl mx-auto">Tim kami siap membantu Anda melalui berbagai saluran komunikasi</p>
        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="mailto:support@dapurkode.com" class="inline-flex items-center justify-center bg-white text-blue-700 hover:bg-gray-100 font-medium py-3 px-8 rounded-md shadow-sm transition duration-200">
                <i class="fas fa-envelope mr-2"></i>
                Email Support
            </a>
            <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center justify-center bg-transparent hover:bg-blue-800 border border-white font-medium py-3 px-8 rounded-md shadow-sm transition duration-200">
                <i class="fab fa-whatsapp mr-2"></i>
                WhatsApp
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .aspect-w-16 {
        position: relative;
        padding-bottom: 56.25%;
    }
    .aspect-w-16 iframe {
        position: absolute;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }
</style>
@endpush
