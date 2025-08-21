<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelPengiriman extends Model
{
    //
    protected $table = 'lixiudiy_pengiriman';
    protected $primaryKey = 'pengiriman_id';
    public $timestamps = false;
    protected $fillable = [
        'pengiriman_pesanan',
        'pengiriman_alamat',
        'pengiriman_jasakurir',
        'pengiriman_nomor_resi',
        'pengiriman_tanggal',
        'pengiriman_status',
        'pengiriman_keterangan'
    ];
}
