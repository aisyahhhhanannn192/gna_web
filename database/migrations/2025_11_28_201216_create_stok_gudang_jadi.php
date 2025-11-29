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
        Schema::create('stok_gudang_jadi', function (Blueprint $table) {
            // Composite Primary Key lagi
            $table->foreignId('produk_id')->constrained('master_produk');
            $table->foreignId('warna_id')->constrained('master_warna');
            
            $table->integer('jumlah_stok')->default(0);
            
            $table->primary(['produk_id', 'warna_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_gudang_jadi');
    }
};
