<footer class="bg-gray-800 text-gray-200">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo and About -->
            <div class="col-span-1 md:col-span-1">
                <img src="{{ asset('storage/images/dapurkode.png') }}" alt="DapurKode" class="h-10 w-auto mb-4">
                <p class="text-sm text-gray-400 mt-2">
                    DapurKode menyediakan produk digital berkualitas tinggi untuk kebutuhan bisnis dan pengembangan web Anda.
                </p>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-white font-semibold mb-4">Tautan Cepat</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('welcome') }}" class="text-gray-400 hover:text-white">Beranda</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white">Produk</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white">Tentang Kami</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white">Kontak</a></li>
                    <li><a href="{{ route('faq') }}" class="text-gray-400 hover:text-white">FAQ</a></li>
                </ul>
            </div>

            <!-- Categories -->
            <div>
                <h3 class="text-white font-semibold mb-4">Kategori</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('products.index') }}?category=web-template" class="text-gray-400 hover:text-white">Web Templates</a></li>
                    <li><a href="{{ route('products.index') }}?category=plugin" class="text-gray-400 hover:text-white">Plugins</a></li>
                    <li><a href="{{ route('products.index') }}?category=app-template" class="text-gray-400 hover:text-white">Mobile Apps</a></li>
                    <li><a href="{{ route('products.index') }}?category=ui-kit" class="text-gray-400 hover:text-white">UI Kits</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-white font-semibold mb-4">Kontak Kami</h3>
                <ul class="space-y-2">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-2 text-gray-400"></i>
                        <span class="text-gray-400">Jl. Raya Gawok No 2, Pandeyan, RT.02/RW.07, Purbayan, Kabupaten Sukoharjo, Jawa Tengah 57556</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone-alt mr-2 text-gray-400"></i>
                        <span class="text-gray-400">+62 812 3456 7890</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-2 text-gray-400"></i>
                        <span class="text-gray-400">info@dapurkode.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-sm text-gray-400">
                    &copy; {{ date('Y') }} DapurKode. All rights reserved.
                </div>
                <div class="mt-4 md:mt-0">
                    <ul class="flex space-x-6 text-sm">
                        <li><a href="{{ route('terms-of-service') }}" class="text-gray-400 hover:text-white">Syarat & Ketentuan</a></li>
                        <li><a href="{{ route('privacy-policy') }}" class="text-gray-400 hover:text-white">Kebijakan Privasi</a></li>
                        <li><a href="{{ route('faq') }}" class="text-gray-400 hover:text-white">Bantuan</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
