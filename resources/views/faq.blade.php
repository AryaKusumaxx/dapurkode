@extends('layouts.guest.navigation')

@section('title', 'FAQ - Pertanyaan yang Sering Diajukan')

@section('content')
<!-- FAQ Header -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6">Pertanyaan yang Sering Diajukan</h1>
        <p class="text-xl max-w-3xl mx-auto">Temukan jawaban untuk pertanyaan umum tentang DapurKode</p>
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
                    <span class="ml-2 text-gray-700 font-medium">FAQ</span>
                </li>
            </ol>
        </nav>
    </div>
</div>

<!-- FAQ Content -->
<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search Box -->
        <div class="max-w-3xl mx-auto mb-12">
            <div class="flex items-center bg-gray-50 rounded-lg border border-gray-300 overflow-hidden">
                <div class="px-4 text-gray-400">
                    <i class="fas fa-search"></i>
                </div>
                <input type="text" placeholder="Cari pertanyaan..." id="faqSearch" class="w-full py-4 px-2 bg-transparent border-0 focus:ring-0 focus:outline-none">
            </div>
        </div>
        
        <!-- FAQ Categories -->
        <div class="mb-12">
            <div class="flex flex-wrap justify-center gap-4">
                <button class="faq-category-btn active px-6 py-2 rounded-full border border-blue-600 bg-blue-600 text-white font-medium" data-category="all">
                    Semua
                </button>
                <button class="faq-category-btn px-6 py-2 rounded-full border border-gray-300 text-gray-700 font-medium hover:bg-gray-50" data-category="general">
                    Umum
                </button>
                <button class="faq-category-btn px-6 py-2 rounded-full border border-gray-300 text-gray-700 font-medium hover:bg-gray-50" data-category="buyer">
                    Pembeli
                </button>
                <button class="faq-category-btn px-6 py-2 rounded-full border border-gray-300 text-gray-700 font-medium hover:bg-gray-50" data-category="seller">
                    Penjual
                </button>
                <button class="faq-category-btn px-6 py-2 rounded-full border border-gray-300 text-gray-700 font-medium hover:bg-gray-50" data-category="payment">
                    Pembayaran
                </button>
                <button class="faq-category-btn px-6 py-2 rounded-full border border-gray-300 text-gray-700 font-medium hover:bg-gray-50" data-category="support">
                    Dukungan
                </button>
            </div>
        </div>
        
        <!-- FAQ Questions and Answers -->
        <div class="max-w-3xl mx-auto space-y-6">
            <!-- General FAQ Section -->
            <div class="faq-section" data-category="general">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Pertanyaan Umum</h2>
                
                <div class="space-y-4">
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Apa itu DapurKode?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">DapurKode adalah marketplace produk digital premium yang menghubungkan pengembang berbakat dengan bisnis yang membutuhkan solusi digital berkualitas. Platform kami menyediakan berbagai produk digital seperti template website, tema, plugin, aplikasi, UI kit, dan produk digital lainnya yang berhubungan dengan pengembangan web, mobile, dan desain UI/UX.</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Bagaimana cara mendaftar di DapurKode?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">Untuk mendaftar di DapurKode, klik tombol "Daftar" di sudut kanan atas halaman. Isi formulir pendaftaran dengan informasi yang diminta termasuk nama, alamat email, dan kata sandi. Setelah mendaftar, Anda akan menerima email konfirmasi untuk memverifikasi akun Anda. Klik tautan verifikasi dalam email tersebut untuk mengaktifkan akun Anda.</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Apa keuntungan mendaftar di DapurKode?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">Mendaftar di DapurKode memberikan Anda akses ke berbagai produk digital premium, pembaruan produk gratis, pelacakan riwayat pembelian, dukungan prioritas, dan akses ke konten eksklusif. Anda juga dapat menyimpan produk favorit dalam wishlist, mengelola unduhan, dan mendapatkan diskon khusus member.</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Apa perbedaan DapurKode dengan marketplace lain?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">DapurKode fokus pada kualitas produk digital premium dengan standar tinggi dan proses verifikasi ketat. Kami mengutamakan pengembang lokal Indonesia, menyediakan dukungan dalam Bahasa Indonesia, menggunakan metode pembayaran lokal, dan memahami kebutuhan bisnis lokal. Kami juga menawarkan dukungan pelanggan yang lebih personal dan program loyalitas yang kompetitif.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Buyer FAQ Section -->
            <div class="faq-section hidden" data-category="buyer">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi untuk Pembeli</h2>
                
                <div class="space-y-4">
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Bagaimana cara membeli produk di DapurKode?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">Untuk membeli produk di DapurKode, ikuti langkah-langkah berikut:</p>
                            <ol class="list-decimal pl-5 mt-2 space-y-1 text-gray-700">
                                <li>Temukan produk yang ingin dibeli melalui navigasi atau pencarian</li>
                                <li>Buka halaman detail produk dan klik tombol "Tambah ke Keranjang"</li>
                                <li>Lihat keranjang belanja dan klik "Checkout"</li>
                                <li>Pilih metode pembayaran dan lengkapi informasi yang diperlukan</li>
                                <li>Klik "Bayar" untuk menyelesaikan pembelian</li>
                                <li>Setelah pembayaran dikonfirmasi, produk dapat diunduh dari halaman "Unduhan Saya"</li>
                            </ol>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">Ya, semua produk di DapurKode dilengkapi dengan garansi 30 hari. Jika produk tidak berfungsi sebagaimana dijelaskan dalam deskripsi atau terdapat bug yang tidak dapat diperbaiki, Anda berhak mendapatkan pengembalian dana penuh. Untuk beberapa produk, tersedia juga opsi perpanjangan garansi dengan biaya tambahan, memberikan perlindungan yang lebih lama hingga 6 atau 12 bulan.</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Bagaimana cara mengunduh produk setelah pembelian?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">Setelah pembayaran dikonfirmasi, Anda akan menerima email berisi tautan unduhan produk. Anda juga dapat mengakses semua produk yang telah dibeli dengan masuk ke akun Anda dan pergi ke bagian "Unduhan Saya". Di sana Anda akan menemukan daftar semua produk yang telah dibeli beserta tautan unduhan, informasi lisensi, dan dokumentasi produk.</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Apakah saya mendapatkan pembaruan gratis untuk produk?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">Ya, setiap pembelian di DapurKode mencakup pembaruan gratis dalam versi utama yang sama. Misalnya, jika Anda membeli produk versi 1.0, Anda akan mendapatkan semua pembaruan minor (1.1, 1.2, dll.) secara gratis. Pembaruan versi utama (misalnya dari versi 1.x ke versi 2.0) mungkin memerlukan biaya upgrade, tetapi biasanya ditawarkan dengan diskon bagi pelanggan yang sudah ada.</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Bisakah saya meminta pengembalian dana?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">Ya, Anda dapat meminta pengembalian dana dalam 30 hari setelah pembelian jika produk tidak berfungsi sebagaimana mestinya atau tidak sesuai dengan deskripsi. Untuk meminta pengembalian dana, masuk ke akun Anda, buka bagian "Pesanan Saya", pilih pesanan yang ingin dibatalkan, dan klik tombol "Minta Pengembalian Dana". Jelaskan alasan permintaan pengembalian dana Anda, dan tim dukungan kami akan meninjau permintaan Anda dalam 1-3 hari kerja.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Seller FAQ Section -->
            <div class="faq-section hidden" data-category="seller">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi untuk Penjual</h2>
                
                <div class="space-y-4">
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">Untuk menjadi penjual di DapurKode, ikuti langkah-langkah berikut:</p>
                            <ol class="list-decimal pl-5 mt-2 space-y-1 text-gray-700">
                                <li>Buat akun DapurKode atau masuk ke akun yang sudah ada</li>
                                <li>Klik "Jadi Penjual" di halaman profil Anda</li>
                                <li>Lengkapi profil penjual dengan informasi pribadi dan portofolio</li>
                                <li>Kirimkan contoh produk untuk ditinjau</li>
                                <li>Setelah disetujui, Anda dapat mulai mengunggah produk untuk dijual</li>
                            </ol>
                            <p class="mt-3 text-gray-700">Proses persetujuan biasanya memakan waktu 3-5 hari kerja.</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">DapurKode menerima berbagai jenis produk digital seperti:</p>
                            <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-700">
                                <li>Template dan tema website (HTML, WordPress, Laravel, React, dll.)</li>
                                <li>Plugin dan ekstensi (WordPress, Joomla, Magento, dll.)</li>
                                <li>Template aplikasi mobile (Flutter, React Native, dll.)</li>
                                <li>UI kit dan komponen</li>
                                <li>Grafis dan aset desain</li>
                                <li>Kode sumber aplikasi lengkap</li>
                                <li>Script dan solusi otomatisasi</li>
                            </ul>
                            <p class="mt-3 text-gray-700">Semua produk harus asli, berkualitas tinggi, dan mematuhi standar pengkodean yang baik.</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Berapa komisi yang diambil DapurKode dari penjualan saya?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">Komisi standar DapurKode adalah 25% dari harga penjualan. Artinya, penjual menerima 75% dari setiap penjualan. Namun, persentase komisi dapat bervariasi berdasarkan:</p>
                            <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-700">
                                <li>Status eksklusivitas penjual (penjual eksklusif mendapatkan persentase yang lebih tinggi)</li>
                                <li>Volume penjualan (penjual dengan volume tinggi dapat memenuhi syarat untuk tingkat komisi yang lebih rendah)</li>
                                <li>Kualitas dan kerumitan produk</li>
                            </ul>
                            <p class="mt-3 text-gray-700">Penjual tingkat Elite dengan volume penjualan tinggi bisa mendapatkan hingga 85% dari harga penjualan.</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Bagaimana cara saya menerima pembayaran sebagai penjual?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">Penjual di DapurKode menerima pembayaran melalui metode berikut:</p>
                            <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-700">
                                <li>Transfer bank (bank lokal Indonesia)</li>
                                <li>PayPal</li>
                                <li>Wise (sebelumnya TransferWise)</li>
                                <li>E-wallet lokal (GoPay, OVO, Dana)</li>
                            </ul>
                            <p class="mt-3 text-gray-700">Pembayaran diproses setiap bulan untuk saldo di atas Rp 500.000. Penjual dapat melihat saldo mereka saat ini dan riwayat pembayaran di dasbor penjual.</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Bagaimana proses persetujuan produk di DapurKode?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">DapurKode menerapkan proses peninjauan yang ketat untuk memastikan kualitas produk. Setelah Anda mengirimkan produk, tim kami akan memeriksa:</p>
                            <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-700">
                                <li>Kualitas kode dan desain</li>
                                <li>Kepatuhan terhadap standar industri</li>
                                <li>Kegunaan dan fungsionalitas</li>
                                <li>Dokumentasi dan dukungan</li>
                                <li>Keaslian dan masalah hak cipta</li>
                            </ul>
                            <p class="mt-3 text-gray-700">Proses peninjauan biasanya memakan waktu 3-7 hari kerja. Jika produk tidak disetujui, Anda akan menerima umpan balik tentang perubahan yang diperlukan untuk penyerahan ulang.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Payment FAQ Section -->
            <div class="faq-section hidden" data-category="payment">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Pembayaran & Penagihan</h2>
                
                <div class="space-y-4">
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Metode pembayaran apa saja yang tersedia?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">DapurKode menerima berbagai metode pembayaran, termasuk:</p>
                            <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-700">
                                <li>Kartu kredit/debit (Visa, Mastercard, JCB)</li>
                                <li>Transfer bank (BCA, Mandiri, BNI, BRI, dan bank lainnya)</li>
                                <li>E-wallet (GoPay, OVO, DANA, LinkAja)</li>
                                <li>Virtual account</li>
                                <li>PayPal (untuk transaksi internasional)</li>
                                <li>QRIS</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Apakah pembayaran di DapurKode aman?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">Ya, keamanan pembayaran di DapurKode menjadi prioritas utama kami. Kami menggunakan enkripsi SSL 256-bit untuk semua transaksi dan mematuhi standar keamanan PCI DSS. Kami bekerja sama dengan gateway pembayaran terpercaya seperti Midtrans dan Xendit untuk memproses pembayaran. Data kartu kredit Anda tidak pernah disimpan di server kami, memastikan transaksi yang aman dan terlindungi.</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Berapa lama waktu konfirmasi pembayaran?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">Waktu konfirmasi pembayaran bergantung pada metode pembayaran yang dipilih:</p>
                            <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-700">
                                <li>Kartu kredit/debit & e-wallet: Konfirmasi instan</li>
                                <li>Virtual account: 5-15 menit setelah pembayaran</li>
                                <li>Transfer bank manual: 1-24 jam kerja (tergantung pada waktu transfer)</li>
                                <li>QRIS: 5-15 menit setelah pembayaran</li>
                            </ul>
                            <p class="mt-3 text-gray-700">Setelah pembayaran dikonfirmasi, Anda akan menerima email konfirmasi dengan detail pembelian dan tautan unduhan produk.</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Apakah harga yang ditampilkan sudah termasuk pajak?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">Untuk pembeli di Indonesia, harga yang ditampilkan belum termasuk PPN 11%. PPN akan ditambahkan pada saat checkout dan tercantum secara terpisah di faktur. Untuk pembeli internasional, pajak mungkin berlaku sesuai dengan peraturan negara masing-masing. Jika Anda adalah bisnis terdaftar di Indonesia dan memiliki NPWP, Anda dapat memasukkan NPWP Anda saat checkout untuk dokumentasi pajak yang tepat.</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Dapatkah saya mendapatkan faktur untuk pembelian?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">Ya, faktur elektronik akan secara otomatis dikirimkan ke alamat email Anda setelah pembayaran berhasil. Anda juga dapat mengunduh faktur dari halaman "Riwayat Pesanan" di akun Anda. Untuk perusahaan yang memerlukan faktur dengan detail khusus, Anda dapat mengisi informasi penagihan perusahaan Anda (nama perusahaan, alamat, dan NPWP) di profil Anda atau pada saat checkout.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Support FAQ Section -->
            <div class="faq-section hidden" data-category="support">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Dukungan Pelanggan</h2>
                
                <div class="space-y-4">
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Bagaimana cara menghubungi dukungan pelanggan?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">Anda dapat menghubungi dukungan pelanggan DapurKode melalui berbagai saluran:</p>
                            <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-700">
                                <li>Email: support@dapurkode.com (Respon dalam 24 jam)</li>
                                <li>Live Chat: Tersedia di situs web kami dari Senin-Jumat, 09.00-17.00 WIB</li>
                                <li>WhatsApp: +62 812 3456 7890 (Senin-Jumat, 09.00-17.00 WIB)</li>
                                <li>Formulir Kontak: Tersedia di halaman Kontak Kami</li>
                                <li>Tiket Dukungan: Masuk ke akun Anda dan buka bagian "Dukungan"</li>
                            </ul>
                            <p class="mt-3 text-gray-700">Untuk pertanyaan terkait produk tertentu, sebaiknya hubungi penjual langsung melalui halaman detail produk.</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Apakah ada dukungan instalasi untuk produk?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">Setiap produk di DapurKode dilengkapi dengan dokumentasi instalasi dan penggunaan yang komprehensif. Dukungan instalasi dasar disediakan oleh penjual produk. Jika Anda mengalami masalah selama instalasi, Anda dapat:</p>
                            <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-700">
                                <li>Mengajukan pertanyaan langsung kepada penjual melalui tab "Diskusi" di halaman produk</li>
                                <li>Memeriksa dokumentasi dan FAQ produk</li>
                                <li>Mengakses video tutorial (jika tersedia)</li>
                            </ul>
                            <p class="mt-3 text-gray-700">Untuk instalasi yang lebih kompleks atau kustomisasi, beberapa penjual menawarkan layanan instalasi premium dengan biaya tambahan.</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Berapa lama waktu respons dukungan pelanggan?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">Waktu respons dukungan pelanggan bervariasi tergantung pada saluran dan jenis masalah:</p>
                            <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-700">
                                <li>Live Chat: Respons instan selama jam kerja (Senin-Jumat, 09.00-17.00 WIB)</li>
                                <li>Email & Tiket: 24 jam kerja</li>
                                <li>WhatsApp: 2-4 jam selama jam kerja</li>
                                <li>Pertanyaan produk kepada penjual: 24-48 jam</li>
                            </ul>
                            <p class="mt-3 text-gray-700">Untuk masalah mendesak seperti pembayaran atau akses produk, kami berusaha merespons lebih cepat.</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Apakah DapurKode menyediakan layanan kustomisasi produk?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">DapurKode sendiri tidak menyediakan layanan kustomisasi produk secara langsung. Namun, banyak penjual di platform kami menawarkan layanan kustomisasi untuk produk mereka dengan biaya tambahan. Jika Anda membutuhkan kustomisasi, Anda dapat:</p>
                            <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-700">
                                <li>Menghubungi penjual langsung melalui halaman produk</li>
                                <li>Memeriksa apakah penjual menawarkan paket kustomisasi yang dapat dibeli</li>
                                <li>Menggunakan fitur "Permintaan Kustomisasi" yang tersedia di beberapa produk</li>
                            </ul>
                            <p class="mt-3 text-gray-700">DapurKode dapat membantu memfasilitasi komunikasi antara Anda dan penjual untuk kebutuhan kustomisasi.</p>
                        </div>
                    </div>
                    
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md faq-item">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-6 py-4 text-left font-medium text-gray-900 focus:outline-none">
                            <span>Bagaimana cara melaporkan masalah produk atau bug?</span>
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
                            class="px-6 pb-6 pt-2">
                            <p class="text-gray-700">Untuk melaporkan masalah produk atau bug, ikuti langkah-langkah ini:</p>
                            <ol class="list-decimal pl-5 mt-2 space-y-1 text-gray-700">
                                <li>Masuk ke akun DapurKode Anda</li>
                                <li>Buka "Unduhan Saya" dan temukan produk yang bermasalah</li>
                                <li>Klik tombol "Laporkan Masalah" di halaman detail produk</li>
                                <li>Isi formulir dengan detail masalah, termasuk langkah-langkah untuk mereproduksi bug, tangkapan layar, dan informasi sistem Anda</li>
                                <li>Kirim laporan</li>
                            </ol>
                            <p class="mt-3 text-gray-700">Laporan Anda akan dikirim langsung ke penjual dan tim dukungan DapurKode. Penjual diharuskan merespons dalam 48 jam kerja untuk masalah kritis.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- No Results Message -->
        <div id="no-results" class="hidden text-center py-12 max-w-3xl mx-auto">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-search fa-3x"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Tidak ada hasil yang ditemukan</h3>
            <p class="text-gray-600">Coba gunakan kata kunci lain atau lihat kategori pertanyaan di atas.</p>
        </div>
        
        <!-- Still Need Help -->
        <div class="max-w-3xl mx-auto mt-16 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Masih Butuh Bantuan?</h2>
            <p class="text-lg text-gray-600 mb-8">Tim dukungan kami siap membantu Anda dengan pertanyaan dan masalah apa pun</p>
            <a href="{{ route('contact') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-md shadow-sm transition duration-200">
                Hubungi Kami
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Category filtering
        const categoryButtons = document.querySelectorAll('.faq-category-btn');
        const faqSections = document.querySelectorAll('.faq-section');
        
        categoryButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                categoryButtons.forEach(btn => btn.classList.remove('active', 'bg-blue-600', 'text-white'));
                categoryButtons.forEach(btn => btn.classList.add('border-gray-300', 'text-gray-700'));
                
                // Add active class to clicked button
                button.classList.add('active', 'bg-blue-600', 'text-white');
                button.classList.remove('border-gray-300', 'text-gray-700');
                
                const category = button.getAttribute('data-category');
                
                // Show/hide sections based on category
                faqSections.forEach(section => {
                    if (category === 'all' || section.getAttribute('data-category') === category) {
                        section.classList.remove('hidden');
                    } else {
                        section.classList.add('hidden');
                    }
                });
                
                // Reset search
                document.getElementById('faqSearch').value = '';
                document.getElementById('no-results').classList.add('hidden');
                const allItems = document.querySelectorAll('.faq-item');
                allItems.forEach(item => {
                    if (!item.closest('.faq-section').classList.contains('hidden')) {
                        item.classList.remove('hidden');
                    }
                });
            });
        });
        
        // Search functionality
        const searchInput = document.getElementById('faqSearch');
        const noResultsDiv = document.getElementById('no-results');
        
        searchInput.addEventListener('keyup', () => {
            const searchTerm = searchInput.value.toLowerCase();
            const allItems = document.querySelectorAll('.faq-item');
            let resultsFound = false;
            
            allItems.forEach(item => {
                const questionText = item.querySelector('button span').textContent.toLowerCase();
                const answerText = item.querySelector('div p').textContent.toLowerCase();
                const isVisible = !item.closest('.faq-section').classList.contains('hidden');
                
                if (isVisible && (questionText.includes(searchTerm) || answerText.includes(searchTerm))) {
                    item.classList.remove('hidden');
                    resultsFound = true;
                } else {
                    item.classList.add('hidden');
                }
            });
            
            // Show/hide no results message
            if (searchTerm && !resultsFound) {
                noResultsDiv.classList.remove('hidden');
            } else {
                noResultsDiv.classList.add('hidden');
            }
        });
    });
</script>
@endpush
