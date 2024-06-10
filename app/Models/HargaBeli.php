<?php

namespace App\Models;

use App\Models\Pembelian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HargaBeli extends Model
{
    use HasFactory;

    protected $fillable = ['id_barang', 'harga_beli'];

    public function pembelian()
    {
        return $this->belongsToMany(Pembelian::class, 'harga_beli_pembelians', 'id_harga_beli', 'id_pembelian');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
