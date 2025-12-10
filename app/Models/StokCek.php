<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokCek extends Model
{
    use HasFactory;
    protected $table = 'stok_cek';
    protected $fillable = ['produk_id', 'warna_id', 'jumlah_stok'];

    // Composite Primary Key
    protected $primaryKey = ['produk_id', 'warna_id'];
    public $incrementing = false;
    protected $keyType = 'array'; 

    public function produk()
    {
        return $this->belongsTo(MasterProduk::class, 'produk_id');
    }

    public function warna()
    {
        return $this->belongsTo(MasterWarna::class, 'warna_id');
    }
}
