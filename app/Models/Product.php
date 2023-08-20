<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $fillable = ['nama','warna','cat_id','harga','bahan_id'];

    public function category(){
        return $this->belongsTo(Category::class,'cat_id','categories_id');
    }

    public function warnabaju(){
        return $this->belongsTo(Warna::class,'warna', 'warna_id');
    }

    public function bahan(){
        return $this->belongsTo(Bahan::class,'bahan_id', 'bahan_id');
    }

    public function ukuran(){
        return $this->belongsToMany(Ukuran::class,'ukuran_produk','prod_id','ukuran_id')->withPivot('kode_produk');
    }

    public function ukuranproduk(){
        return $this->hasMany(UkuranProduk::class,'prod_id','product_id');
    }


}
