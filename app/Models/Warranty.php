<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Warranty extends Model
{
    /** @use HasFactory<\Database\Factories\WarrantyFactory> */
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'order_item_id',
        'start_date',
        'end_date',
        'is_active',
        'notes',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];
    
    /**
     * Get the order item that owns the warranty.
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }
    
    /**
     * Get the extensions for the warranty.
     */
    public function extensions(): HasMany
    {
        return $this->hasMany(WarrantyExtension::class);
    }
    
    /**
     * Check if warranty is active.
     */
    public function isActive(): bool
    {
        return $this->is_active && Carbon::now()->lt($this->end_date);
    }
    
    /**
     * Check if warranty is expired.
     */
    public function isExpired(): bool
    {
        return Carbon::now()->gt($this->end_date);
    }
    
    /**
     * Calculate remaining days of warranty.
     */
    public function remainingDays(): int
    {
        if ($this->isExpired()) {
            return 0;
        }
        
        return Carbon::now()->diffInDays($this->end_date);
    }
    
    /**
     * Get the product associated with this warranty through the order item.
     * This is a convenience method that doesn't define an actual Eloquent relationship.
     */
    public function getProduct()
    {
        return $this->orderItem ? $this->orderItem->product : null;
    }
}
