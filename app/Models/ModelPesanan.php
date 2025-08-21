<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelPesanan extends Model
{
    //
    protected $table = 'lixiudiy_pesanan';
    protected $primaryKey = 'pesanan_id';
    public $timestamps = false;
    protected $fillable = [
        'pesanan_produk',
        'pesanan_customer',
        'pesanan_keranjang',
        'pesanan_tanggal',
        'pesanan_jumlah',
        'pesanan_total_harga',
        'pesanan_status'
    ];
}
