<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Company settings
        Setting::create([
            'key' => 'company_name',
            'value' => 'DapurKode',
            'group' => 'company',
            'description' => 'Nama perusahaan',
            'is_active' => true,
        ]);

        Setting::create([
            'key' => 'company_address',
            'value' => 'Jl. Teknologi No. 123, Jakarta Selatan',
            'group' => 'company',
            'description' => 'Alamat perusahaan',
            'is_active' => true,
        ]);

        Setting::create([
            'key' => 'company_email',
            'value' => 'info@dapurkode.com',
            'group' => 'company',
            'description' => 'Email perusahaan',
            'is_active' => true,
        ]);

        Setting::create([
            'key' => 'company_phone',
            'value' => '021-12345678',
            'group' => 'company',
            'description' => 'Nomor telepon perusahaan',
            'is_active' => true,
        ]);

        Setting::create([
            'key' => 'company_website',
            'value' => 'https://dapurkode.com',
            'group' => 'company',
            'description' => 'Website perusahaan',
            'is_active' => true,
        ]);

        // Invoice settings
        Setting::create([
            'key' => 'invoice_due_days',
            'value' => '3',
            'group' => 'invoice',
            'description' => 'Durasi jatuh tempo invoice dalam hari',
            'is_active' => true,
        ]);

        Setting::create([
            'key' => 'invoice_footer',
            'value' => 'Terima kasih telah mempercayakan pembelian Anda kepada DapurKode.',
            'group' => 'invoice',
            'description' => 'Catatan kaki pada invoice',
            'is_active' => true,
        ]);

        Setting::create([
            'key' => 'invoice_notes',
            'value' => 'Pembayaran dapat dilakukan melalui transfer bank. Mohon kirimkan bukti transfer setelah melakukan pembayaran.',
            'group' => 'invoice',
            'description' => 'Catatan tambahan pada invoice',
            'is_active' => true,
        ]);

        // Payment settings
        Setting::create([
            'key' => 'payment_bank_name',
            'value' => 'Bank Mandiri',
            'group' => 'payment',
            'description' => 'Nama bank untuk pembayaran',
            'is_active' => true,
        ]);

        Setting::create([
            'key' => 'payment_account_number',
            'value' => '1234567890',
            'group' => 'payment',
            'description' => 'Nomor rekening untuk pembayaran',
            'is_active' => true,
        ]);

        Setting::create([
            'key' => 'payment_account_name',
            'value' => 'PT DapurKode Indonesia',
            'group' => 'payment',
            'description' => 'Nama pemilik rekening untuk pembayaran',
            'is_active' => true,
        ]);

        // Notification settings
        Setting::create([
            'key' => 'notification_email',
            'value' => 'true',
            'group' => 'notification',
            'description' => 'Status notifikasi email',
            'is_active' => true,
        ]);

        Setting::create([
            'key' => 'notification_whatsapp',
            'value' => 'true',
            'group' => 'notification',
            'description' => 'Status notifikasi WhatsApp',
            'is_active' => true,
        ]);

        Setting::create([
            'key' => 'whatsapp_template_order',
            'value' => 'Halo {name}, terima kasih telah melakukan pemesanan di DapurKode dengan nomor order {order_number}. Total pesanan Anda adalah Rp {total}. Silakan lakukan pembayaran sebelum {due_date}.',
            'group' => 'notification',
            'description' => 'Template pesan WhatsApp untuk order baru',
            'is_active' => true,
        ]);

        Setting::create([
            'key' => 'whatsapp_template_payment',
            'value' => 'Halo {name}, pembayaran Anda untuk order {order_number} sebesar Rp {amount} telah kami terima. Terima kasih!',
            'group' => 'notification',
            'description' => 'Template pesan WhatsApp untuk konfirmasi pembayaran',
            'is_active' => true,
        ]);

        // General settings
        Setting::create([
            'key' => 'site_name',
            'value' => 'DapurKode - Solusi Digital Anda',
            'group' => 'general',
            'description' => 'Nama situs',
            'is_active' => true,
        ]);

        Setting::create([
            'key' => 'site_description',
            'value' => 'DapurKode menyediakan berbagai solusi digital berupa website, aplikasi, dan template untuk kebutuhan bisnis Anda.',
            'group' => 'general',
            'description' => 'Deskripsi situs',
            'is_active' => true,
        ]);

        Setting::create([
            'key' => 'currency',
            'value' => 'IDR',
            'group' => 'general',
            'description' => 'Mata uang',
            'is_active' => true,
        ]);

        Setting::create([
            'key' => 'currency_symbol',
            'value' => 'Rp',
            'group' => 'general',
            'description' => 'Simbol mata uang',
            'is_active' => true,
        ]);

        Setting::create([
            'key' => 'tax_percentage',
            'value' => '0',
            'group' => 'general',
            'description' => 'Persentase pajak',
            'is_active' => true,
        ]);
    }
}
