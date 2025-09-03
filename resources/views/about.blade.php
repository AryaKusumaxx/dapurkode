@extends('layouts.guest.navigation')

@section('title', 'Tentang Kami')

@section('content')
<!-- About Header -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6">Tentang DapurKode</h1>
        <p class="text-xl max-w-3xl mx-auto">Marketplace produk digital premium untuk para developer dan bisnis di Indonesia</p>
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
                    <span class="ml-2 text-gray-700 font-medium">Tentang Kami</span>
                </li>
            </ol>
        </nav>
    </div>
</div>

<!-- Our Story -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Cerita Kami</h2>
                <div class="text-lg text-gray-700 space-y-4">
                    <p>DapurKode didirikan pada tahun 2020 dengan visi menjadi marketplace produk digital terkemuka di Indonesia yang menghubungkan para pengembang kreatif dengan bisnis yang membutuhkan solusi digital berkualitas.</p>
                    <p>Kami percaya bahwa produk digital berkualitas tinggi seharusnya dapat diakses dengan mudah oleh semua kalangan, dari startup hingga korporasi besar. Dengan pengalaman lebih dari 10 tahun di industri teknologi, kami memahami tantangan yang dihadapi oleh pengembang dan bisnis di Indonesia.</p>
                    <p>DapurKode hadir sebagai solusi yang menghubungkan pengembang berbakat dengan pelanggan yang membutuhkan produk digital mereka, sambil memastikan kualitas, dukungan, dan keamanan transaksi.</p>
                </div>
            </div>
            <div class="mt-12 lg:mt-0">
                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="{{ asset('images/about-story.jpg') }}" alt="DapurKode Story" class="w-full h-auto">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Our Mission and Vision -->
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Misi dan Visi</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Memberdayakan kreativitas dan inovasi digital di Indonesia</p>
        </div>
        
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
                <div class="inline-block p-3 bg-blue-100 rounded-full text-blue-600 mb-4">
                    <i class="fas fa-bullseye fa-2x"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Misi Kami</h3>
                <ul class="space-y-3 text-gray-700">
                    <li class="flex items-start">
                        <span class="text-blue-600 mr-2"><i class="fas fa-check-circle mt-1"></i></span>
                        <span>Menyediakan platform yang aman dan terpercaya untuk transaksi produk digital</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-blue-600 mr-2"><i class="fas fa-check-circle mt-1"></i></span>
                        <span>Mendukung pengembang lokal untuk memasarkan karya digital mereka ke pasar yang lebih luas</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-blue-600 mr-2"><i class="fas fa-check-circle mt-1"></i></span>
                        <span>Memastikan kualitas produk digital dengan standar tinggi dan dukungan pelanggan prima</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-blue-600 mr-2"><i class="fas fa-check-circle mt-1"></i></span>
                        <span>Mengedukasi pasar tentang manfaat dan nilai investasi produk digital berkualitas</span>
                    </li>
                </ul>
            </div>
            
            <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
                <div class="inline-block p-3 bg-blue-100 rounded-full text-blue-600 mb-4">
                    <i class="fas fa-eye fa-2x"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Visi Kami</h3>
                <div class="space-y-3 text-gray-700">
                    <p>Menjadi marketplace produk digital terdepan di Indonesia yang menghubungkan pengembang berbakat dengan bisnis dari berbagai skala, serta mempercepat transformasi digital di Indonesia.</p>
                    <p>Kami membayangkan masa depan di mana:</p>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-2"><i class="fas fa-arrow-right mt-1"></i></span>
                            <span>Produk digital berkualitas dapat diakses dengan mudah oleh semua kalangan bisnis</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-2"><i class="fas fa-arrow-right mt-1"></i></span>
                            <span>Pengembang lokal mendapatkan penghasilan yang layak dari karya mereka</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-2"><i class="fas fa-arrow-right mt-1"></i></span>
                            <span>Ekosistem digital di Indonesia tumbuh pesat dan kompetitif secara global</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Our Values -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Nilai-nilai Kami</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Prinsip yang memandu setiap keputusan dan tindakan kami</p>
        </div>
        
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="inline-block p-3 bg-blue-100 rounded-full text-blue-600 mb-4">
                    <i class="fas fa-award fa-2x"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Kualitas</h3>
                <p class="text-gray-600">Kami menjaga standar kualitas tinggi untuk setiap produk digital yang tersedia di platform kami.</p>
            </div>
            
            <div class="text-center">
                <div class="inline-block p-3 bg-blue-100 rounded-full text-blue-600 mb-4">
                    <i class="fas fa-shield-alt fa-2x"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Integritas</h3>
                <p class="text-gray-600">Kami menjalankan bisnis dengan transparansi dan kejujuran dalam setiap transaksi dan hubungan.</p>
            </div>
            
            <div class="text-center">
                <div class="inline-block p-3 bg-blue-100 rounded-full text-blue-600 mb-4">
                    <i class="fas fa-lightbulb fa-2x"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Inovasi</h3>
                <p class="text-gray-600">Kami selalu mencari cara baru untuk meningkatkan layanan dan pengalaman pengguna platform kami.</p>
            </div>
            
            <div class="text-center">
                <div class="inline-block p-3 bg-blue-100 rounded-full text-blue-600 mb-4">
                    <i class="fas fa-hands-helping fa-2x"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Kolaborasi</h3>
                <p class="text-gray-600">Kami percaya pada kekuatan kolaborasi dan membangun komunitas yang mendukung pertumbuhan bersama.</p>
            </div>
        </div>
    </div>
