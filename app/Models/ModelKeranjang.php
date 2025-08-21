<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelKeranjang extends Model
{
    //
    protected $table = 'lixiudiy_keranjang';
    protected $primaryKey = 'keranjang_id';
    public $timestamps = false;
    protected $fillable = [
        'keranjang_produk',
        'keranjang_customer',
        'keranjang_jumlah',
        'keranjang_total_harga',
        'keranjang_tanggal',
        'keranjang_status'
    ];
}
