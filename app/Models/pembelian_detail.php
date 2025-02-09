<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembelian_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pembelian',
        'id_barang',
        'jumlah_beli',
        'sub_total'
    ];

    public function pembelian()
    {
        return $this->belongsTo(pembelian::class, 'id_pembelian');
    }

    public function barang()
    {
        return $this->belongsTo(barang::class, 'id_barang');
    }
}
