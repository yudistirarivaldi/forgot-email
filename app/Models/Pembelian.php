<?php

namespace App\Models;

use App\Models\HargaBeli;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable = ['no_pembelian', 'tgl_pembelian'];

    public function hargaBeli()
    {
        return $this->belongsToMany(HargaBeli::class, 'harga_beli_pembelians', 'id_pembelian', 'id_harga_beli');
    }
}
