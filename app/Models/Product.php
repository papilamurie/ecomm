<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductsImage;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use Searchable;

    protected $fillable = [
        'category_id',
        'product_name',
        'product_price',
        'product_discount',
        'final_price',
        'main_image',
        'stock',
        'status',
        'is_featured',
        'group_code',
        'discount_applied_on',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')
                    ->with('parentcategory');
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'products_categories',
            'product_id',
            'category_id'
        );
    }

    public function product_images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort', 'asc');
    }

    public function brand(){
        return $this->belongsTo(\App\Models\Brand::class, 'brand_id');
    }

    public function attributes()
    {
        return $this->hasMany(ProductsAttribute::class);
    }

    public function reviews(){
        return $this->hasMany(\App\Models\Review::class,'product_id');
    }

    public function averageRating(){
        return (float) $this->reviews()->where('status',1)->avg('rating') ?? 0;
    }

    public function filterValues()
    {
        return $this->belongsToMany(
            FilterValue::class,
            'product_filter_values',
            'product_id',
            'filter_value_id'
        );
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'category' => $this->category->name ?? null,
        ];
    }

    public static function getAttributePrice($product_id, $size)
    {
        $attribute = ProductsAttribute::where([
            'product_id' => $product_id,
            'size' => $size,
            'status' => 1
        ])->first();
        if(!$attribute){
            return ['status' => false];
        }

        $basePrice = (float) $attribute->price;
        $product = self::select('id','category_id','brand_id','product_discount')
                               ->where('id', $product_id)
                               ->first();
        if(!$product){
            return ['status' => false];
        }

        $productDisc = (float) ($product->product_discount ?? 0);
        $categoryDisc = 0;
        if($product->category_id){
            $cat = Category::select('discount')->find($product->category_id);
            $categoryDisc = (float) ($cat->discount ?? 0);
        }


        $brandDisc = 0;
        if($product->brand_id){
            $brand = Brand::select('discount')->find($product->brand_id);
            $brandDisc = (float) ($brand->discount ?? 0);
        }

        $applied = 0;
        if($productDisc >0 ){
            $applied = $productDisc;
        }elseif($categoryDisc > 0){
            $applied = $categoryDisc;
        }elseif($brandDisc > 0){
            $applied = $brandDisc;
        }

            $final = $applied > 0 ? round($basePrice - ($basePrice * $applied/100)) : round($basePrice);
            $discountAmt = $basePrice - $final;
            return [
                'status' => true,
                'product_price' => (int) $basePrice,
                'final_price' => (int) $final,
                'discount' => (int) $discountAmt,
                'percent' => (int) $applied,
                'product_price_formatted' => formatCurrency($basePrice),
                'final_price_formatted' => formatCurrency($final),
                'product_price_display' => formatCurrency($basePrice),
                'final_price_display' => formatCurrency($final),
            ];

    }

    public static function productStatus($product_id)
    {
        return self::where('id',$product_id)->value('status');
    }
}
