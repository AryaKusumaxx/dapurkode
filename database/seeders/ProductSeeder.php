<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductWarrantyPrice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Product 1: E-Commerce Website (Paket)
        $product1 = Product::create([
            'name' => 'E-Commerce Website',
            'slug' => 'e-commerce-website',
            'description' => 'Website e-commerce lengkap dengan sistem admin, pembayaran, dan pengiriman.',
            'type' => 'paket',
            'base_price' => 5000000,
            'has_warranty' => true,
            'warranty_months' => 6,
            'image' => 'products/ecommerce.jpg',
            'is_active' => true,
            'features' => [
                'Admin Dashboard',
                'Katalog Produk',
                'Keranjang Belanja',
                'Sistem Pembayaran',
                'Integrasi Pengiriman',
                'Laporan Penjualan',
            ],
            'specifications' => [
                'framework' => 'Laravel',
                'database' => 'MySQL',
                'frontend' => 'Bootstrap 5',
                'responsive' => true,
                'hosting' => 'Tidak termasuk',
                'domain' => 'Tidak termasuk',
            ],
        ]);

        // Product 1 Variants
        ProductVariant::create([
            'product_id' => $product1->id,
            'name' => 'Basic',
            'sku' => 'ECM-BASIC-' . Str::random(5),
            'price' => 5000000,
            'stock' => null,
            'options' => [
                'pages' => 'Hingga 10 halaman',
                'products' => 'Hingga 100 produk',
                'payment' => 'Bank Transfer',
                'support' => '1 bulan',
            ],
            'is_active' => true,
        ]);

        ProductVariant::create([
            'product_id' => $product1->id,
            'name' => 'Professional',
            'sku' => 'ECM-PRO-' . Str::random(5),
            'price' => 8000000,
            'stock' => null,
            'options' => [
                'pages' => 'Unlimited',
                'products' => 'Unlimited',
                'payment' => 'Bank Transfer, Midtrans',
                'support' => '3 bulan',
            ],
            'is_active' => true,
        ]);

        // Product 1 Warranty Prices
        ProductWarrantyPrice::create([
            'product_id' => $product1->id,
            'months' => 6,
            'price' => 1500000,
            'is_active' => true,
        ]);

        ProductWarrantyPrice::create([
            'product_id' => $product1->id,
            'months' => 12,
            'price' => 2500000,
            'is_active' => true,
        ]);

        // Product 2: Company Profile (Jasa Pasang)
        $product2 = Product::create([
            'name' => 'Company Profile Website',
            'slug' => 'company-profile-website',
            'description' => 'Website company profile profesional untuk meningkatkan citra perusahaan Anda.',
            'type' => 'jasa_pasang',
            'base_price' => 3000000,
            'has_warranty' => true,
            'warranty_months' => 6,
            'image' => 'products/company-profile.jpg',
            'is_active' => true,
            'features' => [
                'Halaman Beranda',
                'Halaman Tentang Kami',
                'Halaman Layanan',
                'Halaman Portofolio',
                'Halaman Kontak',
                'Form Kontak',
            ],
            'specifications' => [
                'framework' => 'Laravel/WordPress',
                'database' => 'MySQL',
                'frontend' => 'Bootstrap/TailwindCSS',
                'responsive' => true,
                'hosting' => 'Tidak termasuk',
                'domain' => 'Tidak termasuk',
            ],
        ]);

        // Product 2 Variants
        ProductVariant::create([
            'product_id' => $product2->id,
            'name' => 'Standard',
            'sku' => 'CP-STD-' . Str::random(5),
            'price' => 3000000,
            'stock' => null,
            'options' => [
                'pages' => 'Hingga 5 halaman',
                'revisi' => '3 kali',
                'SEO' => 'Basic',
                'support' => '1 bulan',
            ],
            'is_active' => true,
        ]);

        ProductVariant::create([
            'product_id' => $product2->id,
            'name' => 'Premium',
            'sku' => 'CP-PREM-' . Str::random(5),
            'price' => 5000000,
            'stock' => null,
            'options' => [
                'pages' => 'Hingga 10 halaman',
                'revisi' => '5 kali',
                'SEO' => 'Advanced',
                'support' => '3 bulan',
                'bonus' => 'Google Analytics setup',
            ],
            'is_active' => true,
        ]);

        // Product 2 Warranty Prices
        ProductWarrantyPrice::create([
            'product_id' => $product2->id,
            'months' => 6,
            'price' => 1000000,
            'is_active' => true,
        ]);

        ProductWarrantyPrice::create([
            'product_id' => $product2->id,
            'months' => 12,
            'price' => 1800000,
            'is_active' => true,
        ]);

        // Product 3: Blog Template (Lepas)
        $product3 = Product::create([
            'name' => 'Blog Template Laravel',
            'slug' => 'blog-template-laravel',
            'description' => 'Template blog modern dengan Laravel dan TailwindCSS, siap pakai.',
            'type' => 'lepas',
            'base_price' => 750000,
            'has_warranty' => true,
            'warranty_months' => 6,
            'image' => 'products/blog-template.jpg',
            'is_active' => true,
            'features' => [
                'Admin Dashboard',
                'Post Management',
                'Category & Tag',
                'Comment System',
                'Search Functionality',
                'SEO Friendly',
            ],
            'specifications' => [
                'framework' => 'Laravel',
                'database' => 'MySQL',
                'frontend' => 'TailwindCSS',
                'responsive' => true,
                'hosting' => 'Tidak termasuk',
                'domain' => 'Tidak termasuk',
            ],
        ]);

        // Product 3 Variants
        ProductVariant::create([
            'product_id' => $product3->id,
            'name' => 'Basic License',
            'sku' => 'BT-BASIC-' . Str::random(5),
            'price' => 750000,
            'stock' => null,
            'options' => [
                'usage' => 'Single domain',
                'support' => '1 bulan',
            ],
            'is_active' => true,
        ]);

        ProductVariant::create([
            'product_id' => $product3->id,
            'name' => 'Developer License',
            'sku' => 'BT-DEV-' . Str::random(5),
            'price' => 1500000,
            'stock' => null,
            'options' => [
                'usage' => 'Multiple domains',
                'support' => '3 bulan',
                'bonus' => 'Source code akses penuh',
            ],
            'is_active' => true,
        ]);

        // Product 3 Warranty Prices
        ProductWarrantyPrice::create([
            'product_id' => $product3->id,
            'months' => 6,
            'price' => 350000,
            'is_active' => true,
        ]);

        ProductWarrantyPrice::create([
            'product_id' => $product3->id,
            'months' => 12,
            'price' => 600000,
            'is_active' => true,
        ]);
    }
}
