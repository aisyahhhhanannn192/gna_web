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
        Schema::create('transaksi_reseller', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice')->unique();
            $table->foreignId('reseller_id')->constrained('master_reseller');
            
            $table->foreignId('produk_id')->constrained('master_produk');
            $table->foreignId('warna_id')->constrained('master_warna');
            
            $table->integer('jumlah_keluar'); // Mengurangi stok_gudang_jadi
            
            // Keuangan Sederhana
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('total_harga', 15, 2); // jumlah * harga_satuan
            
            $table->date('tanggal_transaksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_reseller');
    }
};
