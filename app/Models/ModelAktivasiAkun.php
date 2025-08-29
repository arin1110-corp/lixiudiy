<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelAktivasiAkun extends Model
{
    //
    protected $table = 'lixiudiy_aktivasi_akun';
    protected $primaryKey = 'aktivasi_id';
    public $timestamps = false;
    protected $fillable = [
        'aktivasi_customer',
        'aktivasi_token',
    ];
}
