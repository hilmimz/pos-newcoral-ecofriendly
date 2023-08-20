<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ukuran extends Model
{
    use HasFactory;

    protected $table = 'ukuran';
    protected $primaryKey = 'ukuran_id';
    protected $fillable = ['nama'];

    public function product(){
        return $this->belongsToMany(Product::class,'ukuran_produk','prod_id','ukuran_id');
    }

    public function ukuranproduk(){
        return $this->hasMany(UkuranProduk::class,'ukuran_id','ukuran_id');
    }
}
