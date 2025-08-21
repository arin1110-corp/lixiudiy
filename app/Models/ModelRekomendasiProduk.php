<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelRekomendasiProduk extends Model
{
    //
    protected $table = 'lixiudiy_rekomendasi_produk';
    protected $primaryKey = 'rekomendasi_id';
    public $timestamps = false;
    protected $fillable = [
        'rekomendasi_nama',
        'rekomendasi_produk',
        'rekomendasi_tanggal',
        'rekomendasi_status',
        'rekomendasi_keterangan'
    ];
}
