<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokCek extends Model
{
    use HasFactory;
    protected $table = 'stok_cek';
    protected $guarded = []; // Tidak ada kolom ID auto-increment

    // PENTING: Beritahu Laravel kalau ini gak punya 'id' biasa
    protected $primaryKey = null; 
    public $incrementing = false; 

    public function produk()
    {
        return $this->belongsTo(MasterProduk::class, 'produk_id');
    }

    public function warna()
    {
        return $this->belongsTo(MasterWarna::class, 'warna_id');
    }
}
