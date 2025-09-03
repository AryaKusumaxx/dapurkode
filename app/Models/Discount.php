<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Discount extends Model
{
    /** @use HasFactory<\Database\Factories\DiscountFactory> */
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'product_id',
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_order_amount',
        'max_uses',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_uses' => 'integer',
        'used_count' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];
    
    // Tipe diskon
    const TYPE_PERCENTAGE = 'percentage';
    const TYPE_FIXED = 'fixed';
    
    /**
     * Get the product that owns the discount.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    
    /**
     * Get the orders that used this discount.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
    
    /**
     * Scope a query to only include active discounts.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function($query) {
                $query->whereNull('start_date')
                      ->orWhere('start_date', '<=', Carbon::now());
            })
            ->where(function($query) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', Carbon::now());
            })
            ->where(function($query) {
                $query->whereNull('max_uses')
                      ->orWhereRaw('used_count < max_uses');
            });
    }
    
    /**
     * Check if discount is valid for the given product and amount.
     */
    public function isValidFor($productId, $amount): bool
    {
        // Check if product-specific discount
        if ($this->product_id !== null && $this->product_id != $productId) {
            return false;
        }
        
        // Check minimum amount
        if ($this->min_order_amount > 0 && $amount < $this->min_order_amount) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Calculate discount amount based on the discount type and value.
     */
    public function calculateDiscountAmount($amount): float
    {
        if ($this->type === self::TYPE_PERCENTAGE) {
            return ($amount * $this->value) / 100;
        }
        
        return min($this->value, $amount); // Fixed amount, but never more than the total
    }
}
