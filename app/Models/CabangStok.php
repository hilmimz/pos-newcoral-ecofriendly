<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CabangStok extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'cabang_stok';
    protected $primaryKey = 'cabang_stok_id';
    protected $fillable = ['stok','ukuran_produk','cab_id'];

    public function cabang(){
        return $this->belongsTo(Cabang::class,'cab_id','cabang_id');
    }
    public function get_ukuran_produk(){
        return $this->belongsTo(UkuranProduk::class,'ukuran_produk','ukuran_produk_id');
    }
}
