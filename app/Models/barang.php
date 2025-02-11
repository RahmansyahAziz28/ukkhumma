<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    //
    protected $fillable = [
        'id_kategori',
        'nama_barang',
        'detail_barang',
        'berat',
        'harga_jual',
        'harga_beli',
        'foto',
        'stok'
    ];

    public function kategori()
    {
        return $this->belongsTo('App\Models\kategori', 'id_kategori');
    }

    public function pembelian_detail()
    {
        return $this->hasMany('App\Models\pembelian_detail', 'id_barang');
    }
}
