<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelLaporanPenjualan extends Model
{
    //
    protected $table = 'lixiudiy_laporan_penjualan';
    protected $primaryKey = 'laporan_id';
    public $timestamps = false;
    protected $fillable = [
        'laporan_tanggal',
        'laporan_total_produk',
        'laporan_periode_mulai',
        'laporan_periode_selesai',
        'laporan_total_pesanan',
        'laporan_total_pendapatan',
        'laporan_keterangan',
        'laporan_status'
    ];
}
