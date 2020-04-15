<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenyewaModel extends Model
{
    protected $table="penyewa";
    protected $tableprimaryKey="id";
    public $timestamps=false;

    protected $fillable = [
        'nama_penyewa', 'telp', 'no_ktp', 'alamat'
    ];
}