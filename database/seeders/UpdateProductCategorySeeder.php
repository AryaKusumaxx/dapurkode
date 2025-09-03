<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class UpdateProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Menambahkan kategori ke produk yang ada
     */
    public function run(): void
    {
        // Kategori yang tersedia
        $categories = [
            'Website',
            'Mobile App',
            'Desktop App',
            'E-Commerce',
            'CMS',
            'API'
        ];
        
        // Dapatkan semua produk
        $products = Product::all();
        
        foreach ($products as $product) {
            // Pilih kategori secara acak
            $randomCategory = $categories[array_rand($categories)];
            
            $product->category = $randomCategory;
            $product->save();
        }
        
        $this->command->info('Kategori berhasil ditambahkan ke ' . count($products) . ' produk.');
    }
}
