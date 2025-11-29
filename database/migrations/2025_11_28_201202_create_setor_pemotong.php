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
        Schema::create('setor_pemotong', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distribusi_pemotong_id')->constrained('distribusi_pemotong')->cascadeOnDelete();
    
            $table->integer('jumlah_cek_jadi'); // Hasil potongan (lembaran)
            $table->decimal('berat_limbah_kg', 8, 2)->nullable(); // Sisa kain
            $table->date('tanggal_setor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setor_pemotong');
    }
};
