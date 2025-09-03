<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'about_product',
        'advantages',
        'ideal_for',
        'type',
        'category',
        'base_price',
        'discount_price',
        'has_warranty',
        'warranty_months',
        'image',
        'is_active',
        'is_featured',
        'features',
        'specifications',
        'system_requirements',
        'meta_title',
        'meta_description',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'base_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'has_warranty' => 'boolean',
        'warranty_months' => 'integer',
        'is_active' => 'boolean',
        'features' => 'array',
        'specifications' => 'array',
    ];
    
    /**
     * Get the variants for the product.
     */
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }
    
    /**
     * Get the warranty prices for the product.
     */
    public function warrantyPrices(): HasMany
    {
        return $this->hasMany(ProductWarrantyPrice::class);
    }
    
    /**
     * Get the discounts for the product.
     */
    public function discounts(): HasMany
    {
        return $this->hasMany(Discount::class);
    }
    
    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Scope a query to filter by product type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
    
    /**
     * Get the price attribute.
     * 
     * @return mixed
     */
    public function getPriceAttribute()
    {
        return $this->discount_price ?? $this->base_price;
    }
    
    /**
     * Get the regular price attribute (used for display with discounts).
     * 
     * @return mixed
     */
    public function getRegularPriceAttribute()
    {
        return $this->base_price;
    }
    
    /**
     * Get the discount percentage.
     * 
     * @return float|int
     */
    public function getDiscountAttribute()
    {
        if (!$this->discount_price || $this->discount_price >= $this->base_price) {
            return 0;
        }
        
        return round(100 - (($this->discount_price / $this->base_price) * 100));
    }
}
