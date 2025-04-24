<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];


    protected $table = 'order_items';

    public function product()
    {
        return $this->belongsTo(\App\Models\Products::class, 'product_id');
    }
}
