<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterWarna extends Model
{
    use HasFactory;
    protected $table = 'master_warna'; // Definisi nama tabel eksplisit
    protected $guarded = ['id'];
}
