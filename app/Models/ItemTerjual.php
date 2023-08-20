<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemTerjual extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'item_terjual';
    protected $primaryKey = 'item_terjual_id';
    protected $fillable = ['waktu','jumlah','ukuran_produk','penjualan_id'];

    public function penjualanspg(){
        return $this->belongsTo(PenjualanSPG::class,'penjualan_id','penjualan_spg_id');
    }
    public function ukuranproduk(){
        return $this->belongsTo(UkuranProduk::class,'ukuran_produk','ukuran_produk_id');
    }
}
