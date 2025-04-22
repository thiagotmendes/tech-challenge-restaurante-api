<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category_id',
        'discount',
        'stock_quantity',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected $primaryKey = 'id';


    protected $table = 'products';
}
