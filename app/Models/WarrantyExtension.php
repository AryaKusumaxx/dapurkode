<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WarrantyExtension extends Model
{
    /** @use HasFactory<\Database\Factories\WarrantyExtensionFactory> */
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'warranty_id',
        'user_id',
        'months',
        'price',
        'previous_end_date',
        'new_end_date',
        'payment_status',
        'notes',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'months' => 'integer',
        'price' => 'decimal:2',
        'previous_end_date' => 'date',
        'new_end_date' => 'date',
    ];
    
    // Status pembayaran
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    
    /**
     * Get the warranty that owns the extension.
     */
    public function warranty(): BelongsTo
    {
        return $this->belongsTo(Warranty::class);
    }
    
    /**
     * Get the user who requested the extension.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Check if payment is pending.
     */
    public function isPending(): bool
    {
        return $this->payment_status === self::STATUS_PENDING;
    }
    
    /**
     * Check if payment is paid.
     */
    public function isPaid(): bool
    {
        return $this->payment_status === self::STATUS_PAID;
    }
    
    /**
     * Get the order item associated with this warranty extension.
     */
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
    
    /**
     * Get the product associated with this warranty extension.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
