<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $promaryKey = 'id_booking';
    protected $fillable = [
        'id_product',
        'id',
        'check_in',
        'check_out',
        'token',
        'qr',
        'status',
    ];

    public function datauser()
    {
        return $this->hasOne('App\Models\User', 'id');
    }
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'id_product');
    }
}
