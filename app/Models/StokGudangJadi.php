<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokGudangJadi extends Model
{
    use HasFactory;
    
    protected $table = 'stok_gudang_jadi';
    
    // Karena tabel ini tidak punya kolom ID auto-increment biasa,
    // Kita harus setting ini agar Laravel tidak error saat update:
    protected $primaryKey = null; 
    public $incrementing = false; 
    
    protected $guarded = []; 

    // --- TAMBAHKAN BAGIAN INI ---
    
    // 1. Relasi ke Master Produk
    public function produk()
    {
        return $this->belongsTo(MasterProduk::class, 'produk_id');
    }

    // 2. Relasi ke Master Warna
    public function warna()
    {
        return $this->belongsTo(MasterWarna::class, 'warna_id');
    }
}