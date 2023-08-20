<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'pengiriman';
    protected $primaryKey = 'pengiriman_id';
    protected $fillable = ['cab_id','tanggal_pengiriman','status','penerima','keterangan_penerimaan'];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cab_id', 'cabang_id');
    }

    public function ukuranproduk(){
        return $this->belongsToMany(UkuranProduk::class,'pengiriman_produk','pengiriman_id','ukuran_produk_id');
    }

    public function pengirimanproduk(){
        return $this->hasMany(PengirimanProduk::class,'pengiriman_id','pengiriman_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'penerima','user_id');
    }
}
