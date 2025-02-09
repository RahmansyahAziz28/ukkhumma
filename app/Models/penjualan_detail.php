<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class penjualan_detail extends Model
{
    //
    protected $fillable = [
        'id_penjualan',
        'id_barang',
        'jumlah_jual',
        'sub_total'
    ];

    public function penjualan()
    {
        return $this->belongsTo(penjualan::class, 'id_penjualan');
    }

    public function barang()
    {
        return $this->belongsTo(barang::class, 'id_barang');
    }
}
