<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\MasterReseller;
use App\Models\MasterProduk;
use App\Models\MasterWarna;

class TransaksiReseller extends Model
{
    protected $table = 'transaksi_reseller';

    protected $fillable = [
        'no_invoice',
        'reseller_id',
        'produk_id',
        'warna_id',
        'jumlah_keluar',
        'harga_satuan',
        'total_harga',
        'tanggal_transaksi',
    ];

    public function reseller(): BelongsTo
    {
        return $this->belongsTo(MasterReseller::class, 'reseller_id');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(MasterProduk::class, 'produk_id');
    }

    public function warna(): BelongsTo
    {
        return $this->belongsTo(MasterWarna::class, 'warna_id');
    }
}
