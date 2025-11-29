<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\MasterKorlap;
use App\Models\MasterProduk;
use App\Models\MasterWarna;

class DistribusiKorlap extends Model
{
    protected $table = 'distribusi_korlap';

    protected $fillable = [
        'no_nota',
        'korlap_id',
        'produk_id',
        'warna_id',
        'jumlah_cek_keluar',
        'tanggal_distribusi',
        'status',
    ];

    public function korlap(): BelongsTo
    {
        return $this->belongsTo(MasterKorlap::class, 'korlap_id');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(MasterProduk::class, 'produk_id');
    }

    public function warna(): BelongsTo
    {
        return $this->belongsTo(MasterWarna::class, 'warna_id');
    }

    public function setoran()
    {
        return $this->hasMany(SetorKorlap::class, 'distribusi_korlap_id');
    }
}
