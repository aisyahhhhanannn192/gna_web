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
        Schema::create('bahan_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('master_supplier');
            $table->foreignId('warna_id')->constrained('master_warna');
            $table->integer('jumlah_gulungan_masuk');
            $table->date('tanggal_masuk');
            $table->string('no_nota_supplier')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_masuk');
    }
};
