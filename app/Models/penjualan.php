<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class penjualan extends Model
{
    //
    protected $fillable = [
        'id_member',
        'waktu',
        'batas_waktu',
        'bukti_bayar',
        'status',
        'tgl_jual',
        'total',
        'no_resi'
    ];

    public function member(){
        return $this->belongsTo('App\Models\user', 'id');
    }

    public function penjualan_detail(){
        return $this->hasMany('App\Models\penjualan_detail', 'id_penjualan');
    }
}
