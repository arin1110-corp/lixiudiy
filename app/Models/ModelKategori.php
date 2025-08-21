<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelKategori extends Model
{
    //
    protected $table = 'lixiudiy_kategori';
    protected $primaryKey = 'kategori_id';
    public $timestamps = false;
    protected $fillable = [
        'kategori_nama',
        'kategori_slug',
        'kategori_deskripsi',
        'kategori_gambar',
        'kategori_status'
    ];
}
