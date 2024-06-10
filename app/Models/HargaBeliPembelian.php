<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaBeliPembelian extends Model
{
    use HasFactory;

    protected $fillable = ['id_harga_beli', 'id_pembelian'];
}
