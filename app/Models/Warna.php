<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warna extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $table = 'warna';
    protected $primaryKey = 'warna_id';
    protected $fillable = ['nama'];

    public function product()
    {
        return $this->hasMany(Product::class, 'warna', 'warna_id');
    }
}
