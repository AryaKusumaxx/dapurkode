<?php

namespace Database\Seeders;

use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all customers
        $customers = User::role('pelanggan')->get();
        if ($customers->isEmpty()) {
            // If no customers, create at least one order with a random user
            $customers = User::whereNot('id', 1)->limit(3)->get(); // Exclude superadmin
        }
        
        // Get all active products
        $products = Product::where('is_active', true)->get();
        
        // Get available discounts
        $discounts = Discount::where('is_active', true)
                        ->where(function ($query) {
                            $query->whereNull('end_date')
                                ->orWhere('end_date', '>', Carbon::now());
                        })
                        ->get();
        
        // Create orders for each customer (1-3 orders per customer)
        foreach ($customers as $customer) {
            $orderCount = rand(1, 3);
            
            for ($i = 0; $i < $orderCount; $i++) {
                // Decide order date (some recent, some older)
                $daysAgo = rand(1, 60);
                $orderDate = Carbon::now()->subDays($daysAgo);
                
                // Order status based on date
                $status = $daysAgo < 7 ? Order::STATUS_PENDING : 
                         ($daysAgo < 14 ? Order::STATUS_PAID : 
                         Order::STATUS_COMPLETED);
                
                // Random discount (20% chance)
                $discount = (rand(1, 5) === 1) ? $discounts->random() : null;
                $discountAmount = 0;
                
                // Create order
                $order = Order::create([
                    'order_number' => 'ORD-' . strtoupper(substr(md5(uniqid()), 0, 8)),
                    'user_id' => $customer->id,
                    'discount_id' => $discount ? $discount->id : null,
                    'order_date' => $orderDate,
                    'status' => $status,
                    'notes' => 'Pesanan dibuat melalui seeder.',
                ]);
                
                // Add 1-3 items to order
                $itemCount = rand(1, 3);
                $subtotal = 0;
                
                for ($j = 0; $j < $itemCount; $j++) {
                    // Select random product
                    $product = $products->random();
                    
                    // Select variant if available
                    $variants = ProductVariant::where('product_id', $product->id)->get();
                    $variant = $variants->isNotEmpty() ? $variants->random() : null;
                    
                    $itemPrice = $variant ? $variant->price : $product->price;
                    $quantity = rand(1, 2); // Most people buy 1-2 licenses
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_variant_id' => $variant ? $variant->id : null,
                        'warranty_id' => null, // Basic warranty included
                        'quantity' => $quantity,
                        'price' => $itemPrice,
                        'total' => $itemPrice * $quantity,
                    ]);
                    
                    $subtotal += $itemPrice * $quantity;
                }
                
                // Apply discount if applicable
                if ($discount) {
                    if ($discount->type === Discount::TYPE_PERCENTAGE) {
                        $discountAmount = ($subtotal * $discount->value) / 100;
                    } else {
                        $discountAmount = min($discount->value, $subtotal); // Don't exceed subtotal
                    }
                    
                    // If discount has minimum order requirement
                    if ($discount->min_order_amount > 0 && $subtotal < $discount->min_order_amount) {
                        $discountAmount = 0;
                    }
                }
                
                // Update order totals
                $tax = ($subtotal - $discountAmount) * 0.11; // 11% tax
                $total = $subtotal - $discountAmount + $tax;
                
                $order->update([
                    'subtotal' => $subtotal,
                    'discount_amount' => $discountAmount,
                    'tax' => $tax,
                    'total' => $total,
                ]);
                
                // If discount was used, increment used count
                if ($discount && $discountAmount > 0) {
                    $discount->increment('used_count');
                }
            }
        }
    }
}
