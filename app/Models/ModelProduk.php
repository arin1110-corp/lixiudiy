<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelProduk extends Model
{
    //
    protected $table = 'lixiudiy_produk';
    protected $primaryKey = 'produk_id';
    public $timestamps = false;
    protected $fillable = [
        'produk_nama',
        'produk_deskripsi',
        'produk_harga',
        'produk_tanggalmasuk',
        'produk_stok',
        'produk_gambar',
        'produk_status',
        'produk_kategori'
    ];
}
