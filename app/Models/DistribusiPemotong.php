<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistribusiPemotong extends Model
{
    use HasFactory;
    protected $table = 'distribusi_pemotong';
    protected $guarded = ['id'];

    // Relasi ke Pemotong
    public function pemotong()
    {
        return $this->belongsTo(MasterPemotong::class, 'pemotong_id');
    }

    // Relasi ke Produk (Target)
    public function produk()
    {
        return $this->belongsTo(MasterProduk::class, 'produk_id');
    }

    // Relasi ke Warna
    public function warna()
    {
        return $this->belongsTo(MasterWarna::class, 'warna_id');
    }

    // Relasi ke Anak (Setoran)
    public function setoran()
    {
        return $this->hasOne(SetorPemotong::class, 'distribusi_pemotong_id');
    }
}
