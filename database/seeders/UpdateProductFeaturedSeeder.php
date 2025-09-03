<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class UpdateProductFeaturedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Menandai beberapa produk sebagai featured
     */
    public function run(): void
    {
        // Mendapatkan 6 produk pertama dan menandainya sebagai featured
        $products = Product::take(6)->get();
        
        foreach ($products as $product) {
            $product->is_featured = true;
            $product->save();
        }
        
        $this->command->info('6 produk berhasil ditandai sebagai featured.');
    }
}
