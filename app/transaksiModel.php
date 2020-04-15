<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transaksiModel extends Model
{
    protected $table="transaksi";
    protected $tableprimaryKey="id";
    public $timestamps=false;

    protected $fillable = [
        'id_mobil', 'id_penyewa', 'id_petugas', 'tgl_transaksi', 'tgl_selesai'
    ];
}

