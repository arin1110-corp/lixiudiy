<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelKurir extends Model
{
    //
    protected $table = 'lixiudiy_kurir';
    protected $primaryKey = 'kurir_id';
    public $timestamps = false;
    protected $fillable = [
        'kurir_nama',
        'kurir_notelp',
        'kurir_alamat'
    ];
}
