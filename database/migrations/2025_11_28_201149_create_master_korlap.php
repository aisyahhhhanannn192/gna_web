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
        Schema::create('master_korlap', function (Blueprint $table) {
            $table->id();
            $table->string('nama_korlap');
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable(); // Penting jika harus jemput barang pending
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_korlap');
    }
};
