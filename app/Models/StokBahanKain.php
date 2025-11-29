<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\MasterWarna;

class StokBahanKain extends Model
{
    protected $table = 'stok_bahan_kain';

    protected $fillable = [
        'warna_id',
        'jumlah_gulungan',
    ];

    public function warna(): BelongsTo
    {
        return $this->belongsTo(MasterWarna::class, 'warna_id');
    }
}
