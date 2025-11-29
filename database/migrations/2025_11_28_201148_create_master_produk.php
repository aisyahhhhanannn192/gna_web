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
        Schema::create('master_produk', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk'); // Jas Hujan Ponco, Setelan
            $table->string('kode_produk')->unique(); // P01, S01
            // Estimasi ini berguna untuk warning jika rendemen aneh (opsional)
            $table->integer('estimasi_pcs_per_gulung')->default(50); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_produk');
    }
};
