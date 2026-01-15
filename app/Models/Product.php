<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductsImage;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'product_name',
        'product_price',
        'product_discount',
        'final_price',
        'main_image',
        'stock', // <-- add this
        'status',
        'is_featured',
        'group_code',
        'discount_applied_on',
        // add other fields you want mass-assignable
    ];
    public function category(){
        return $this->belongsTo('App\Models\Category','category_id')->with('parentcategory');
    }

    public function product_images(){
        return $this->hasMany(ProductImage::class)->orderBy('sort','asc');
    }

    public function attributes(){
        return $this->hasMany('App\Models\ProductsAttribute');
    }

    public function filterValues(){
        return $this->belongsToMany(FilterValue::class, 'product_filter_values', 'product_id', 'filter_value_id');
    }
}
