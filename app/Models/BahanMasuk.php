<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\MasterSupplier;
use App\Models\MasterWarna;

class BahanMasuk extends Model
{
    protected $table = 'bahan_masuk';

    protected $fillable = [
        'supplier_id',
        'warna_id',
        'jumlah_gulungan_masuk',
        'tanggal_masuk',
        'no_nota_supplier',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(MasterSupplier::class, 'supplier_id');
    }

    public function warna(): BelongsTo
    {
        return $this->belongsTo(MasterWarna::class, 'warna_id');
    }
}
