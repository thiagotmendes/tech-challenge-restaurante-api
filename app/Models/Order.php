<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'client_id',
        'total',
        'status',
    ];

    protected $table = 'orders';

    public function items()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }

}
