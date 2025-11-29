<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetorPemotong extends Model
{
    use HasFactory;
    protected $table = 'setor_pemotong';
    protected $guarded = ['id'];

    // Relasi balik ke Surat Jalan
    public function distribusi()
    {
        return $this->belongsTo(DistribusiPemotong::class, 'distribusi_pemotong_id');
    }
}
