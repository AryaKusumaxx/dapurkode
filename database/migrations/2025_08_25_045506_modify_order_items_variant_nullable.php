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
        Schema::table('order_items', function (Blueprint $table) {
            // Drop the foreign key first
            $table->dropForeign(['product_variant_id']);
            
            // Change the column to be nullable
            $table->unsignedBigInteger('product_variant_id')->nullable()->change();
            
            // Re-add the foreign key with nullable constraint
            $table->foreign('product_variant_id')
                  ->references('id')
                  ->on('product_variants')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Drop the foreign key first
            $table->dropForeign(['product_variant_id']);
            
            // Change the column back to non-nullable
            $table->unsignedBigInteger('product_variant_id')->nullable(false)->change();
            
            // Re-add the foreign key
            $table->foreign('product_variant_id')
                  ->references('id')
                  ->on('product_variants')
                  ->onDelete('restrict');
        });
    }
};
