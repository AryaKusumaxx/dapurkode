<?php

namespace App\Services;

use App\Models\Discount;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DiscountValidatorService
{
    /**
     * Validate if a discount code is applicable.
     *
     * @param string $code
     * @param ?int $productId
     * @param float $amount
     * @return array<string, mixed>
     */
    public function validate(string $code, ?int $productId = null, float $amount = 0): array
    {
        // Find discount by code
        $discount = Discount::where('code', $code)->first();
        
        if (!$discount) {
            return [
                'valid' => false,
                'message' => 'Kode diskon tidak ditemukan.',
                'discount' => null,
            ];
        }
        
        // Check if discount is active
        if (!$discount->is_active) {
            return [
                'valid' => false,
                'message' => 'Kode diskon ini sudah tidak aktif.',
                'discount' => $discount,
            ];
        }
        
        // Check date range
        $now = Carbon::now();
        if ($discount->start_date && $now->lt($discount->start_date)) {
            return [
                'valid' => false,
                'message' => 'Kode diskon ini belum dapat digunakan.',
                'discount' => $discount,
            ];
        }
        
        if ($discount->end_date && $now->gt($discount->end_date)) {
            return [
                'valid' => false,
                'message' => 'Kode diskon ini sudah kadaluwarsa.',
                'discount' => $discount,
            ];
        }
        
        // Check usage limit
        if ($discount->max_uses && $discount->used_count >= $discount->max_uses) {
            return [
                'valid' => false,
                'message' => 'Kode diskon ini sudah mencapai batas penggunaan.',
                'discount' => $discount,
            ];
        }
        
        // Check minimum order amount
        if ($discount->min_order_amount > 0 && $amount < $discount->min_order_amount) {
            return [
                'valid' => false,
                'message' => "Minimum pembelian untuk diskon ini adalah Rp " . number_format((float)$discount->min_order_amount, 0, ',', '.'),
                'discount' => $discount,
            ];
        }
        
        // Check product specific discount
        if ($discount->product_id !== null) {
            if ($productId === null || $discount->product_id != $productId) {
                // Get product name
                $productName = 'produk tertentu';
                if ($discount->product_id) {
                    $product = Product::find($discount->product_id);
                    if ($product) {
                        $productName = $product->name;
                    }
                }
                
                return [
                    'valid' => false,
                    'message' => "Kode diskon ini hanya berlaku untuk {$productName}.",
                    'discount' => $discount,
                ];
            }
        }
        
        // All validations passed
        return [
            'valid' => true,
            'message' => 'Kode diskon berhasil digunakan.',
            'discount' => $discount,
        ];
    }
    
    /**
     * Calculate discount amount based on discount type and value.
     *
     * @param Discount $discount
     * @param float $amount
     * @return float
     */
    public function calculateDiscountAmount(Discount $discount, float $amount): float
    {
        if ($discount->type === Discount::TYPE_PERCENTAGE) {
            $discountAmount = ($amount * $discount->value) / 100;
        } else {
            $discountAmount = min($discount->value, $amount); // Fixed amount, can't exceed total
        }
        
        return round($discountAmount, 2);
    }
    
    /**
     * Increment used count after successful use.
     *
     * @param Discount $discount
     * @return bool
     */
    public function markAsUsed(Discount $discount): bool
    {
        try {
            $discount->increment('used_count');
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to mark discount as used: ' . $e->getMessage());
            return false;
        }
    }
}
