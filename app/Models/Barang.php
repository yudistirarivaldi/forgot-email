<?php

namespace App\Models;

use App\Models\HargaBeli;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
     use HasFactory;

     protected $fillable = ['nama_barang'];

     public function hargaBeli()
    {
        return $this->hasMany(HargaBeli::class, 'id_barang');
    }
}
