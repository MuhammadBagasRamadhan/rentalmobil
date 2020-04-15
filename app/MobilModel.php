<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobilModel extends Model
{
    protected $table="mobil";
    protected $tableprimaryKey="id";
    public $timestamps=false;

    protected $fillable = [
        'nama_mobil', 'id_jenis_mobil', 'plat_nomer', 'kondisi'
    ];
}