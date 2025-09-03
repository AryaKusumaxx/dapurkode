<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variant_id');
            $table->string('product_name'); // Snapshot data
            $table->string('variant_name'); // Snapshot data
            $table->decimal('price', 15, 2); // Harga saat pembelian
            $table->integer('quantity')->default(1);
            $table->integer('warranty_months')->default(6); // Durasi garansi default 6 bulan
            $table->decimal('warranty_price', 15, 2)->default(0); // Harga garansi tambahan jika ada
            $table->decimal('subtotal', 15, 2); // (price * quantity) + warranty_price
            $table->timestamps();
            
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
