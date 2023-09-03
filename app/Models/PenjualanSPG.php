<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanSPG extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'penjualan_spg';
    protected $primaryKey = 'penjualan_spg_id';
    protected $fillable = ['tanggal', 'waktu','spg_id','metode_pembayaran','cabang_id','is_fo'];

    public function ukuranproduk(){
        return $this->belongsToMany(UkuranProduk::class,'item_terjual','item_terjual_id','ukuran_produk');
    }

    public function user(){
        return $this->belongsTo(UsersModel::class,'spg_id','user_id');
    }
    public function itemterjual(){
        return $this->hasMany(ItemTerjual::class,'penjualan_id','penjualan_spg_id');
    }
    public function metodepembayaran(){
        return $this->belongsTo(MetodePembayaran::class,'metode_pembayaran','metode_pembayaran_id');
    }
    public function cabang(){
        return $this->belongsTo(Cabang::class,'cabang_id','cabang_id');
    }
}
