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
        Schema::table('products', function (Blueprint $table) {
            $table->longText('about_product')->nullable()->after('description');
            $table->longText('advantages')->nullable()->after('about_product');
            $table->longText('ideal_for')->nullable()->after('advantages');
            $table->longText('system_requirements')->nullable()->after('specifications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('about_product');
            $table->dropColumn('advantages');
            $table->dropColumn('ideal_for');
            $table->dropColumn('system_requirements');
        });
    }
};
