<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;

class OrderStatusService
{
    /**
     * Maps invoice status to a unified status display
     * 
     * @param string $invoiceStatus
     * @param string $orderStatus
     * @return array
     */
    public static function getUnifiedStatus(string $invoiceStatus, string $orderStatus): array
    {
        // Start with default values
        $displayStatus = [
            'label' => 'Unknown',
            'color' => 'gray',
            'description' => 'Status tidak diketahui',
            'payment_required' => false,
            'can_cancel' => false
        ];

        // Payment-related statuses (from invoice)
        if ($invoiceStatus === Invoice::STATUS_UNPAID) {
            $displayStatus = [
                'label' => 'Menunggu Pembayaran',
                'color' => 'yellow',
                'description' => 'Pesanan Anda sedang menunggu pembayaran',
                'payment_required' => true,
                'can_cancel' => true
            ];
        } elseif ($invoiceStatus === Invoice::STATUS_PENDING_CONFIRMATION) {
            $displayStatus = [
                'label' => 'Menunggu Konfirmasi',
                'color' => 'blue',
                'description' => 'Pembayaran Anda sedang diproses untuk konfirmasi',
                'payment_required' => false,
                'can_cancel' => false
            ];
        } elseif ($invoiceStatus === Invoice::STATUS_PAID) {
            // For paid invoices, we look at the order status for the current process stage
            if ($orderStatus === 'processing') {
                $displayStatus = [
                    'label' => 'Sedang Diproses',
                    'color' => 'blue',
                    'description' => 'Pesanan Anda sedang diproses',
                    'payment_required' => false,
                    'can_cancel' => false
                ];
            } elseif ($orderStatus === Order::STATUS_COMPLETED) {
                $displayStatus = [
                    'label' => 'Selesai',
                    'color' => 'green',
                    'description' => 'Pesanan Anda telah selesai',
                    'payment_required' => false,
                    'can_cancel' => false
                ];
            } else {
                $displayStatus = [
                    'label' => 'Pembayaran Diterima',
                    'color' => 'green',
                    'description' => 'Pembayaran Anda telah diterima',
                    'payment_required' => false,
                    'can_cancel' => false
                ];
            }
        } elseif ($invoiceStatus === Invoice::STATUS_OVERDUE) {
            $displayStatus = [
                'label' => 'Pembayaran Terlambat',
                'color' => 'red',
                'description' => 'Batas waktu pembayaran telah terlewat',
                'payment_required' => true,
                'can_cancel' => false
            ];
        } elseif ($invoiceStatus === Invoice::STATUS_CANCELLED) {
            $displayStatus = [
                'label' => 'Dibatalkan',
                'color' => 'gray',
                'description' => 'Pesanan Anda telah dibatalkan',
                'payment_required' => false,
                'can_cancel' => false
            ];
        }

        return $displayStatus;
    }
    
    /**
     * Get the appropriate CSS class for the status color
     * 
     * @param string $color
     * @return array
     */
    public static function getStatusClasses(string $color): array
    {
        $classes = [
            'bg' => 'bg-gray-100',
            'text' => 'text-gray-800',
        ];
        
        switch ($color) {
            case 'green':
                $classes['bg'] = 'bg-green-100';
                $classes['text'] = 'text-green-800';
                break;
            case 'yellow':
                $classes['bg'] = 'bg-yellow-100';
                $classes['text'] = 'text-yellow-800';
                break;
            case 'red':
                $classes['bg'] = 'bg-red-100';
                $classes['text'] = 'text-red-800';
                break;
            case 'blue':
                $classes['bg'] = 'bg-blue-100';
                $classes['text'] = 'text-blue-800';
                break;
        }
        
        return $classes;
    }
}
