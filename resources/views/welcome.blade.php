@extends('layouts.guest.navigation')

@section('title', 'Digital Product Marketplace')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-r from-blue-700 to-indigo-600 text-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div class="space-y-6">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    Kembangkan Bisnis dengan <span class="text-yellow-300">Produk Digital</span> Berkualitas
                </h1>
                <p class="text-lg md:text-xl text-blue-100">
                    DapurKode menyediakan produk digital berkualitas tinggi untuk kebutuhan website, aplikasi, dan solusi digital bisnis Anda.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 mt-8">
                    <a href="{{ route('products.index') }}" class="bg-white text-blue-700 hover:bg-blue-50 px-6 py-4 rounded-md font-semibold text-center shadow-lg transition duration-300">
                        <i class="fas fa-search mr-2"></i> Jelajahi Produk
                    </a>
                    @guest
                    <a href="{{ route('register') }}" class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 px-6 py-4 rounded-md font-semibold text-center shadow-lg transition duration-300">
                        <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
                    </a>
                    @endguest
                </div>
            </div>
            <div class="hidden lg:block">
                <div class="relative">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-yellow-300 rounded-full opacity-20 animate-pulse"></div>
                    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-blue-300 rounded-full opacity-20 animate-ping" style="animation-duration: 3s"></div>
                    <div class="relative z-10 w-full max-w-md mx-auto overflow-hidden rounded-lg shadow-xl">
                        <img src="{{ asset('storage/images/digitalproduk.png') }}" alt="DapurKode Digital Products" class="w-full transform transition-transform duration-700 hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-tr from-blue-500/20 to-transparent pointer-events-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Wave Decoration -->
    <div class="absolute bottom-0 w-full">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" fill="#ffffff">
            <path d="M0,64L80,53.3C160,43,320,21,480,32C640,43,800,85,960,90.7C1120,96,1280,64,1360,48L1440,32L1440,100L1360,100C1280,100,1120,100,960,100C800,100,640,100,480,100C320,100,160,100,80,100L0,100Z"></path>
        </svg>
    </div>
</div>

<!-- Featured Products Section -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Produk Unggulan</h2>
            <p class="mt-4 text-lg text-gray-600">Produk digital pilihan dengan kualitas terbaik</p>
        </div>
        
        @if($featuredProducts->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredProducts as $product)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200 overflow-hidden h-full flex flex-col group product-card hover-grow">
                <div class="relative overflow-hidden">
                    @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center">
                        <a href="{{ route('products.show', $product->slug) }}" class="text-white font-medium py-2 px-4 mb-4 rounded-md bg-blue-600 hover:bg-blue-700 detail-btn">
                            <i class="fas fa-eye mr-1"></i> Lihat Detail
                        </a>
                    </div>
                    @else
                    <div class="bg-gray-200 w-full h-52 flex items-center justify-center">
                        <span class="text-gray-400"><i class="fas fa-image fa-2x"></i></span>
                    </div>
                    @endif
                    @if($product->discount > 0)
                    <div class="absolute top-0 right-0 bg-red-500 text-white px-3 py-1 m-2 rounded-md">
                        <span class="text-sm font-semibold">{{ $product->discount }}% OFF</span>
                    </div>
                    @endif
                    @if($product->created_at->diffInDays(now()) < 7)
                    <div class="absolute top-0 left-0 bg-green-500 text-white px-3 py-1 m-2 rounded-md">
                        <span class="text-sm font-semibold">Baru</span>
                    </div>
                    @endif
                </div>
                <div class="p-5 flex-grow flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200 line-clamp-2">
                                <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-md ml-1 flex-shrink-0">{{ $product->category }}</span>
                        </div>
                        <p class="text-gray-600 mb-3 text-sm line-clamp-2">{{ $product->description }}</p>
                    </div>
                    <div class="mt-auto">
                        <div class="mb-2">
                            @if($product->discount > 0)
                            <span class="text-sm text-gray-500 line-through block">Rp {{ number_format($product->regular_price, 0, ',', '.') }}</span>
                            <div class="flex items-center">
                                <span class="text-xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="ml-2 bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full font-semibold">Hemat {{ $product->discount }}%</span>
                            </div>
                            @else
                            <span class="text-xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <div class="flex text-yellow-400">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if($i <= ($product->rating ?? 0))
                                    <i class="fas fa-star text-xs"></i>
                                    @else
                                    <i class="far fa-star text-xs"></i>
                                    @endif
                                @endfor
                                <span class="ml-1 text-xs text-gray-600">({{ $product->reviews_count ?? 0 }})</span>
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center group">
                                Detail <i class="fas fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform duration-200"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-10">
            <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 border border-blue-600 text-blue-600 hover:bg-blue-50 rounded-md font-medium transition duration-300">
                Lihat Semua Produk <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        @else
        <div class="text-center p-10 bg-gray-50 rounded-lg">
            <p class="text-gray-600">Produk unggulan belum tersedia</p>
        </div>
        @endif
    </div>