</div>

<!-- Our Team -->
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Tim Kami</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Orang-orang berbakat di balik DapurKode</p>
        </div>
        
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white rounded-lg overflow-hidden shadow-sm border border-gray-100 text-center">
                <img src="{{ asset('images/team-1.jpg') }}" alt="Team Member" class="w-full h-64 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900">Ahmad Rizki</h3>
                    <p class="text-blue-600 mb-3">Founder & CEO</p>
                    <p class="text-gray-600 mb-4">Visioner teknologi dengan pengalaman 15 tahun di industri IT dan startups.</p>
                    <div class="flex justify-center space-x-3 text-gray-400">
                        <a href="#" class="hover:text-blue-600"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="hover:text-blue-400"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="hover:text-gray-800"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg overflow-hidden shadow-sm border border-gray-100 text-center">
                <img src="{{ asset('images/team-2.jpg') }}" alt="Team Member" class="w-full h-64 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900">Siti Amelia</h3>
                    <p class="text-blue-600 mb-3">CTO</p>
                    <p class="text-gray-600 mb-4">Ahli teknologi dan pengembangan platform dengan latar belakang di berbagai perusahaan Fortune 500.</p>
                    <div class="flex justify-center space-x-3 text-gray-400">
                        <a href="#" class="hover:text-blue-600"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="hover:text-blue-400"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="hover:text-gray-800"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg overflow-hidden shadow-sm border border-gray-100 text-center">
                <img src="{{ asset('images/team-3.jpg') }}" alt="Team Member" class="w-full h-64 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900">Budi Santoso</h3>
                    <p class="text-blue-600 mb-3">Head of Product</p>
                    <p class="text-gray-600 mb-4">Spesialis produk dengan pengalaman di berbagai marketplace global dan pemahaman mendalam tentang UX.</p>
                    <div class="flex justify-center space-x-3 text-gray-400">
                        <a href="#" class="hover:text-blue-600"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="hover:text-blue-400"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="hover:text-indigo-600"><i class="fab fa-dribbble"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg overflow-hidden shadow-sm border border-gray-100 text-center">
                <img src="{{ asset('images/team-4.jpg') }}" alt="Team Member" class="w-full h-64 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900">Maya Wijaya</h3>
                    <p class="text-blue-600 mb-3">Marketing Director</p>
                    <p class="text-gray-600 mb-4">Ahli strategi pemasaran digital dengan pengalaman memasarkan produk teknologi di Asia Tenggara.</p>
                    <div class="flex justify-center space-x-3 text-gray-400">
                        <a href="#" class="hover:text-blue-600"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="hover:text-blue-400"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="hover:text-pink-600"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Milestones -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Perjalanan Kami</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Momen penting dalam pertumbuhan DapurKode</p>
        </div>
        
        <div class="relative">
            <!-- Vertical Line -->
            <div class="absolute h-full w-1 bg-blue-200 left-1/2 transform -translate-x-1/2"></div>
            
            <!-- Milestones -->
            <div class="relative z-10">
                <!-- Milestone 1 -->
                <div class="flex flex-col md:flex-row items-center mb-16">
                    <div class="md:w-1/2 md:pr-12 md:text-right mb-6 md:mb-0">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">2020</h3>
                        <h4 class="text-lg font-semibold text-blue-600 mb-2">Peluncuran DapurKode</h4>
                        <p class="text-gray-700">DapurKode didirikan dengan visi menjadi marketplace produk digital terkemuka di Indonesia.</p>
                    </div>
                    <div class="md:w-12 flex justify-center">
                        <div class="w-12 h-12 rounded-full border-4 border-blue-200 bg-blue-600 flex items-center justify-center text-white">
                            <i class="fas fa-flag"></i>
                        </div>
                    </div>
                    <div class="md:w-1/2 md:pl-12"></div>
                </div>
                
                <!-- Milestone 2 -->
                <div class="flex flex-col md:flex-row items-center mb-16">
                    <div class="md:w-1/2 md:pr-12"></div>
                    <div class="md:w-12 flex justify-center">
                        <div class="w-12 h-12 rounded-full border-4 border-blue-200 bg-blue-600 flex items-center justify-center text-white">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="md:w-1/2 md:pl-12 mb-6 md:mb-0">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">2021</h3>
                        <h4 class="text-lg font-semibold text-blue-600 mb-2">1.000 Pengembang</h4>
                        <p class="text-gray-700">Mencapai 1.000 pengembang terdaftar dan lebih dari 500 produk digital di platform kami.</p>
                    </div>
                </div>
                
                <!-- Milestone 3 -->
                <div class="flex flex-col md:flex-row items-center mb-16">
                    <div class="md:w-1/2 md:pr-12 md:text-right mb-6 md:mb-0">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">2022</h3>
                        <h4 class="text-lg font-semibold text-blue-600 mb-2">Pendanaan Seri A</h4>
                        <p class="text-gray-700">Mengamankan pendanaan Seri A untuk memperluas tim dan meningkatkan platform.</p>
                    </div>
                    <div class="md:w-12 flex justify-center">
                        <div class="w-12 h-12 rounded-full border-4 border-blue-200 bg-blue-600 flex items-center justify-center text-white">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <div class="md:w-1/2 md:pl-12"></div>
                </div>
                
                <!-- Milestone 4 -->
                <div class="flex flex-col md:flex-row items-center mb-16">
                    <div class="md:w-1/2 md:pr-12"></div>
                    <div class="md:w-12 flex justify-center">
                        <div class="w-12 h-12 rounded-full border-4 border-blue-200 bg-blue-600 flex items-center justify-center text-white">
                            <i class="fas fa-trophy"></i>
                        </div>
                    </div>
                    <div class="md:w-1/2 md:pl-12 mb-6 md:mb-0">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">2023</h3>
                        <h4 class="text-lg font-semibold text-blue-600 mb-2">Penghargaan Startup Terbaik</h4>
                        <p class="text-gray-700">Memenangkan penghargaan "Startup Inovatif Terbaik" di Indonesia Digital Awards.</p>
                    </div>
                </div>
                
                <!-- Milestone 5 -->
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/2 md:pr-12 md:text-right mb-6 md:mb-0">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">2024</h3>
                        <h4 class="text-lg font-semibold text-blue-600 mb-2">Ekspansi Regional</h4>
                        <p class="text-gray-700">Mulai ekspansi ke negara-negara Asia Tenggara lainnya dengan ribuan pengembang baru.</p>
                    </div>
                    <div class="md:w-12 flex justify-center">
                        <div class="w-12 h-12 rounded-full border-4 border-blue-200 bg-blue-600 flex items-center justify-center text-white">
                            <i class="fas fa-globe-asia"></i>
                        </div>
                    </div>
                    <div class="md:w-1/2 md:pl-12"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Testimonials -->
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Apa Kata Mereka</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Pengalaman dari klien dan pengembang kami</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100 relative">
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-quote-left fa-2x"></i>
                </div>
                <p class="text-gray-700 mb-6">DapurKode membantu produk template saya mendapatkan exposure yang lebih luas. Proses pembayaran yang cepat dan dukungan tim yang responsif membuat saya nyaman menjadi seller di platform ini.</p>
                <div class="flex items-center">
                    <div class="mr-4">
                        <img src="{{ asset('images/testimonial-1.jpg') }}" alt="Testimonial" class="w-12 h-12 rounded-full object-cover">
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Arif Wicaksono</h4>
                        <p class="text-sm text-gray-600">Web Template Developer</p>
                    </div>
                </div>
                <div class="absolute bottom-0 right-0 p-6 text-yellow-400">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
            
            <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100 relative">
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-quote-left fa-2x"></i>
                </div>
                <p class="text-gray-700 mb-6">Sebagai startup kecil, kami bisa menghemat biaya dan waktu dengan membeli template admin panel di DapurKode. Kualitasnya sangat bagus dan dukungan dari developer sangat membantu implementasi kami.</p>
                <div class="flex items-center">
                    <div class="mr-4">
                        <img src="{{ asset('images/testimonial-2.jpg') }}" alt="Testimonial" class="w-12 h-12 rounded-full object-cover">
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Dina Permata</h4>
                        <p class="text-sm text-gray-600">CTO, EdTech Startup</p>
                    </div>
                </div>
                <div class="absolute bottom-0 right-0 p-6 text-yellow-400">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
            
            <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100 relative">
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-quote-left fa-2x"></i>
                </div>
                <p class="text-gray-700 mb-6">Saya sangat senang dengan proses verifikasi kualitas yang diterapkan DapurKode. Sebagai pembeli, saya merasa aman karena produk yang dibeli dijamin kualitasnya dan sesuai deskripsi.</p>
                <div class="flex items-center">
                    <div class="mr-4">
                        <img src="{{ asset('images/testimonial-3.jpg') }}" alt="Testimonial" class="w-12 h-12 rounded-full object-cover">
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">Rudi Hartono</h4>
                        <p class="text-sm text-gray-600">Digital Marketing Consultant</p>
                    </div>
                </div>
                <div class="absolute bottom-0 right-0 p-6 text-yellow-400">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="py-16 bg-blue-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-6">Bergabunglah dengan Komunitas DapurKode</h2>
        <p class="text-xl mb-8 max-w-3xl mx-auto">Temukan produk digital berkualitas atau mulai jual karya digital Anda sekarang!</p>
        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('register') }}" class="bg-white text-blue-700 hover:bg-gray-100 font-medium py-3 px-8 rounded-md shadow-sm transition duration-200">
                Daftar Sekarang
            </a>
            <a href="{{ route('products.index') }}" class="bg-transparent hover:bg-blue-800 border border-white font-medium py-3 px-8 rounded-md shadow-sm transition duration-200">
                Jelajahi Produk
            </a>
        </div>
    </div>
</div>
@endsection
