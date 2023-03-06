<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'id_product';
    protected $fillable = [
        'nama_product',
        'deskripsi',
        'gambar',
        'harga',
        'status',
    ];

    public function transaction()
    {
        return $this->hasOne('App\Models\Transaction', 'id_product');
    }
}
