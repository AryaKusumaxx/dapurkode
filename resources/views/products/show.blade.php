@extends('layouts.guest.navigation')

@section('title', $product->name)

@section('content')
<!-- Product Detail Header -->
<div class="bg-gray-50 border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ route('welcome') }}" class="text-gray-500 hover:text-gray-700">Beranda</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('products.index') }}" class="ml-2 text-gray-500 hover:text-gray-700">Produk</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-2 text-gray-700 font-medium">{{ $product->name }}</span>
                </li>
            </ol>
        </nav>
    </div>
</div>

<!-- Product Detail Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="lg:grid lg:grid-cols-2 lg:gap-8">
        <!-- Product Images -->
        <div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                @if($product->image)
                <div class="relative">
                    <!-- Main Image -->
                    <div class="relative h-80 md:h-96">
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover"
                             >
                    </div>
                </div>
                @else
                <div class="h-80 md:h-96 flex items-center justify-center bg-gray-100">
                    <span class="text-gray-400"><i class="fas fa-image fa-4x"></i></span>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Product Info -->
        <div>
            <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
                <div class="mb-4">
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded mb-2">{{ $product->category }}</span>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                    <div class="flex items-center mt-2">
                        <div class="flex text-yellow-400">
                            @for ($i = 1; $i <= 5; $i++)
                                @if($i <= $product->rating)
                                <i class="fas fa-star"></i>
                                @elseif($i - 0.5 <= $product->rating)
                                <i class="fas fa-star-half-alt"></i>
                                @else
                                <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="ml-2 text-gray-600">{{ $product->rating }} ({{ $product->reviews_count }} ulasan)</span>
                    </div>
                </div>
                
                <div class="mb-6">
                    <div class="flex items-baseline mb-1">
                        @if($product->discount > 0)
                        <span class="text-gray-500 line-through text-lg">Rp {{ number_format($product->regular_price, 0, ',', '.') }}</span>
                        <span class="ml-2 bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $product->discount }}% OFF</span>
                        @endif
                    </div>
                    <div class="flex items-center">
                        <span class="text-3xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h2 class="font-semibold text-gray-900 mb-2">Deskripsi</h2>
                    <div class="text-gray-700 space-y-3">
                        {{ $product->description }}
                    </div>
                </div>
                
                @if($product->variants && is_countable($product->variants) && count($product->variants) > 0)
                <div class="mb-6">
                    <h2 class="font-semibold text-gray-900 mb-2">Varian Produk</h2>
                    <div class="grid grid-cols-3 gap-2" x-data="{ selectedVariant: '{{ $product->variants[0]->id ?? '' }}' }">
                        @foreach($product->variants as $variant)
                        <button 
                            @click="selectedVariant = '{{ $variant->id }}'" 
                            :class="{ 'ring-2 ring-blue-500': selectedVariant === '{{ $variant->id }}' }"
                            class="border border-gray-300 rounded-md py-2 px-4 flex items-center justify-between hover:bg-gray-50 focus:outline-none">
                            <span class="text-sm font-medium">{{ $variant->name }}</span>
                            <span class="text-sm text-gray-900">Rp {{ number_format($variant->price, 0, ',', '.') }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Warranty Options -->
                @if($product->warranty_prices && is_countable($product->warranty_prices) && count($product->warranty_prices) > 0)
                <div class="mb-6">
                    <h2 class="font-semibold text-gray-900 mb-2">Garansi (Opsional)</h2>
                    <div class="space-y-2" x-data="{ selectedWarranty: null }">
                        <div class="flex items-center">
                            <input 
                                id="warranty-none" 
                                name="warranty" 
                                type="radio" 
                                value="none"
                                checked
                                x-model="selectedWarranty"
                                class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="warranty-none" class="ml-2 text-sm text-gray-700">
                                Tanpa Garansi Tambahan
                            </label>
                        </div>
                        
                        @foreach($product->warranty_prices as $warranty)
                        <div class="flex items-center justify-between border border-gray-200 rounded-md p-3 hover:bg-gray-50">
                            <div class="flex items-center">
                                <input 
                                    id="warranty-{{ $warranty->id }}" 
                                    name="warranty" 
                                    type="radio" 
                                    value="{{ $warranty->id }}"
                                    x-model="selectedWarranty"
                                    class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <label for="warranty-{{ $warranty->id }}" class="ml-2">
                                    <span class="text-sm font-medium text-gray-900">{{ $warranty->duration }} Bulan</span>
                                    <p class="text-xs text-gray-600">Perpanjang garansi standar produk</p>
                                </label>
                            </div>
                            <span class="text-sm font-medium text-gray-900">Rp {{ number_format($warranty->price, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Beli Langsung Button -->
                <div class="mt-8">
                    <form action="{{ route('checkout') }}" method="GET">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <!-- Quantity telah dihapus dan ditetapkan sebagai 1 -->
                        <input type="hidden" id="quantity" name="quantity" value="1" />
                        </div>
                        
                        <button 
                            type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3.5 px-6 rounded-lg shadow-md hover:shadow-lg transition duration-200 flex items-center justify-center text-base">
                            <i class="fas fa-credit-card mr-2"></i>
                            Beli Sekarang
                        </button>
                    </form>
                </div>
                
                <!-- Shipping Info -->
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-shield-alt text-green-600 mt-0.5"></i>
                        <div>
                            <h4 class="font-medium text-gray-900">Produk Digital Resmi</h4>
                            <p class="text-sm text-gray-600">Semua produk di DapurKode dijamin asli dan berlisensi resmi</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 mt-4">
                        <i class="fas fa-download text-green-600 mt-0.5"></i>
                        <div>
                            <h4 class="font-medium text-gray-900">Akses Langsung</h4>
                            <p class="text-sm text-gray-600">Produk dapat diunduh langsung setelah pembayaran berhasil</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3 mt-4">
                        <i class="fas fa-headset text-green-600 mt-0.5"></i>
                        <div>
                            <h4 class="font-medium text-gray-900">Dukungan 24/7</h4>
                            <p class="text-sm text-gray-600">Dapatkan bantuan kapan saja dari tim dukungan kami</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Share Product -->
            <div class="mt-4 bg-white rounded-lg shadow-sm p-4 border border-gray-100">
                <h3 class="font-medium text-gray-900">Bagikan Produk</h3>
                <div class="flex space-x-2 mt-2">
                    <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="bg-blue-400 hover:bg-blue-500 text-white p-2 rounded-full">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="bg-pink-600 hover:bg-pink-700 text-white p-2 rounded-full">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="#" class="bg-blue-700 hover:bg-blue-800 text-white p-2 rounded-full">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Product Tabs -->
    <div class="mt-12 bg-white rounded-lg shadow-md border border-gray-200" x-data="{ activeTab: window.location.hash === '#reviews' ? 'reviews' : 'description' }" x-init="$watch('activeTab', value => { if (value) window.location.hash = value; })">
        <!-- Tab Navigation -->
        <div class="flex border-b border-gray-200 overflow-x-auto overflow-y-hidden">
            <button 
                @click="activeTab = 'description'" 
                :class="{ 'border-blue-600 text-blue-600': activeTab === 'description' }"
                class="px-6 py-4 text-sm font-medium border-b-2 border-transparent hover:text-blue-600 hover:border-blue-400 transition-colors duration-200 whitespace-nowrap">
                <i class="fas fa-info-circle mr-2"></i>Deskripsi Detail
            </button>
            <button 
                @click="activeTab = 'features'" 
                :class="{ 'border-blue-600 text-blue-600': activeTab === 'features' }"
                class="px-6 py-4 text-sm font-medium border-b-2 border-transparent hover:text-blue-600 hover:border-blue-400 transition-colors duration-200 whitespace-nowrap">
                <i class="fas fa-list-ul mr-2"></i>Fitur & Spesifikasi
            </button>
            <button 
                @click="activeTab = 'reviews'" 
                :class="{ 'border-blue-600 text-blue-600': activeTab === 'reviews' }"
                class="px-6 py-4 text-sm font-medium border-b-2 border-transparent hover:text-blue-600 hover:border-blue-400 transition-colors duration-200 focus:outline-none whitespace-nowrap">
                <i class="fas fa-star mr-2"></i>Ulasan ({{ $product->reviews_count }})
            </button>
            <button 
                @click="activeTab = 'faq'" 
                :class="{ 'border-blue-600 text-blue-600': activeTab === 'faq' }"
                class="px-6 py-4 text-sm font-medium border-b-2 border-transparent hover:text-blue-600 hover:border-blue-400 transition-colors duration-200 whitespace-nowrap">
                <i class="fas fa-question-circle mr-2"></i>FAQ
            </button>
        </div>
        
        <!-- Tab Content -->
        <div class="p-6">
            <!-- Description Tab -->
            <div x-show="activeTab === 'description'" class="prose p-6 md:p-8 lg:p-10 mx-auto max-w-4xl">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Deskripsi Produk</h3>
                <div class="mb-6 text-gray-700">{{ $product->description }}</div>
                
                @if($product->about_product)
                <h4 class="text-lg font-medium text-gray-800 mt-8 mb-3">Tentang Produk</h4>
                <div class="mb-6 text-gray-700">{!! $product->about_product !!}</div>
                @endif
                
                @if($product->advantages)
                <h4 class="text-lg font-medium text-gray-800 mt-8 mb-3">Keunggulan</h4>
                <div class="mb-6 text-gray-700">{!! $product->advantages !!}</div>
                @else
                <h4 class="text-lg font-medium text-gray-800 mt-8 mb-3">Keunggulan</h4>
                <ul class="list-disc pl-5 space-y-2 mb-6 text-gray-700">
                    @if(isset($product->highlights) && is_array($product->highlights))
                        @foreach($product->highlights as $highlight)
                        <li>{{ $highlight }}</li>
                        @endforeach
                    @else
                        <li>Produk berkualitas tinggi</li>
                        <li>Dukungan teknis selama 1 tahun</li>
                        <li>Update gratis</li>
                    @endif
                </ul>
                @endif
                
                @if($product->ideal_for)
                <h4 class="text-lg font-medium text-gray-800 mt-8 mb-3">Ideal Untuk</h4>
                <div class="mb-6 text-gray-700">{!! $product->ideal_for !!}</div>
                @endif
            </div>
            
            <!-- Features Tab -->
            <div x-show="activeTab === 'features'" class="space-y-6 p-6 md:p-8 lg:p-10 mx-auto max-w-4xl">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Fitur & Spesifikasi</h3>
                
                <div class="bg-gray-50 p-5 rounded-lg border border-gray-100">
                    <h4 class="font-medium text-gray-900 mb-4 border-b border-gray-200 pb-2">Spesifikasi Teknis</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        @if(isset($product->specifications) && is_array($product->specifications))
                            @foreach($product->specifications as $spec)
                            <div class="flex items-start">
                                <span class="text-blue-600 mr-3 mt-0.5"><i class="fas fa-check-circle"></i></span>
                            <div>
                                @if(is_object($spec))
                                    <span class="font-medium text-gray-900">{{ $spec->name }}:</span>
                                    <span class="text-gray-700">{{ $spec->value }}</span>
                                @else
                                    <span class="text-gray-700">{{ $spec }}</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="flex items-start">
                            <span class="text-blue-600 mr-2"><i class="fas fa-check-circle"></i></span>
                            <div>
                                <span class="font-medium text-gray-900">Versi:</span>
                                <span class="text-gray-700">1.0</span>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <span class="text-blue-600 mr-2"><i class="fas fa-check-circle"></i></span>
                            <div>
                                <span class="font-medium text-gray-900">Dukungan:</span>
                                <span class="text-gray-700">1 tahun</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Fitur Utama</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if(isset($product->features) && is_array($product->features))
                            @foreach($product->features as $feature)
                            <div class="flex items-start">
                                <span class="text-blue-600 mr-2"><i class="fas fa-star"></i></span>
                                <div>
                                    @if(is_object($feature))
                                        <span class="font-medium text-gray-900">{{ $feature->name }}:</span>
                                        <span class="text-gray-700">{{ $feature->description }}</span>
                                    @else
                                        <span class="text-gray-700">{{ $feature }}</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="flex items-start">
                                <span class="text-blue-600 mr-2"><i class="fas fa-star"></i></span>
                                <div>
                                    <span class="font-medium text-gray-900">Desain Responsif:</span>
                                    <span class="text-gray-700">Tampilan yang dapat diakses dari semua perangkat</span>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="text-blue-600 mr-2"><i class="fas fa-star"></i></span>
                                <div>
                                    <span class="font-medium text-gray-900">SEO Friendly:</span>
                                    <span class="text-gray-700">Dioptimalkan untuk mesin pencari</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Kebutuhan Sistem</h4>
                    <div class="space-y-2">
                        @if($product->system_requirements)
                            <div class="text-gray-700">{!! $product->system_requirements !!}</div>
                        @elseif(isset($product->system_requirements) && is_array($product->system_requirements))
                            @foreach($product->system_requirements as $req)
                            <div>
                                @if(is_object($req))
                                    <span class="font-medium text-gray-900">{{ $req->name }}:</span>
                                    <span class="text-gray-700">{{ $req->value }}</span>
                                @else
                                    <span class="text-gray-700">{{ $req }}</span>
                                @endif
                            </div>
                            @endforeach
                        @else
                            <div>
                                <span class="font-medium text-gray-900">PHP:</span>
                                <span class="text-gray-700">7.4 atau lebih tinggi</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-900">Database:</span>
                                <span class="text-gray-700">MySQL 5.7 atau lebih tinggi</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-900">Server:</span>
                                <span class="text-gray-700">Apache/Nginx</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Reviews Tab -->
            <div x-show="activeTab === 'reviews'" class="space-y-8 p-6 md:p-8 lg:p-10 mx-auto max-w-4xl">
                <!-- Review Summary -->
                <div class="flex flex-col md:flex-row items-start gap-8 bg-gray-50 rounded-lg p-6 md:p-8 border border-gray-100">
                    <div class="flex-shrink-0 bg-white p-6 md:p-8 rounded-lg text-center shadow-sm border border-gray-100 w-full md:w-auto">
                        <div class="text-5xl font-bold text-gray-900 mb-2">{{ number_format($product->rating, 1) }}</div>
                        <div class="flex text-yellow-400 justify-center mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                @if($i <= $product->rating)
                                <i class="fas fa-star"></i>
                                @elseif($i - 0.5 <= $product->rating)
                                <i class="fas fa-star-half-alt"></i>
                                @else
                                <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <div class="text-sm text-gray-600">{{ $product->reviews_count }} ulasan</div>
                    </div>
                    
                    <div class="flex-grow">
                        <h4 class="font-medium text-gray-900 mb-3">Distribusi Rating</h4>
                        @for($i = 5; $i >= 1; $i--)
                        <div class="flex items-center mt-1">
                            <span class="text-sm w-8 text-gray-600">{{ $i }} <i class="fas fa-star text-yellow-400"></i></span>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 ml-2">
                                <div class="bg-yellow-400 h-2.5 rounded-full" style="width: {{ isset($product->rating_distribution[$i]) ? $product->rating_distribution[$i] : 0 }}%"></div>
                            </div>
                            <span class="text-sm text-gray-600 w-8 ml-2">{{ isset($product->rating_distribution[$i]) ? $product->rating_distribution[$i] : 0 }}%</span>
                        </div>
                        @endfor
                    </div>
                </div>
                
                <!-- Review List -->
                <div class="mt-8 bg-white rounded-lg p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-6">Ulasan Pembeli</h4>
                    
                    @if(isset($product->reviews) && is_countable($product->reviews) && count($product->reviews) > 0)
                    <div class="space-y-8">
                        @foreach($product->reviews as $review)
                        <div class="border-b border-gray-200 pb-8 mb-2">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center">
                                    <div class="mr-4">
                                        <img src="{{ $review->user->avatar ?? asset('images/default-avatar.png') }}" alt="User Avatar" class="w-10 h-10 rounded-full">
                                    </div>
                                    <div>
                                        <h5 class="font-medium text-gray-900">{{ $review->user->name }}</h5>
                                        <div class="flex text-yellow-400 mt-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                <i class="fas fa-star"></i>
                                                @else
                                                <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-600">{{ $review->created_at->format('d M Y') }}</div>
                            </div>
                            <div class="mt-4">
                                <h6 class="font-medium text-gray-900 mb-1">{{ $review->title }}</h6>
                                <p class="text-gray-700">{{ $review->content }}</p>
                            </div>
                            @if($review->images && is_array($review->images) && count($review->images) > 0)
                            <div class="mt-4 flex space-x-2">
                                @foreach($review->images as $image)
                                <div class="w-20 h-20 rounded-md overflow-hidden">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Review Image" class="w-full h-full object-cover">
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        @if(method_exists($product->reviews, 'links'))
                            {{ $product->reviews->links() }}
                        @endif
                    </div>
                    @else
                    <div class="text-center py-16 px-8 bg-gray-50 rounded-lg shadow-sm border border-gray-100 mx-auto max-w-2xl">
                        <i class="far fa-comments text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-700 text-xl font-medium mb-2">Belum ada ulasan untuk produk ini.</p>
                        <p class="mb-8 text-gray-500">Jadilah yang pertama memberikan ulasan!</p>
                        <a href="{{ route('products.show', ['slug' => $product->slug]) }}#write-review" 
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-pen-alt mr-2"></i> Tulis Ulasan Pertama
                        </a>
                    </div>
                    @endif
                    
                    <!-- Write Review Button -->
                    <div class="mt-8">
                        <a href="{{ route('products.show', ['slug' => $product->slug]) }}#write-review" 
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-pen-alt mr-2"></i> Tulis Ulasan
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- FAQ Tab -->
            <div x-show="activeTab === 'faq'" class="space-y-6 p-6 md:p-8 lg:p-10 mx-auto max-w-4xl">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Pertanyaan yang Sering Diajukan</h3>
                
                <div class="space-y-4">
                    @if(isset($product->faqs) && is_array($product->faqs))
                        @foreach($product->faqs as $index => $faq)
                        <div x-data="{ open: false }" class="border border-gray-200 rounded-lg shadow-sm">
                        <button 
                            @click="open = !open" 
                            class="flex justify-between items-center w-full px-5 py-4 text-left font-medium text-gray-900 focus:outline-none hover:bg-gray-50 transition-colors duration-200">
                            <span>{{ $faq->question }}</span>
                            <i class="fas text-blue-600" :class="{ 'fa-chevron-up': open, 'fa-chevron-down': !open }"></i>
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
                            <p class="text-gray-700">{{ $faq->answer }}</p>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                        <button 
                            @click="open = !open" 
                            class="flex items-center justify-between w-full px-4 py-3 text-left">
                            <span class="font-medium text-gray-900">Berapa lama waktu pengiriman produk digital?</span>
                            <svg class="w-5 h-5 transform transition-transform duration-200" :class="{ 'rotate-180': open }" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
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
                            <p class="text-gray-700">Produk digital akan tersedia untuk diunduh segera setelah pembayaran dikonfirmasi.</p>
                        </div>
                    </div>
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                        <button 
                            @click="open = !open" 
                            class="flex items-center justify-between w-full px-4 py-3 text-left">
                            <span class="font-medium text-gray-900">Apakah produk ini bisa digunakan untuk proyek komersial?</span>
                            <svg class="w-5 h-5 transform transition-transform duration-200" :class="{ 'rotate-180': open }" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
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
                            <p class="text-gray-700">Ya, produk ini dapat digunakan untuk proyek komersial sesuai dengan ketentuan lisensi yang berlaku.</p>
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="bg-blue-50 p-5 rounded-lg mt-8 border border-blue-100">
                    <p class="text-gray-700"><i class="fas fa-info-circle text-blue-600 mr-2"></i>Tidak menemukan jawaban yang Anda cari? <a href="{{ route('contact') }}" class="text-blue-600 font-medium hover:text-blue-800 hover:underline">Hubungi kami</a> atau kunjungi <a href="{{ route('faq') }}" class="text-blue-600 font-medium hover:text-blue-800 hover:underline">halaman FAQ</a> untuk informasi lebih lanjut.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    <div class="mt-16 px-6 md:px-10 lg:px-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Produk Terkait</h2>
        
        @if(count($relatedProducts) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 max-w-6xl mx-auto">
            @foreach($relatedProducts as $related)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200 overflow-hidden h-full flex flex-col group product-card">
                <div class="relative overflow-hidden">
                    @if($related->image)
                    <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center">
                        <a href="{{ route('products.show', $related->slug) }}" class="text-white font-medium py-2 px-4 mb-4 rounded-md bg-blue-600 hover:bg-blue-700 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                            <i class="fas fa-eye mr-1"></i> Lihat Detail
                        </a>
                    </div>
                    @else
                    <div class="bg-gray-200 w-full h-52 flex items-center justify-center">
                        <span class="text-gray-400"><i class="fas fa-image fa-2x"></i></span>
                    </div>
                    @endif
                    
                    @if($related->discount > 0)
                    <div class="absolute top-0 right-0 bg-red-500 text-white px-3 py-1 m-2 rounded-md">
                        <span class="text-sm font-semibold">{{ $related->discount }}% OFF</span>
                    </div>
                    @endif
                    
                    @if($related->created_at->diffInDays(now()) < 7)
                    <div class="absolute top-0 left-0 bg-green-500 text-white px-3 py-1 m-2 rounded-md">
                        <span class="text-sm font-semibold">Baru</span>
                    </div>
                    @endif
                </div>
                <div class="p-5 flex-grow flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200 line-clamp-2">
                                <a href="{{ route('products.show', $related->slug) }}">{{ $related->name }}</a>
                            </h3>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-md ml-1 flex-shrink-0">{{ $related->category }}</span>
                        </div>
                        <p class="text-gray-600 mb-3 text-sm line-clamp-2">{{ $related->description }}</p>
                    </div>
                    <div class="mt-auto">
                        <div class="mb-2">
                            @if($related->discount > 0)
                            <span class="text-sm text-gray-500 line-through block">Rp {{ number_format($related->regular_price, 0, ',', '.') }}</span>
                            <div class="flex items-center">
                                <span class="text-xl font-bold text-gray-900">Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                                <span class="ml-2 bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full font-semibold">Hemat {{ $related->discount }}%</span>
                            </div>
                            @else
                            <span class="text-xl font-bold text-gray-900">Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <div class="flex items-center">
                                <div class="flex text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if($i <= ($related->rating ?? 0))
                                        <i class="fas fa-star text-xs"></i>
                                        @elseif($i - 0.5 <= ($related->rating ?? 0))
                                        <i class="fas fa-star-half-alt text-xs"></i>
                                        @else
                                        <i class="far fa-star text-xs"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="ml-1 text-xs text-gray-600">({{ $related->reviews_count ?? 0 }})</span>
                            </div>
                            <a href="{{ route('products.show', $related->slug) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center group">
                                Detail <i class="fas fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform duration-200"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center p-10 bg-gray-50 rounded-lg max-w-6xl mx-auto">
            <div class="text-gray-500 mb-4">
                <i class="fas fa-exclamation-circle fa-3x"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Upss, tidak ada produk terkait yang dapat ditampilkan</h3>
            <p class="text-gray-600 mt-2">Silahkan cek produk lainnya di halaman produk</p>
            <div class="mt-6">
                <a href="{{ route('products.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                    Lihat Semua Produk
                </a>
            </div>
        </div>
        @endif
    </div>
    
    <!-- Recently Viewed -->
    <div class="mt-16 px-6 md:px-10 lg:px-12 mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Baru Dilihat</h2>
        
        @if(isset($recentlyViewed) && $recentlyViewed->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 max-w-6xl mx-auto">
            @foreach($recentlyViewed as $recent)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200 overflow-hidden h-full flex flex-col group product-card">
                <div class="relative overflow-hidden">
                    @if($recent->image)
                    <img src="{{ asset('storage/' . $recent->image) }}" alt="{{ $recent->name }}" class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center">
                        <a href="{{ route('products.show', $recent->slug) }}" class="text-white font-medium py-2 px-4 mb-4 rounded-md bg-blue-600 hover:bg-blue-700 opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                            <i class="fas fa-eye mr-1"></i> Lihat Detail
                        </a>
                    </div>
                    @else
                    <div class="bg-gray-200 w-full h-52 flex items-center justify-center">
                        <span class="text-gray-400"><i class="fas fa-image fa-2x"></i></span>
                    </div>
                    @endif
                    
                    @if(isset($recent->discount) && $recent->discount > 0)
                    <div class="absolute top-0 right-0 bg-red-500 text-white px-3 py-1 m-2 rounded-md">
                        <span class="text-sm font-semibold">{{ $recent->discount }}% OFF</span>
                    </div>
                    @endif
                    
                    @if($recent->created_at->diffInDays(now()) < 7)
                    <div class="absolute top-0 left-0 bg-green-500 text-white px-3 py-1 m-2 rounded-md">
                        <span class="text-sm font-semibold">Baru</span>
                    </div>
                    @endif
                </div>
                <div class="p-5 flex-grow flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200 line-clamp-2">
                                <a href="{{ route('products.show', $recent->slug) }}">{{ $recent->name }}</a>
                            </h3>
                            @if(isset($recent->category))
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-md ml-1 flex-shrink-0">{{ $recent->category }}</span>
                            @endif
                        </div>
                        <p class="text-gray-600 mb-3 text-sm line-clamp-2">{{ $recent->description }}</p>
                    </div>
                    <div class="mt-auto">
                        <div class="mb-2">
                            @if(isset($recent->discount) && $recent->discount > 0 && isset($recent->regular_price))
                            <span class="text-sm text-gray-500 line-through block">Rp {{ number_format($recent->regular_price, 0, ',', '.') }}</span>
                            <div class="flex items-center">
                                <span class="text-xl font-bold text-gray-900">Rp {{ number_format($recent->price, 0, ',', '.') }}</span>
                                <span class="ml-2 bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full font-semibold">Hemat {{ $recent->discount }}%</span>
                            </div>
                            @else
                            <span class="text-xl font-bold text-gray-900">Rp {{ number_format($recent->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <div class="flex items-center">
                                <div class="flex text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if($i <= ($recent->rating ?? 0))
                                        <i class="fas fa-star text-xs"></i>
                                        @elseif($i - 0.5 <= ($recent->rating ?? 0))
                                        <i class="fas fa-star-half-alt text-xs"></i>
                                        @else
                                        <i class="far fa-star text-xs"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="ml-1 text-xs text-gray-600">({{ $recent->reviews_count ?? 0 }})</span>
                            </div>
                            <a href="{{ route('products.show', $recent->slug) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center group">
                                Detail <i class="fas fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform duration-200"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center p-10 bg-gray-50 rounded-lg max-w-6xl mx-auto">
            <div class="text-gray-500 mb-4">
                <i class="fas fa-history fa-3x"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Upss, belum ada produk yang baru dilihat</h3>
            <p class="text-gray-600 mt-2">Jelajahi lebih banyak produk untuk melihat riwayat</p>
            <div class="mt-6">
                <a href="{{ route('products.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                    Jelajahi Produk
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Line clamp for text truncation */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Animation for product cards */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .product-card {
        animation: fadeIn 0.5s ease-in-out forwards;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add animation delay to product cards for staggered appearance
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>
@endpush

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        // Your Alpine.js code for product detail page
    });
</script>
@endpush
