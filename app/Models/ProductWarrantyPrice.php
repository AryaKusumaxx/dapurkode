<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductWarrantyPrice extends Model
{
    /** @use HasFactory<\Database\Factories\ProductWarrantyPriceFactory> */
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'product_id',
        'months',
        'price',
        'is_active',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'months' => 'integer',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];
    
    /**
     * Get the product that owns the warranty price.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    
    /**
     * Scope a query to only include active warranty prices.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
