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
        Schema::create('stok_bahan_kain', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warna_id')->constrained('master_warna')->cascadeOnDelete();
            $table->integer('jumlah_gulungan')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_bahan_kain');
    }
};
