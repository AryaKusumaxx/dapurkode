@extends('layouts.guest.navigation')

@section('title', 'Katalog Produk Digital')

@section('content')
<!-- Products Header -->
<div class="bg-gradient-to-r from-blue-700 to-indigo-600 text-white border-b relative overflow-hidden">
    <div class="absolute right-0 top-0 w-1/3 h-full opacity-10">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none" class="h-full w-full">
            <defs>
                <linearGradient id="a" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:#ffffff;stop-opacity:0.2" />
                    <stop offset="100%" style="stop-color:#ffffff;stop-opacity:0.6" />
                </linearGradient>
            </defs>
            <polygon fill="url(#a)" points="0,0 100,0 100,100 0,50" />
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
        <h1 class="text-4xl font-bold text-white">Katalog Produk Digital</h1>
        <p class="mt-2 text-lg text-blue-100">Temukan berbagai produk digital berkualitas untuk kebutuhan bisnis Anda</p>
        
        <!-- Search Box -->
        <div class="mt-6 max-w-xl">
            <form action="{{ route('products.index') }}" method="GET">
                <div class="relative">
                    <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}" class="w-full pl-12 pr-4 py-3 bg-white bg-opacity-20 backdrop-blur-sm border border-white border-opacity-30 rounded-lg text-white placeholder-white placeholder-opacity-75 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50">
                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white opacity-75">
                        <i class="fas fa-search"></i>
                    </div>
                    <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white text-blue-700 px-4 py-1 rounded-md font-medium hover:bg-blue-50 transition-colors duration-200">
                        Cari
                    </button>
                </div>
                
                <!-- Hidden inputs for other filters that might be active -->
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
            </form>
        </div>
        
        <!-- Breadcrumb -->
        <nav class="flex mt-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ route('welcome') }}" class="text-blue-100 hover:text-white">Beranda</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 text-blue-200" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-2 text-white font-medium">Produk</span>
                </li>
            </ol>
        </nav>
    </div>
    
    <!-- Wave Decoration -->
    <div class="absolute bottom-0 w-full">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" fill="#ffffff">
            <path d="M0,64L80,53.3C160,43,320,21,480,32C640,43,800,85,960,90.7C1120,96,1280,64,1360,48L1440,32L1440,100L1360,100C1280,100,1120,100,960,100C800,100,640,100,480,100C320,100,160,100,80,100L0,100Z"></path>
        </svg>
    </div>
</div>

