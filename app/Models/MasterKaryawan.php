<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKaryawan extends Model
{
    use HasFactory;
    protected $table = 'master_karyawan'; // Definisi tabel eksplisit
    protected $guarded = ['id'];
}
