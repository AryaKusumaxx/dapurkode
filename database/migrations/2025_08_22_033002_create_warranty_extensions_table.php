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
        Schema::create('warranty_extensions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('warranty_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('months'); // Durasi perpanjangan dalam bulan
            $table->decimal('price', 15, 2); // Harga perpanjangan
            $table->date('previous_end_date'); // Tanggal akhir sebelum perpanjangan
            $table->date('new_end_date'); // Tanggal akhir setelah perpanjangan
            $table->string('payment_status'); // pending, paid
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('warranty_id')->references('id')->on('warranties')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranty_extensions');
    }
};
