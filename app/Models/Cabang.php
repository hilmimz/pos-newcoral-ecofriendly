<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'cabang';
    protected $primaryKey = 'cabang_id';
    protected $fillable = ['nama'];

    public function pengiriman(){
        return $this->hasMany(Pengiriman::class,'cab_id','cabang_id');
    }
    public function cabangstok(){
        return $this->hasMany(CabangStok::class,'cab_id','cabang_id');
    }
}
