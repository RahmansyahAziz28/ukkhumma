<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembelian extends Model
{
    use HasFactory;

    protected $fillable = ['id_supplier', 'tgl_beli', 'total'];

    public function detail_pembelian()
    {
        return $this->hasMany(pembelian_detail::class, 'id_pembelian');
    }

    public function supplier()
    {
        return $this->belongsTo(supplier::class, 'id_supplier');
    }
}