<!-- Filters and Products -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Filter Sidebar -->
        <div class="lg:w-1/4">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 sticky top-20">
                <h3 class="font-bold text-lg mb-4 text-gray-900">Filter</h3>
                
                <!-- Category Filter -->
                <div class="mb-6">
                    <h4 class="font-medium text-sm text-gray-700 uppercase mb-3">Kategori</h4>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <a href="{{ route('products.index', request()->except('category', 'page')) }}" 
                               class="text-gray-700 hover:text-blue-600 {{ !request('category') ? 'font-semibold text-blue-600' : '' }}">
                               Semua Kategori
                            </a>
                        </div>
                        
                        @foreach($categories as $category)
                        <div class="flex items-center">
                            <a href="{{ route('products.index', array_merge(request()->except('category', 'page'), ['category' => $category])) }}" 
                               class="text-gray-700 hover:text-blue-600 {{ request('category') == $category ? 'font-semibold text-blue-600' : '' }}">
                               {{ $category }}
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Price Filter -->
                <div class="mb-6">
                    <h4 class="font-medium text-sm text-gray-700 uppercase mb-3">Rentang Harga</h4>
                    <form action="{{ route('products.index') }}" method="GET" class="space-y-3">
                        <!-- Preserve other filters -->
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label for="min_price" class="text-xs text-gray-600">Min (Rp)</label>
                                <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm"
                                       placeholder="0">
                            </div>
                            <div>
                                <label for="max_price" class="text-xs text-gray-600">Max (Rp)</label>
                                <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm"
                                       placeholder="10000000">
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button type="submit" class="flex-1 py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition duration-200 text-sm font-medium">
                                Terapkan
                            </button>
                            <a href="{{ route('products.index') }}" class="py-2 px-4 border border-gray-300 hover:bg-gray-100 text-gray-700 rounded-md transition duration-200 text-sm font-medium text-center">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
                <div class="mb-6">
                    <h4 class="font-medium text-sm text-gray-700 uppercase mb-3">Harga</h4>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input type="radio" id="price-all" name="price" value="all" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="price-all" class="ml-2 text-gray-700">Semua Harga</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="price-1" name="price" value="0-100000" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="price-1" class="ml-2 text-gray-700">Rp 0 - Rp 100.000</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="price-2" name="price" value="100000-500000" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="price-2" class="ml-2 text-gray-700">Rp 100.000 - Rp 500.000</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="price-3" name="price" value="500000-1000000" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="price-3" class="ml-2 text-gray-700">Rp 500.000 - Rp 1.000.000</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="price-4" name="price" value="1000000-0" class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="price-4" class="ml-2 text-gray-700">> Rp 1.000.000</label>
                        </div>
                    </div>
                </div>
                
                <!-- Rating Filter -->
                <div>
                    <h4 class="font-medium text-sm text-gray-700 uppercase mb-3">Rating</h4>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input type="checkbox" id="rating-5" name="rating[]" value="5" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <label for="rating-5" class="ml-2 text-gray-700 flex items-center">
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="rating-4" name="rating[]" value="4" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <label for="rating-4" class="ml-2 text-gray-700 flex items-center">
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="text-gray-300">
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="ml-1 text-gray-600">& up</span>
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="rating-3" name="rating[]" value="3" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <label for="rating-3" class="ml-2 text-gray-700 flex items-center">
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="text-gray-300">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="ml-1 text-gray-600">& up</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Filter Buttons -->
                <div class="mt-8 space-y-2">
                    <button type="button" class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition-all duration-200 transform hover:-translate-y-1 hover:shadow-lg flex items-center justify-center">
                        <i class="fas fa-filter mr-2"></i> Terapkan Filter
                    </button>
                    <button type="button" class="w-full py-3 px-4 border border-gray-300 text-gray-700 hover:bg-gray-50 hover:text-blue-600 rounded-md font-medium transition-all duration-200 flex items-center justify-center hover:border-blue-400">
                        <i class="fas fa-sync-alt mr-2"></i> Reset Filter
                    </button>
                </div>
                
                <!-- Help Section -->
                <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-100">
                    <h4 class="flex items-center font-medium text-blue-800">
                        <i class="fas fa-info-circle mr-2"></i> Butuh Bantuan?
                    </h4>
                    <p class="mt-2 text-sm text-blue-700">
                        Hubungi tim kami untuk bantuan mencari produk yang sesuai dengan kebutuhan Anda.
                    </p>
                    <a href="#" class="mt-3 inline-block text-sm text-white bg-blue-600 px-3 py-2 rounded-md hover:bg-blue-700 transition-colors duration-200">
                        <i class="fas fa-headset mr-1"></i> Konsultasi Gratis
                    </a>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="lg:w-3/4" x-data="{ 
            viewMode: localStorage.getItem('productViewMode') || 'grid',
            setViewMode(mode) {
                this.viewMode = mode;
                localStorage.setItem('productViewMode', mode);
            }
        }"
            <!-- Sort and View Options -->
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 p-5 bg-white rounded-lg shadow-md border border-gray-100">
                <div class="mb-4 sm:mb-0 flex items-center">
                    <span class="text-gray-600 font-medium">Menampilkan {{ count($products) }} produk</span>
                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <svg class="animate-spin -ml-1 mr-2 h-3 w-3 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Terakhir diperbarui: Hari ini
                    </span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <label for="sort" class="text-gray-700 mr-2">Urutkan:</label>
                        <select id="sort" name="sort" class="border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 pr-8" onchange="window.location = this.value;">
                            <option value="{{ route('products.index', array_merge(request()->except('sort', 'page'), ['sort' => 'newest'])) }}" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>Terbaru</option>
                            <option value="{{ route('products.index', array_merge(request()->except('sort', 'page'), ['sort' => 'price_low'])) }}" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                            <option value="{{ route('products.index', array_merge(request()->except('sort', 'page'), ['sort' => 'price_high'])) }}" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                            <option value="{{ route('products.index', array_merge(request()->except('sort', 'page'), ['sort' => 'rating'])) }}" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                            <option value="{{ route('products.index', array_merge(request()->except('sort', 'page'), ['sort' => 'popularity'])) }}" {{ request('sort') == 'popularity' ? 'selected' : '' }}>Popularitas</option>
                        </select>
                    </div>
                    <div class="flex border border-gray-200 rounded-md">
                        <button type="button" 
                                @click="setViewMode('grid')" 
                                :class="{'bg-blue-50 text-blue-600': viewMode === 'grid'}"
                                class="p-2 text-gray-600 hover:text-blue-600 hover:bg-gray-100 rounded-l-md transition-colors duration-200">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button type="button" 
                                @click="setViewMode('list')"
                                :class="{'bg-blue-50 text-blue-600': viewMode === 'list'}"
                                class="p-2 text-gray-600 hover:text-blue-600 hover:bg-gray-100 rounded-r-md transition-colors duration-200">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products Grid/List View -->
            @if(count($products) > 0)
            <div x-show="viewMode === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
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
                                            @if($i <= $product->rating)
                                            <i class="fas fa-star text-xs"></i>
                                            @elseif($i - 0.5 <= $product->rating)
                                            <i class="fas fa-star-half-alt text-xs"></i>
                                            @else
                                            <i class="far fa-star text-xs"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-gray-600 text-xs">({{ $product->reviews_count ?? 0 }})</span>
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
            
            <!-- List View -->
            <div x-show="viewMode === 'list'" class="space-y-4">
                @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200 overflow-hidden group product-card">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/4 relative overflow-hidden">
                            @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-52 md:h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center">
                                <a href="{{ route('products.show', $product->slug) }}" class="text-white font-medium py-2 px-4 mb-4 rounded-md bg-blue-600 hover:bg-blue-700 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                    <i class="fas fa-eye mr-1"></i> Lihat Detail
                                </a>
                            </div>
                            @else
                            <div class="w-full h-52 md:h-full bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-4xl"></i>
                            </div>
                            @endif
                        </div>
                        <div class="md:w-3/4 p-5 flex flex-col">
                            <div class="flex flex-wrap justify-between items-start mb-2">
                                <h3 class="text-xl font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                </h3>
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-md ml-1 flex-shrink-0">{{ $product->category }}</span>
                            </div>
                            <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                            <div class="mt-auto flex flex-wrap justify-between items-end">
                                <div>
                                    @if($product->discount > 0)
                                    <span class="text-sm text-gray-500 line-through block">Rp {{ number_format($product->regular_price, 0, ',', '.') }}</span>
                                    <div class="flex items-center">
                                        <span class="text-xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="ml-2 bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full font-semibold">Hemat {{ $product->discount }}%</span>
                                    </div>
                                    @else
                                    <span class="text-xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @endif
                                    
                                    <div class="flex items-center mt-2">
                                        <div class="flex text-yellow-400">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if($i <= $product->rating)
                                                <i class="fas fa-star text-xs"></i>
                                                @elseif($i - 0.5 <= $product->rating)
                                                <i class="fas fa-star-half-alt text-xs"></i>
                                                @else
                                                <i class="far fa-star text-xs"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="ml-2 text-gray-600 text-xs">({{ $product->reviews_count ?? 0 }})</span>
                                    </div>
                                </div>
                                <a href="{{ route('products.show', $product->slug) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 inline-flex items-center mt-3 md:mt-0">
                                    Detail Produk <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-10">
                {{ $products->links() }}
            </div>
            @else
            <div class="text-center p-10 bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="text-gray-500 mb-4">
                    <i class="fas fa-search fa-3x"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada produk yang ditemukan</h3>
                <p class="text-gray-600">Coba ubah filter pencarian Anda atau lihat semua produk kami.</p>
                <div class="mt-6">
                    <a href="{{ route('products.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                        Lihat Semua Produk
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Back to Top Button -->
<button id="backToTop" class="fixed bottom-6 right-6 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-3 shadow-lg transform transition-transform hover:scale-110 opacity-0 invisible">
    <i class="fas fa-arrow-up"></i>
</button>

@endsection

@push('styles')
<style>
    /* Animation for product cards */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .product-card {
        animation: fadeIn 0.5s ease-in-out forwards;
    }
    
    /* Skeleton loading animation */
    @keyframes pulse {
        0% { background-position: -100% 0; }
        100% { background-position: 200% 0; }
    }
    
    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: pulse 1.5s infinite;
    }
    
    /* Smooth scroll behavior */
    html {
        scroll-behavior: smooth;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
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

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
