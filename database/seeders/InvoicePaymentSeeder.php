<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use App\Services\InvoiceNumberService;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InvoicePaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $invoiceService = new InvoiceNumberService();
        
        // Create sample invoices and payments
        $customers = User::role('pelanggan')->get();
        $orders = Order::whereIn('status', [Order::STATUS_COMPLETED, Order::STATUS_PAID])->get();
        
        foreach ($orders as $order) {
            // Only generate invoice for orders that don't have one yet
            if (!$order->invoice()->exists()) {
                $customer = $customers->firstWhere('id', $order->user_id) ?? $customers->random();
                $invoiceNumber = $invoiceService->generate();
                
                $dueDate = Carbon::parse($order->order_date)->addDays(7);
                $status = $order->status === Order::STATUS_COMPLETED ? Invoice::STATUS_PAID : Invoice::STATUS_UNPAID;
                
                $invoice = Invoice::create([
                    'invoice_number' => $invoiceNumber,
                    'order_id' => $order->id,
                    'user_id' => $customer->id,
                    'subtotal' => $order->total_price,
                    'discount' => $order->discount_amount,
                    'tax' => $order->tax,
                    'total' => $order->total_price + $order->tax - $order->discount_amount,
                    'due_date' => $dueDate,
                    'status' => $status,
                    'notes' => 'Pembayaran untuk pesanan ' . $order->order_number,
                ]);
                
                // Create payment for paid invoices
                if ($status === Invoice::STATUS_PAID) {
                    $paymentDate = Carbon::parse($order->order_date)->addHours(rand(1, 72));
                    
                    Payment::create([
                        'invoice_id' => $invoice->id,
                        'user_id' => $customer->id,
                        'amount' => $invoice->total,
                        'payment_method' => array_rand(array_flip([
                            Payment::METHOD_BANK_TRANSFER,
                            Payment::METHOD_CREDIT_CARD,
                            Payment::METHOD_E_WALLET
                        ])),
                        'payment_date' => $paymentDate,
                        'status' => Payment::STATUS_VERIFIED,
                        'transaction_id' => 'TRX' . strtoupper(substr(md5(rand()), 0, 10)),
                        'notes' => 'Pembayaran untuk invoice ' . $invoice->invoice_number,
                    ]);
                }
            }
        }
    }
}
