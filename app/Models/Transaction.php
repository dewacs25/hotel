<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $primaryKey = 'id_transaction';
    protected $fillable = [
        'id_product',
        'token',
        'check_in',
        'check_out',
        'email',
        'name',
        'harga',
        'status',
        'expire'
    ];

    public function product()
    {
        return $this->BelongsTo('App\Models\Product','id_product');
    }
}
