@extends('layouts.guest.navigation')

@section('title', 'Profil Pengguna')

@section('content')
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold">Profil Pengguna</h1>
        <p class="mt-2">Kelola informasi profil Anda</p>
    </div>
</div>

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
                    <a href="{{ route('user.dashboard') }}" class="ml-2 text-gray-500 hover:text-gray-700">Dashboard</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-2 text-gray-700 font-medium">Profil</span>
                </li>
            </ol>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 sticky top-6">
                <nav class="space-y-2">
                    <a href="{{ route('user.profile') }}" class="block px-4 py-2 rounded-md text-blue-600 bg-blue-50 font-medium border-l-4 border-blue-600">
                        <i class="fas fa-user-circle mr-2"></i>Informasi Profil
                    </a>
                    <a href="{{ route('user.password.form') }}" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-gray-50 font-medium hover:text-gray-900">
                        <i class="fas fa-lock mr-2"></i>Ubah Password
                    </a>
                    <a href="{{ route('user.orders') }}" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-gray-50 font-medium hover:text-gray-900">
                        <i class="fas fa-shopping-bag mr-2"></i>Daftar Pesanan
                    </a>
                    <a href="{{ route('user.invoices') }}" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-gray-50 font-medium hover:text-gray-900">
                        <i class="fas fa-file-invoice mr-2"></i>Faktur
                    </a>
                    <a href="{{ route('user.warranties') }}" class="block px-4 py-2 rounded-md text-gray-700 hover:bg-gray-50 font-medium hover:text-gray-900">
                        <i class="fas fa-shield-alt mr-2"></i>Garansi
                    </a>
                </nav>
            </div>
        </div>
        
        <div class="md:col-span-2 mt-8 md:mt-0">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                <h2 class="text-lg font-medium text-gray-900 mb-6">Informasi Profil</h2>
                
                @if(session('success'))
                <div class="bg-green-50 text-green-800 p-4 mb-6 rounded-md">
                    {{ session('success') }}
                </div>
                @endif
                
                <form method="POST" action="{{ route('user.profile.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea name="address" id="address" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('address', auth()->user()->address) }}</textarea>
                        @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md shadow-sm transition duration-200">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 mt-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Lainnya</h2>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-medium">Hapus Akun</h3>
                        <p class="text-sm text-gray-600">Hapus akun dan semua data terkait secara permanen</p>
                    </div>
                    <button class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md shadow-sm transition duration-200">
                        Hapus Akun
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
