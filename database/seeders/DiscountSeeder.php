<?php

namespace Database\Seeders;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get product IDs
        $products = Product::all();
        $ecommerceId = $products->where('slug', 'e-commerce-website')->first()->id ?? null;
        $companyProfileId = $products->where('slug', 'company-profile-website')->first()->id ?? null;
        $blogTemplateId = $products->where('slug', 'blog-template-laravel')->first()->id ?? null;

        // Global discounts
        Discount::create([
            'product_id' => null, // Global discount
            'code' => 'WELCOME25',
            'name' => 'Welcome Discount 25%',
            'description' => 'Diskon 25% untuk semua produk',
            'type' => Discount::TYPE_PERCENTAGE,
            'value' => 25,
            'min_order_amount' => 1000000,
            'max_uses' => 50,
            'used_count' => 0,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addMonths(3),
            'is_active' => true,
        ]);

        Discount::create([
            'product_id' => null, // Global discount
            'code' => 'FLAT500K',
            'name' => 'Potongan Flat Rp 500.000',
            'description' => 'Diskon Rp 500.000 untuk semua produk',
            'type' => Discount::TYPE_FIXED,
            'value' => 500000,
            'min_order_amount' => 2000000,
            'max_uses' => 30,
            'used_count' => 0,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addMonths(2),
            'is_active' => true,
        ]);

        // Product-specific discounts
        if ($ecommerceId) {
            Discount::create([
                'product_id' => $ecommerceId,
                'code' => 'ECOM30',
                'name' => 'E-Commerce Special 30%',
                'description' => 'Diskon 30% untuk produk e-commerce website',
                'type' => Discount::TYPE_PERCENTAGE,
                'value' => 30,
                'min_order_amount' => 0,
                'max_uses' => 20,
                'used_count' => 0,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(1),
                'is_active' => true,
            ]);
        }

        if ($companyProfileId) {
            Discount::create([
                'product_id' => $companyProfileId,
                'code' => 'COMPANY20',
                'name' => 'Company Profile 20% Off',
                'description' => 'Diskon 20% untuk produk company profile website',
                'type' => Discount::TYPE_PERCENTAGE,
                'value' => 20,
                'min_order_amount' => 0,
                'max_uses' => 15,
                'used_count' => 0,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(1),
                'is_active' => true,
            ]);
        }

        if ($blogTemplateId) {
            Discount::create([
                'product_id' => $blogTemplateId,
                'code' => 'BLOG100K',
                'name' => 'Blog Template Rp 100.000 Off',
                'description' => 'Diskon Rp 100.000 untuk produk blog template',
                'type' => Discount::TYPE_FIXED,
                'value' => 100000,
                'min_order_amount' => 0,
                'max_uses' => 25,
                'used_count' => 0,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addMonths(2),
                'is_active' => true,
            ]);
        }

        // Special limited discount (low quantity)
        Discount::create([
            'product_id' => null, // Global discount
            'code' => 'FLASH50',
            'name' => 'Flash Sale 50% Off',
            'description' => 'Diskon flash sale 50% untuk semua produk (kuota terbatas)',
            'type' => Discount::TYPE_PERCENTAGE,
            'value' => 50,
            'min_order_amount' => 3000000,
            'max_uses' => 5,
            'used_count' => 0,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays(7),
            'is_active' => true,
        ]);
    }
}
