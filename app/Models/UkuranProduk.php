<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UkuranProduk extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $table = 'ukuran_produk';
    protected $primaryKey = 'ukuran_produk_id';
    protected $fillable = ['prod_id','ukuran_id','kode_produk'];

    public function pengiriman(){
        return $this->belongsToMany(Pengiriman::class,'pengiriman_produk','pengiriman_id','ukuran_produk_id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'prod_id','product_id');
    }

    public function ukuran(){
        return $this->belongsTo(Ukuran::class,'ukuran_id','ukuran_id');
    }
    public function penjualanspg(){
        return $this->belongsToMany(PenjualanSPG::class,'item_terjual','item_terjual_id','ukuran_produk');
    }
    public function itemterjual(){
        return $this->hasMany(ItemTerjual::class,'ukuran_produk','ukuran_produk_id');
    }
    public function cabangstok(){
        return $this->hasMany(CabangStok::class,'ukuran_produk','ukuran_produk_id');
    }
}
