<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="DapurKode - Solusi Digital untuk Kebutuhan Website dan Aplikasi Anda">
        <meta name="author" content="DapurKode">

        <title>{{ config('app.name', 'DapurKode') }} - @yield('title', 'Digital Solutions')</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:100,200,300,400,500,600,700,800,900|nunito:400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Additional Styles -->
        @stack('styles')
    </head>
    <body class="font-nunito antialiased text-gray-800 bg-gray-50">
        <div x-data="{ mobileMenuOpen: false }" class="min-h-screen flex flex-col">
            <!-- Flash Messages -->
            @if(session('success') || session('error') || session('info') || session('warning'))
                <div class="fixed top-4 right-4 z-50">
                    @if(session('success'))
                        <div x-data="{ show: true }" 
                             x-init="setTimeout(() => show = false, 5000)" 
                             x-show="show" 
                             x-transition
                             class="bg-green-50 text-green-800 border-l-4 border-green-500 p-4 mb-3 shadow-md rounded-r">
                            <div class="flex items-center">
                                <i class="fa-solid fa-circle-check text-green-500 mr-2"></i>
                                <span>{{ session('success') }}</span>
                                <button @click="show = false" class="ml-auto text-green-500 hover:text-green-700">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div x-data="{ show: true }" 
                             x-init="setTimeout(() => show = false, 5000)" 
                             x-show="show" 
                             x-transition
                             class="bg-red-50 text-red-800 border-l-4 border-red-500 p-4 mb-3 shadow-md rounded-r">
                            <div class="flex items-center">
                                <i class="fa-solid fa-circle-xmark text-red-500 mr-2"></i>
                                <span>{{ session('error') }}</span>
                                <button @click="show = false" class="ml-auto text-red-500 hover:text-red-700">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                    
                    @if(session('info'))
                        <div x-data="{ show: true }" 
                             x-init="setTimeout(() => show = false, 5000)" 
                             x-show="show" 
                             x-transition
                             class="bg-blue-50 text-blue-800 border-l-4 border-blue-500 p-4 mb-3 shadow-md rounded-r">
                            <div class="flex items-center">
                                <i class="fa-solid fa-circle-info text-blue-500 mr-2"></i>
                                <span>{{ session('info') }}</span>
                                <button @click="show = false" class="ml-auto text-blue-500 hover:text-blue-700">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                    
                    @if(session('warning'))
                        <div x-data="{ show: true }" 
                             x-init="setTimeout(() => show = false, 5000)" 
                             x-show="show" 
                             x-transition
                             class="bg-yellow-50 text-yellow-800 border-l-4 border-yellow-500 p-4 mb-3 shadow-md rounded-r">
                            <div class="flex items-center">
                                <i class="fa-solid fa-triangle-exclamation text-yellow-500 mr-2"></i>
                                <span>{{ session('warning') }}</span>
                                <button @click="show = false" class="ml-auto text-yellow-500 hover:text-yellow-700">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Navigation -->
            @yield('navigation')

            <!-- Page Header -->
            @hasSection('header')
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        @yield('header')
                    </div>
                </header>
            @elseif(isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-grow">
                @yield('content')
                {{ $slot ?? '' }}
            </main>

            <!-- Footer -->
            @yield('footer', View::make('components.footer'))
            
            <!-- WhatsApp Floating Button -->
            @include('components.whatsapp-button')
        </div>
        
        <!-- Additional Scripts -->
        @stack('scripts')
        @yield('scripts')
    </body>
</html>
