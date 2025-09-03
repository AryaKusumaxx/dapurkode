<?php

namespace App\Services;

use App\Models\Invoice;
use Carbon\Carbon;

class InvoiceNumberService
{
    /**
     * Generate unique invoice number.
     * Format: INV/[YEAR]/[MONTH]/[COUNTER]
     * Example: INV/2025/08/0001
     *
     * @return string
     */
    public function generate(): string
    {
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $prefix = "INV/{$year}/{$month}/";
        
        // Get latest invoice for this month
        $latestInvoice = Invoice::where('invoice_number', 'like', $prefix . '%')
            ->orderBy('created_at', 'desc')
            ->first();
        
        // Extract counter from latest invoice or start with 1
        if ($latestInvoice) {
            $parts = explode('/', $latestInvoice->invoice_number);
            $counter = (int) end($parts);
            $counter++;
        } else {
            $counter = 1;
        }
        
        // Format counter with leading zeros (4 digits)
        $formattedCounter = str_pad($counter, 4, '0', STR_PAD_LEFT);
        
        // Combine prefix and counter
        return $prefix . $formattedCounter;
    }
}
