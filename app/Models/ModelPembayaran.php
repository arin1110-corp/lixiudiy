<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelPembayaran extends Model
{
    //
    protected $table = 'lixiudiy_pembayaran';
    protected $primaryKey = 'pembayaran_id';
    public $timestamps = false;
    protected $fillable = [
        'pembayaran_pesanan',
        'pembayaran_jumlah',
        'pembayaran_tanggal',
        'pembayaran_metode',
        'pembayaran_status',
        'pembayaran_keterangan'
    ];
}
