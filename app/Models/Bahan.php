<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'bahan_kain';
    protected $primaryKey = 'bahan_id';
    protected $fillable = ['nama'];

    public function product()
    {
        return $this->hasMany(Product::class, 'bahan_id', 'bahan_id');
    }
}
