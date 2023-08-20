<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class UsersModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = ['nama','username','password'];
    protected $hidden = ['created_at','updated_at'];

    public function penjualanspg(){
        return $this->hasMany(PenjualanSPG::class,'spg_id','user_id');
    }

    public function pengiriman(){
        return $this->hasMany(Pengiriman::class,'penerima','user_id');
    }
}
