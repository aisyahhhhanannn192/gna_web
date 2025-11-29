<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPemotong extends Model
{
    use HasFactory;

    // BARIS INI YANG HILANG/KURANG:
    protected $table = 'master_pemotong'; 
    
    protected $guarded = ['id'];
}
