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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('type'); // paket, jasa_pasang, lepas
            $table->decimal('base_price', 15, 2);
            $table->boolean('has_warranty')->default(true);
            $table->integer('warranty_months')->default(6); // Default 6 bulan
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('features')->nullable(); // Fitur produk dalam format JSON
            $table->json('specifications')->nullable(); // Spesifikasi produk dalam format JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