</div>

<!-- Categories Section with Icons -->
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Kategori Produk</h2>
            <p class="mt-4 text-lg text-gray-600">Temukan produk sesuai kebutuhan Anda</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <a href="{{ route('products.index') }}?category=web-template" class="group">
                <div class="bg-white p-6 rounded-lg text-center group-hover:bg-blue-50 transition duration-300 shadow-sm hover:shadow-md border border-gray-100">
                    <div class="bg-blue-100 inline-flex p-4 rounded-full text-blue-600 mb-4">
                        <i class="fas fa-laptop-code text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">Web Templates</h3>
                    <p class="text-sm text-gray-500 mt-2">Template website siap pakai</p>
                </div>
            </a>
            <a href="{{ route('products.index') }}?category=plugin" class="group">
                <div class="bg-white p-6 rounded-lg text-center group-hover:bg-green-50 transition duration-300 shadow-sm hover:shadow-md border border-gray-100">
                    <div class="bg-green-100 inline-flex p-4 rounded-full text-green-600 mb-4">
                        <i class="fas fa-puzzle-piece text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">Plugins</h3>
                    <p class="text-sm text-gray-500 mt-2">Tambahan fitur untuk website</p>
                </div>
            </a>
            <a href="{{ route('products.index') }}?category=app-template" class="group">
                <div class="bg-white p-6 rounded-lg text-center group-hover:bg-purple-50 transition duration-300 shadow-sm hover:shadow-md border border-gray-100">
                    <div class="bg-purple-100 inline-flex p-4 rounded-full text-purple-600 mb-4">
                        <i class="fas fa-mobile-alt text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">Mobile Apps</h3>
                    <p class="text-sm text-gray-500 mt-2">Aplikasi mobile siap guna</p>
                </div>
            </a>
            <a href="{{ route('products.index') }}?category=ui-kit" class="group">
                <div class="bg-white p-6 rounded-lg text-center group-hover:bg-yellow-50 transition duration-300 shadow-sm hover:shadow-md border border-gray-100">
                    <div class="bg-yellow-100 inline-flex p-4 rounded-full text-yellow-600 mb-4">
                        <i class="fas fa-paint-brush text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">UI Kits</h3>
                    <p class="text-sm text-gray-500 mt-2">Komponen UI untuk desainer</p>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Latest Products Section -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Produk Terbaru</h2>
            <p class="mt-4 text-lg text-gray-600">Update terbaru dari katalog produk kami</p>
        </div>
        
        @if($latestProducts->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($latestProducts as $product)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200 overflow-hidden h-full flex flex-col group product-card">
                <div class="relative overflow-hidden">
                    @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center">
                        <a href="{{ route('products.show', $product->slug) }}" class="text-white font-medium py-2 px-4 mb-4 rounded-md bg-blue-600 hover:bg-blue-700 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                            <i class="fas fa-eye mr-1"></i> Lihat Detail
                        </a>
                    </div>
                    @else
                    <div class="bg-gray-200 w-full h-52 flex items-center justify-center">
                        <span class="text-gray-400"><i class="fas fa-image fa-2x"></i></span>
                    </div>
                    @endif
                    
                    @if($product->discount > 0)
                    <div class="absolute top-0 right-0 bg-red-500 text-white px-3 py-1 m-2 rounded-md">
                        <span class="text-sm font-semibold">{{ $product->discount }}% OFF</span>
                    </div>
                    @endif
                    
                    @if($product->created_at->diffInDays(now()) < 7)
                    <div class="absolute top-0 left-0 bg-green-500 text-white px-3 py-1 m-2 rounded-md">
                        <span class="text-sm font-semibold">Baru</span>
                    </div>
                    @endif
                </div>
                <div class="p-5 flex-grow flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200 line-clamp-2">
                                <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-md ml-1 flex-shrink-0">{{ $product->category }}</span>
                        </div>
                        <p class="text-gray-600 mb-3 text-sm line-clamp-2">{{ $product->description }}</p>
                    </div>
                    <div class="mt-auto">
                        <div class="mb-2">
                            @if($product->discount > 0)
                            <span class="text-sm text-gray-500 line-through block">Rp {{ number_format($product->regular_price, 0, ',', '.') }}</span>
                            <div class="flex items-center">
                                <span class="text-xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="ml-2 bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full font-semibold">Hemat {{ $product->discount }}%</span>
                            </div>
                            @else
                            <span class="text-xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <div class="flex items-center">
                                <div class="flex text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if($i <= ($product->rating ?? 0))
                                        <i class="fas fa-star text-xs"></i>
                                        @elseif($i - 0.5 <= ($product->rating ?? 0))
                                        <i class="fas fa-star-half-alt text-xs"></i>
                                        @else
                                        <i class="far fa-star text-xs"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="ml-1 text-xs text-gray-600">({{ $product->reviews_count ?? 0 }})</span>
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center group">
                                Detail <i class="fas fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform duration-200"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center p-10 bg-gray-50 rounded-lg">
            <p class="text-gray-600">Produk terbaru belum tersedia</p>
        </div>
        @endif
    </div>
</div>

<!-- Features Section -->
<div class="py-16 bg-gradient-to-r from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900">Mengapa Memilih DapurKode?</h2>
            <p class="mt-4 text-lg text-gray-600">Kami berkomitmen untuk memberikan produk digital terbaik</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-lg shadow-md border-t-4 border-blue-500">
                <div class="text-blue-600 mb-4">
                    <i class="fas fa-shield-alt text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Keamanan Terjamin</h3>
                <p class="text-gray-600">Semua transaksi diproses secara aman melalui gateway pembayaran terpercaya dengan enkripsi data terbaik.</p>
            </div>
            
            <div class="bg-white p-8 rounded-lg shadow-md border-t-4 border-green-500">
                <div class="text-green-600 mb-4">
                    <i class="fas fa-headset text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Dukungan 24/7</h3>
                <p class="text-gray-600">Tim dukungan kami siap membantu Anda setiap saat. Kami berkomitmen memberikan solusi cepat untuk setiap pertanyaan.</p>
            </div>
            
            <div class="bg-white p-8 rounded-lg shadow-md border-t-4 border-purple-500">
                <div class="text-purple-600 mb-4">
                    <i class="fas fa-sync text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Update Berkala</h3>
                <p class="text-gray-600">Semua produk digital kami mendapatkan update gratis dan perbaikan berkelanjutan untuk menjaga kualitas terbaik.</p>
            </div>
        </div>
    </div>
</div>

<!-- Testimonials Section -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Apa Kata Pelanggan Kami</h2>
            <p class="mt-4 text-lg text-gray-600">Pengalaman nyata dari pengguna produk DapurKode</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 relative">
                <div class="absolute top-6 right-6 text-blue-200">
                    <i class="fas fa-quote-right text-4xl"></i>
                </div>
                <div class="flex items-center mb-4">
                    <div class="text-yellow-400 flex">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <p class="text-gray-600 mb-6 relative z-10">"Kualitas template dari DapurKode sangat luar biasa. Saya telah membeli beberapa produk dan semuanya melebihi ekspektasi saya. Dokumentasinya juga lengkap dan mudah dimengerti."</p>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold">BS</div>
                    <div class="ml-3">
                        <h4 class="font-semibold">Budi Santoso</h4>
                        <p class="text-sm text-gray-500">Web Developer</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 relative">
                <div class="absolute top-6 right-6 text-blue-200">
                    <i class="fas fa-quote-right text-4xl"></i>
                </div>
                <div class="flex items-center mb-4">
                    <div class="text-yellow-400 flex">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <p class="text-gray-600 mb-6 relative z-10">"Layanan dukungan pelanggan sangat mengesankan. Saya mengalami masalah dengan instalasi dan mereka membantu menyelesaikannya dalam waktu singkat. Sangat direkomendasikan!"</p>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-semibold">AS</div>
                    <div class="ml-3">
                        <h4 class="font-semibold">Anita Sari</h4>
                        <p class="text-sm text-gray-500">Pemilik Bisnis</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 relative">
                <div class="absolute top-6 right-6 text-blue-200">
                    <i class="fas fa-quote-right text-4xl"></i>
                </div>
                <div class="flex items-center mb-4">
                    <div class="text-yellow-400 flex">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
                <p class="text-gray-600 mb-6 relative z-10">"Plugin yang saya beli telah menghemat banyak waktu pengembangan. Kode bersih, terdokumentasi dengan baik, dan sangat mudah untuk disesuaikan dengan kebutuhan proyek saya."</p>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-semibold">RP</div>
                    <div class="ml-3">
                        <h4 class="font-semibold">Rudi Pratama</h4>
                        <p class="text-sm text-gray-500">Freelancer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold mb-6">Siap Untuk Memulai?</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">Bergabunglah dengan ribuan pelanggan puas yang mempercayai DapurKode untuk kebutuhan produk digital mereka.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('products.index') }}" class="bg-white text-blue-600 hover:bg-blue-50 px-8 py-4 rounded-md font-semibold transition duration-300 shadow-lg">
                    <i class="fas fa-search mr-2"></i> Jelajahi Produk
                </a>
                <a href="{{ route('register') }}" class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 px-8 py-4 rounded-md font-semibold transition duration-300 shadow-lg">
                    <i class="fas fa-user-plus mr-2"></i> Buat Akun
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Partners Section -->
<div class="py-16 bg-gray-50 border-y border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-semibold text-gray-800">Dipercaya oleh bisnis di seluruh Indonesia</h2>
            <p class="mt-2 text-gray-600">Bergabunglah dengan ratusan bisnis yang telah memilih DapurKode</p>
        </div>
        
        <div class="flex flex-wrap justify-center items-center gap-8 md:gap-12">
            <div class="w-28 md:w-32 grayscale hover:grayscale-0 transition duration-300 hover:transform hover:scale-110">
                <img src="{{ asset('storage/images/partners/partner-1.svg') }}?v={{ time() }}" alt="Partner 1" class="w-full h-auto" style="max-height: 80px;">
            </div>
            <div class="w-28 md:w-32 grayscale hover:grayscale-0 transition duration-300 hover:transform hover:scale-110">
                <img src="{{ asset('storage/images/partners/partner-2.svg') }}?v={{ time() }}" alt="Partner 2" class="w-full h-auto">
            </div>
            <div class="w-28 md:w-32 grayscale hover:grayscale-0 transition duration-300 hover:transform hover:scale-110">
                <img src="{{ asset('storage/images/partners/partner-3.svg') }}?v={{ time() }}" alt="Partner 3" class="w-full h-auto">
            </div>
            <div class="w-28 md:w-32 grayscale hover:grayscale-0 transition duration-300 hover:transform hover:scale-110">
                <img src="{{ asset('storage/images/partners/partner-4.svg') }}?v={{ time() }}" alt="Partner 4" class="w-full h-auto">
            </div>
            <div class="w-28 md:w-32 grayscale hover:grayscale-0 transition duration-300 hover:transform hover:scale-110">
                <img src="{{ asset('storage/images/partners/partner-5.svg') }}?v={{ time() }}" alt="Partner 5" class="w-full h-auto">
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .aspect-w-16 {
        position: relative;
        padding-bottom: 56.25%;
    }
    
    .aspect-w-16 > img {
        position: absolute;
        height: 100%;
        width: 100%;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        object-fit: cover;
        object-position: center;
    }
    
    /* Animation for product cards */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .product-card {
        animation: fadeIn 0.5s ease-in-out forwards;
    }
    
    /* Hover effects for product cards */
    .product-card .detail-btn {
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
    }
    
    .product-card:hover .detail-btn {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Additional animations */
    .hover-grow {
        transition: transform 0.3s ease;
    }
    
    .hover-grow:hover {
        transform: scale(1.03);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Back to Top button
        const backToTopButton = document.getElementById('backToTop');
        
        if (backToTopButton) {
            window.addEventListener('scroll', () => {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.add('opacity-100');
                    backToTopButton.classList.remove('opacity-0', 'invisible');
                } else {
                    backToTopButton.classList.add('opacity-0');
                    backToTopButton.classList.add('invisible');
                }
            });
            
            backToTopButton.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
        
        // Add animation delay to product cards for staggered appearance
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>
@endpush
