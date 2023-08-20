<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengirimanProduk extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $table = 'pengiriman_produk';
    protected $primaryKey = 'pengiriman_produk_id';
    protected $fillable = ['pengiriman_id','ukuran_produk_id','jumlah'];

    public function pengiriman(){
        return $this->belongsTo(Pengiriman::class,'pengiriman_id','pengiriman_id');
    }

    public function ukuranproduk(){
        return $this->belongsTo(UkuranProduk::class,'ukuran_produk_id','ukuran_produk_id');
    }
}
