<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'metode_pembayaran';
    protected $primaryKey = 'metode_pembayaran_id';
    protected $fillable = ['nama'];

    public function penjualanspg(){
        return $this->hasMany(PenjualanSPG::class,'metode_pembayaran','metode_pembayaran_id');
    }
}
