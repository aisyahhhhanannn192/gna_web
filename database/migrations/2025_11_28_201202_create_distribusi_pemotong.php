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
        Schema::create('distribusi_pemotong', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat_jalan')->unique(); // Generate otomatis, misal: SJ-20231128-001
            $table->foreignId('pemotong_id')->constrained('master_pemotong');
            
            // Target Produksi (Kain ini mau dijadikan apa?)
            $table->foreignId('produk_id')->constrained('master_produk');
            $table->foreignId('warna_id')->constrained('master_warna');
            
            $table->integer('jumlah_gulungan_keluar');
            $table->date('tanggal_distribusi');
            
            // Status: 'proses', 'selesai' (jika sudah disetor semua)
            $table->string('status')->default('proses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusi_pemotong');
    }
};
