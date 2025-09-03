@extends('layouts.admin.app')

@section('title', 'Tambah Produk')

@section('header', 'Tambah Produk Baru')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6">
                    <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Produk
                    </a>
                </div>
                
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informasi Dasar -->
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h2>
                            
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                @error('name')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                @error('slug')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                                <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('description') }}</textarea>
                                <p class="text-sm text-gray-500 mt-1">Deskripsi singkat untuk ringkasan produk</p>
                                @error('description')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="about_product" class="block text-sm font-medium text-gray-700">Tentang Produk</label>
                                <textarea 
                                    name="about_product_original" 
                                    id="about_product" 
                                    class="ckeditor-field mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                >{{ old('about_product') }}</textarea>
                                <p class="text-sm text-gray-500 mt-1">Jelaskan secara detail mengenai produk ini</p>
                                @error('about_product')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="advantages" class="block text-sm font-medium text-gray-700">Keunggulan</label>
                                <textarea 
                                    name="advantages_original" 
                                    id="advantages" 
                                    class="ckeditor-field mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                >{{ old('advantages') }}</textarea>
                                <p class="text-sm text-gray-500 mt-1">Jelaskan keunggulan dari produk ini</p>
                                @error('advantages')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="ideal_for" class="block text-sm font-medium text-gray-700">Ideal Untuk</label>
                                <textarea 
                                    name="ideal_for_original" 
                                    id="ideal_for" 
                                    class="ckeditor-field mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                >{{ old('ideal_for') }}</textarea>
                                <p class="text-sm text-gray-500 mt-1">Jelaskan untuk siapa produk ini ideal digunakan</p>
                                @error('ideal_for')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                                <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    <option value="Desktop App" {{ old('category') == 'Desktop App' ? 'selected' : '' }}>Desktop App</option>
                                    <option value="Website" {{ old('category') == 'Website' ? 'selected' : '' }}>Website</option>
                                    <option value="Plugin" {{ old('category') == 'Plugin' ? 'selected' : '' }}>Plugin</option>
                                    <option value="Web Template" {{ old('category') == 'Web Template' ? 'selected' : '' }}>Web Template</option>
                                    <option value="Mobile App" {{ old('category') == 'Mobile App' ? 'selected' : '' }}>Mobile App</option>
                                    <option value="UI Kit" {{ old('category') == 'UI Kit' ? 'selected' : '' }}>UI Kit</option>
                                    <option value="API" {{ old('category') == 'API' ? 'selected' : '' }}>API</option>
                                    <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('category')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="features" class="block text-sm font-medium text-gray-700">Fitur Produk</label>
                                <textarea name="features" id="features" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('features') }}</textarea>
                                <p class="text-sm text-gray-500 mt-1">Pisahkan setiap fitur dengan baris baru</p>
                                @error('features')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="specifications" class="block text-sm font-medium text-gray-700">Spesifikasi</label>
                                <textarea name="specifications" id="specifications" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('specifications') }}</textarea>
                                <p class="text-sm text-gray-500 mt-1">Pisahkan setiap spesifikasi dengan baris baru</p>
                                @error('specifications')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="system_requirements" class="block text-sm font-medium text-gray-700">Kebutuhan Sistem</label>
                                <textarea 
                                    name="system_requirements_original" 
                                    id="system_requirements" 
                                    class="ckeditor-field mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                >{{ old('system_requirements') }}</textarea>
                                <p class="text-sm text-gray-500 mt-1">Jelaskan kebutuhan sistem untuk produk ini (PHP, database, dll)</p>
                                @error('system_requirements')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Harga & Gambar -->
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Harga & Gambar</h2>
                            
                            <div class="mb-4">
                                <label for="type" class="block text-sm font-medium text-gray-700">Tipe Produk</label>
                                <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="paket" {{ old('type') === 'paket' ? 'selected' : '' }}>Paket</option>
                                    <option value="jasa_pasang" {{ old('type') === 'jasa_pasang' ? 'selected' : '' }}>Jasa Pasang</option>
                                    <option value="lepas" {{ old('type') === 'lepas' ? 'selected' : '' }}>Lepasan</option>
                                </select>
                                @error('type')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="base_price" class="block text-sm font-medium text-gray-700">Harga Dasar (Rp)</label>
                                <input type="number" name="base_price" id="base_price" value="{{ old('base_price') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                @error('base_price')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="discount_price" class="block text-sm font-medium text-gray-700">Harga Diskon (Rp)</label>
                                <input type="number" name="discount_price" id="discount_price" value="{{ old('discount_price') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <p class="text-sm text-gray-500 mt-1">Biarkan kosong jika tidak ada diskon</p>
                                @error('discount_price')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="image" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
                                <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                                @error('image')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="is_featured" class="inline-flex items-center mt-3">
                                    <input id="is_featured" name="is_featured" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ old('is_featured') ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">Tampilkan di halaman utama</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-md mt-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Status & SEO</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publikasikan</option>
                                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Arsip</option>
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="warranty_months" class="block text-sm font-medium text-gray-700">Masa Garansi (bulan)</label>
                                    <input type="number" name="warranty_months" id="warranty_months" value="{{ old('warranty_months', 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <p class="text-sm text-gray-500 mt-1">0 berarti tidak ada garansi</p>
                                    @error('warranty_months')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="has_warranty" class="inline-flex items-center mt-3">
                                        <input id="has_warranty" name="has_warranty" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ old('has_warranty') ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-600">Memiliki Garansi</span>
                                    </label>
                                </div>
                            </div>
                            
                            <div>
                                <div class="mb-4">
                                    <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta Title</label>
                                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                                
                                <div class="mb-4">
                                    <label for="meta_description" class="block text-sm font-medium text-gray-700">Meta Description</label>
                                    <textarea name="meta_description" id="meta_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('meta_description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .ck-editor__editable {
        min-height: 250px;
    }
</style>
@endpush

@push('scripts')
<!-- CKEditor CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script src="{{ asset('js/ckeditor-handler.js') }}"></script>
@endpush
