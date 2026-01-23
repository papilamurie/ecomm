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

    public static function productStock($product_id,$size)
    {
        return self::where(['product_id'=>$product_id, 'size'=>$size, 'status'=>1])->value('stock') ?? 0;
    }
}
