<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    /**
     * Get the user that owns the penjualan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_member','id');
    }

    public function penjualan_detail(){
        return $this->hasMany('App\Models\penjualan_detail', 'id_penjualan');
    }
}
