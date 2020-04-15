<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detailModel extends Model
{
    protected $table="detail_transaksi";
    protected $tableprimaryKey="id";
    public $timestamps=false;

    protected $fillable = [
        'id_transaksi', 'id_jenis_mobil', 'subtotal', 'qty',
    ];
}