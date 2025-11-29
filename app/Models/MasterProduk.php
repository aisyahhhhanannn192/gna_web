<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProduk extends Model
{
    use HasFactory;
    protected $table = 'master_produk';
    protected $guarded = ['id'];
}
