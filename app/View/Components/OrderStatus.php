<?php

namespace App\View\Components;

use App\Models\Invoice;
use App\Models\Order;
use App\Services\OrderStatusService;
use Illuminate\View\Component;
use Illuminate\View\View;

class OrderStatus extends Component
{
    /**
     * The order model instance.
     */
    public $order;
    
    /**
     * The invoice model instance.
     */
    public $invoice;
    
    /**
     * The unified status data.
     */
    public $status;

    /**
     * Create a new component instance.
     *
     * @param Order|null $order
     * @param Invoice|null $invoice
     */
    public function __construct($order = null, $invoice = null)
    {
        $this->order = $order;
        $this->invoice = $invoice;
        
        // Determine which models we have and get the appropriate status
        if ($this->invoice && !$this->order) {
            $this->order = $this->invoice->order;
        }
        
        if ($this->order && !$this->invoice) {
            $this->invoice = $this->order->invoice;
        }
        
        // Get unified status if we have both order and invoice
        if ($this->order && $this->invoice) {
            $this->status = OrderStatusService::getUnifiedStatus(
                $this->invoice->status, 
                $this->order->status
            );
        } elseif ($this->order) {
            // Fallback to order status only
            $orderStatus = $this->getOrderOnlyStatus($this->order->status);
            $this->status = $orderStatus;
        } elseif ($this->invoice) {
            // Fallback to invoice status only
            $invoiceStatus = $this->getInvoiceOnlyStatus($this->invoice->status);
            $this->status = $invoiceStatus;
        } else {
            // No order or invoice provided
            $this->status = [
                'label' => 'Unknown',
                'color' => 'gray',
                'description' => 'Status tidak diketahui',
                'payment_required' => false,
                'can_cancel' => false
            ];
        }
    }
    
    /**
     * Get status when we only have order information
     */
    protected function getOrderOnlyStatus(string $orderStatus): array
    {
        $status = [
            'label' => 'Unknown',
            'color' => 'gray',
            'description' => 'Status tidak diketahui',
            'payment_required' => false,
            'can_cancel' => false
        ];
        
        switch ($orderStatus) {
            case Order::STATUS_PENDING:
                $status = [
                    'label' => 'Tertunda',
                    'color' => 'yellow',
                    'description' => 'Pesanan Anda sedang tertunda',
                    'payment_required' => true,
                    'can_cancel' => true
                ];
                break;
                
            case 'processing':
                $status = [
                    'label' => 'Sedang Diproses',
                    'color' => 'blue',
                    'description' => 'Pesanan Anda sedang diproses',
                    'payment_required' => false,
                    'can_cancel' => false
                ];
                break;
                
            case Order::STATUS_COMPLETED:
                $status = [
                    'label' => 'Selesai',
                    'color' => 'green',
                    'description' => 'Pesanan Anda telah selesai',
                    'payment_required' => false,
                    'can_cancel' => false
                ];
                break;
                
            case Order::STATUS_CANCELLED:
                $status = [
                    'label' => 'Dibatalkan',
                    'color' => 'gray',
                    'description' => 'Pesanan Anda telah dibatalkan',
                    'payment_required' => false,
                    'can_cancel' => false
                ];
                break;
        }
        
        return $status;
    }
    
    /**
     * Get status when we only have invoice information
     */
    protected function getInvoiceOnlyStatus(string $invoiceStatus): array
    {
        $status = [
            'label' => 'Unknown',
            'color' => 'gray',
            'description' => 'Status tidak diketahui',
            'payment_required' => false,
            'can_cancel' => false
        ];
        
        switch ($invoiceStatus) {
            case Invoice::STATUS_UNPAID:
                $status = [
                    'label' => 'Belum Dibayar',
                    'color' => 'yellow',
                    'description' => 'Tagihan belum dibayar',
                    'payment_required' => true,
                    'can_cancel' => true
                ];
                break;
                
            case Invoice::STATUS_PENDING_CONFIRMATION:
                $status = [
                    'label' => 'Menunggu Konfirmasi',
                    'color' => 'blue',
                    'description' => 'Pembayaran sedang diverifikasi',
                    'payment_required' => false,
                    'can_cancel' => false
                ];
                break;
                
            case Invoice::STATUS_PAID:
                $status = [
                    'label' => 'Lunas',
                    'color' => 'green',
                    'description' => 'Tagihan telah lunas',
                    'payment_required' => false,
                    'can_cancel' => false
                ];
                break;
                
            case Invoice::STATUS_OVERDUE:
                $status = [
                    'label' => 'Jatuh Tempo',
                    'color' => 'red',
                    'description' => 'Tagihan telah jatuh tempo',
                    'payment_required' => true,
                    'can_cancel' => false
                ];
                break;
                
            case Invoice::STATUS_CANCELLED:
                $status = [
                    'label' => 'Dibatalkan',
                    'color' => 'gray',
                    'description' => 'Tagihan telah dibatalkan',
                    'payment_required' => false,
                    'can_cancel' => false
                ];
                break;
        }
        
        return $status;
    }
    
    /**
     * Get the status CSS classes
     */
    public function getClasses(): array
    {
        return OrderStatusService::getStatusClasses($this->status['color']);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.order-status');
    }
}
