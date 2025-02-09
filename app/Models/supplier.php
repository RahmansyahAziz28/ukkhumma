<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    use HasFactory;

    protected $fillable = ['nama_supplier', 'no_telp', 'alamat_supplier'];

    public function pembelian(){
        return $this->hasMany('App\Models\pembelian', 'id_supplier');
    }
}
