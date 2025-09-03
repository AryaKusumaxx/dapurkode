<?php

namespace App\Services;

use App\Models\OrderItem;
use App\Models\Warranty;
use App\Models\WarrantyExtension;
use App\Services\AuditService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class WarrantyService
{
    /**
     * Create a new warranty for an order item.
     *
     * @param OrderItem $orderItem
     * @return Warranty
     */
    public function createWarranty(OrderItem $orderItem): Warranty
    {
        $startDate = Carbon::now();
        // Convert months to days (approximately 30 days per month)
        $days = $orderItem->warranty_months * 30;
        $endDate = Carbon::now()->addDays($days);
        
        return Warranty::create([
            'order_item_id' => $orderItem->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_active' => true,
            'notes' => 'Garansi awal pembelian ' . $orderItem->product_name,
        ]);
    }
    
    /**
     * Extend a warranty for specified months.
     *
     * @param Warranty $warranty
     * @param int $months
     * @param float $price
     * @param int $userId
     * @return WarrantyExtension
     */
    public function extendWarranty(Warranty $warranty, int $months, float $price, int $userId): WarrantyExtension
    {
        return DB::transaction(function () use ($warranty, $months, $price, $userId) {
            $previousEndDate = $warranty->end_date;
            // Convert months to days (approximately 30 days per month)
            $days = $months * 30;
            $newEndDate = Carbon::parse($previousEndDate)->addDays($days);
            
            // Create extension record
            $extension = WarrantyExtension::create([
                'warranty_id' => $warranty->id,
                'user_id' => $userId,
                'months' => $months,
                'price' => $price,
                'previous_end_date' => $previousEndDate,
                'new_end_date' => $newEndDate,
                'payment_status' => WarrantyExtension::STATUS_PENDING,
                'notes' => 'Perpanjangan garansi sebanyak ' . $months . ' bulan (' . $days . ' hari)',
            ]);
            
            return $extension;
        });
    }
    
    /**
     * Activate warranty extension after payment is verified.
     *
     * @param WarrantyExtension $extension
     * @return bool
     */
    public function activateExtension(WarrantyExtension $extension): bool
    {
        return DB::transaction(function () use ($extension) {
            // Update extension status
            $extension->update([
                'payment_status' => WarrantyExtension::STATUS_PAID,
            ]);
            
            // Update warranty end date
            $warranty = $extension->warranty;
            $warranty->update([
                'end_date' => $extension->new_end_date,
                'notes' => $warranty->notes . "\nDiperpanjang pada " . now()->format('Y-m-d'),
            ]);
            
            return true;
        });
    }
    
    /**
     * Check if a product is still under warranty.
     *
     * @param Warranty $warranty
     * @return bool
     */
    public function isUnderWarranty(Warranty $warranty): bool
    {
        return $warranty->is_active && Carbon::now()->lt($warranty->end_date);
    }
    
    /**
     * Calculate remaining warranty days.
     *
     * @param Warranty $warranty
     * @return int
     */
    public function getRemainingDays(Warranty $warranty): int
    {
        if (Carbon::now()->gt($warranty->end_date)) {
            return 0;
        }
        
        return Carbon::now()->diffInDays($warranty->end_date);
    }
    
    /**
     * Update warranty status based on expiration.
     * This should be run daily via a scheduled task.
     *
     * @return int Number of warranties updated
     */
    public function updateExpiredWarranties(): int
    {
        $now = Carbon::now();
        
        // Find all active warranties that have expired
        $expiredWarranties = Warranty::where('is_active', true)
            ->where('end_date', '<', $now)
            ->get();
            
        foreach ($expiredWarranties as $warranty) {
            $warranty->update(['is_active' => false]);
        }
        
        return $expiredWarranties->count();
    }
    
    /**
     * Check if a file download is allowed based on warranty status.
     *
     * @param Warranty $warranty
     * @return bool
     */
    public function isDownloadAllowed(Warranty $warranty): bool
    {
        // Only allow downloads for active warranties
        return $warranty->is_active && Carbon::now()->lt($warranty->end_date);
    }
    
    /**
     * Generate a warranty certificate PDF.
     *
     * @param Warranty $warranty
     * @return \Illuminate\Http\Response
     */
    public function generateWarrantyCertificate(Warranty $warranty)
    {
        // Load all required relations
        $warranty->load(['orderItem.product', 'orderItem.order.user']);
        
        $orderItem = $warranty->orderItem;
        $product = $orderItem ? $orderItem->product : null;
        $order = $orderItem ? $orderItem->order : null;
        $user = $order ? $order->user : null;
        
        if (!$product || !$user) {
            abort(404, 'Data garansi tidak lengkap.');
        }
        
        $data = [
            'warranty' => $warranty,
            'product' => $product,
            'user' => $user,
            'remainingDays' => $this->getRemainingDays($warranty),
        ];
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.warranty-certificate', $data);
        
        return $pdf->download('Warranty-Certificate-' . $warranty->id . '.pdf');
    }
    
    /**
     * Log an action related to a warranty.
     *
     * @param Warranty $warranty
     * @param string $actionType
     * @param string $description
     * @return void
     */
    public function logWarrantyAction(Warranty $warranty, string $actionType, string $description)
    {
        try {
            $newValues = [
                'description' => $description,
                'action_type' => $actionType
            ];
            
            app(AuditService::class)->log($actionType, $warranty, null, $newValues);
        } catch (\Exception $e) {
            \Log::error('Failed to log warranty action: ' . $e->getMessage(), [
                'warranty_id' => $warranty->id,
                'action_type' => $actionType,
                'description' => $description
            ]);
        }
    }
}
