<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductsAttribute extends Model
{
    protected $table = 'products_attributes';

    protected $fillable = [
        'product_id',
        'sku',
        'size',
        'price',
        'stock',
        'sort',
        'status',
    ];
}
