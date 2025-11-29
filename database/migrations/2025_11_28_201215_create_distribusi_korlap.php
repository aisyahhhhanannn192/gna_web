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
        Schema::create('distribusi_korlap', function (Blueprint $table) {
            $table->id();
            $table->string('no_nota')->unique(); // Nota pengambilan
            $table->foreignId('korlap_id')->constrained('master_korlap');
            
            $table->foreignId('produk_id')->constrained('master_produk');
            $table->foreignId('warna_id')->constrained('master_warna');
            
            $table->integer('jumlah_cek_keluar'); // Mengurangi stok_cek
            $table->date('tanggal_distribusi');
            
            // 'sedang_dikerjakan', 'selesai'
            $table->string('status')->default('sedang_dikerjakan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusi_korlap');
    }
};
