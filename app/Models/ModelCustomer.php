<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelCustomer extends Model
{
    //
    protected $table = 'lixiudiy_customer';
    protected $primaryKey = 'customer_id';
    public $timestamps = false;
    protected $fillable = [
        'customer_nama',
        'customer_email',
        'customer_password',
        'customer_tanggaldaftar',
        'customer_tanggallahir',
        'customer_status',
        'customer_alamat',
        'customer_telepon'
    ];
}
