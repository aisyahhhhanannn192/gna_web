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
        Schema::create('setor_korlap', function (Blueprint $table) {
            $table->id();
            // Opsional: Boleh null jika sistemnya "Running Balance" (tidak mengikat ke nota ambil spesifik)
            // Tapi disarankan ada untuk tracing.
            $table->foreignId('distribusi_korlap_id')->nullable()->constrained('distribusi_korlap');
            $table->foreignId('korlap_id')->constrained('master_korlap');
            
            // Hasil QC
            $table->integer('jumlah_pcs_jadi')->default(0); // Masuk stok_gudang_jadi
            $table->integer('jumlah_afkir')->default(0);    // Dibuang/Rugi
            $table->integer('jumlah_pending')->default(0);  // Dibawa pulang lagi (Hutang)
            
            $table->text('catatan')->nullable(); // "Kurang kancing", "Jahitan miring", dll
            $table->date('tanggal_setor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setor_korlap');
    }
};
