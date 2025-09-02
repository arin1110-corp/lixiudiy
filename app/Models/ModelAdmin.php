<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelAdmin extends Model
{
    //
    protected $table = 'lixiudiy_admin';
    protected $primaryKey = 'admin_id';
    public $timestamps = false;
    protected $fillable = [
        'admin_nama',
        'admin_password',
        'admin_email',
        'admin_tanggaldibuat',
        'admin_status'
    ];
}
