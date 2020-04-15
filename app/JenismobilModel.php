<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenismobilModel extends Model
{
    protected $table="jenis_mobil";
    protected $tableprimaryKey="id";
    public $timestamps=false;

    protected $fillable = [
        'jenis_mobil', 'harga_perhari'
    ];
}
