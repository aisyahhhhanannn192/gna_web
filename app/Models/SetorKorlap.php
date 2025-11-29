<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetorKorlap extends Model
{
    use HasFactory;

    protected $table = 'setor_korlap'; // Pastikan nama tabel sesuai migrasi
    protected $guarded = ['id'];

    // Relasi ke Nota Distribusi
    public function distribusi()
    {
        return $this->belongsTo(DistribusiKorlap::class, 'distribusi_korlap_id');
    }

    // Relasi ke Korlap
    public function korlap()
    {
        return $this->belongsTo(MasterKorlap::class, 'korlap_id');
    }
}