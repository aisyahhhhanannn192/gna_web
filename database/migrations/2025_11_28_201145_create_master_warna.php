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
        Schema::create('master_warna', function (Blueprint $table) {
            $table->id();
            $table->string('nama_warna'); // Merah, Biru, Hitam
            $table->string('kode_warna')->nullable(); // Opsional: #FF0000
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_warna');
    }
};
