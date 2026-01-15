<?php

namespace App\Services\front;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Filter;
use App\Models\Product;
use App\Models\ProductsAttribute;
use Illuminate\Support\Facades\View;

class ProductService
{
    public function getCategoryListingData($url)
{
    $categoryInfo = (new Category())->categoryDetails($url);

    if (!$categoryInfo) {
        abort(404);
    }
    $query = Product::with(['product_images'])
        ->whereIn('category_id', $categoryInfo['catIds'])
        ->where('status', 1);

        //Apply filter (sort)
    $query = $this->applyFilters($query);

    $products = $query->paginate(12)->withQueryString();

    //Fetch Filters with Values
    $filters =Filter::with(['values' => function($q){
        $q->where('status',1)->orderBy('sort','asc');
    }])->where('status',1)->orderBy('sort','asc')->get();


    return [
        'categoryDetails' => $categoryInfo['categoryDetails'],
        'breadcrumbs' => $categoryInfo['breadcrumbs'],
        'categoryProducts' => $products,
        'selectedSort' => request()->get('sort', 'product_latest'),
        'url' => $url,
        'catIds' => $categoryInfo['catIds'],
        'filters' => $filters
    ];
}

private function applyFilters($query)
{
    $sort = request()->get('sort');
    switch($sort){
        case 'product_latest':
            $query->orderBy('created_at', 'desc');
            break;
        case 'lowest_price':
            $query->orderBy('final_price', 'asc');
            break;
        case 'highest_price':
            $query->orderBy('final_price', 'desc');
            break;
        case 'best_selling':
            $query->inRandomOrder(); //Sales not yet added
            break;
        case 'featured_items':
            $query->where('is_featured', 'Yes')->orderBy('created_at', 'desc');
            break;
        case 'discounted_items':
            $query->where('product_discount', '>', 0);
            break;
        default:
            $query->orderBy('created_at', 'desc');

    }

        //Apply color Filter
        if(request()->has('color') && !empty(request()->get('color'))){
            $colors = array_filter(explode('~', request()->get('color')));
            if(count($colors)>0){
                $query->whereIn('family_color', $colors);
            }
        }

        // Apply Size filter
                if (request()->has('size') && !empty(request()->get('size'))) {
                    $sizes = explode('~', request()->get('size'));

                    $getProductIds = ProductsAttribute::whereIn('size', $sizes)
                        ->where('status', 1)
                        ->pluck('product_id')
                        ->toArray();

                    if (!empty($getProductIds)) {
                        $query->whereIn('id', $getProductIds);
                    } else {
                        $query->whereRaw('0 = 1');
                    }
                }

         // Brands Apply Filter

         if(request()->has('brand') && !empty(request()->get('brand'))){
            $brands = explode('~', request()->get('brand'));
            $getBrandIds = Brand::select('id')
                    ->whereIn('name',$brands)
                    ->pluck('id')
                    ->toArray();
            $query->whereIn('brand_id', $getBrandIds);
         }

        // Apply Price Filters

        if(request()->has('price') && !empty(request()->get('price'))){
            $priceInput = str_replace("~", "-", request()->get('price'));
            $prices = explode('-', $priceInput);
            $count  = count($prices);
            if($count>=2){
                $query->whereBetween('final_price', [(int)$prices[0], (int)$prices[$count-1]]);
            }
        }

        // Apply Dynamic Admin Filters  (Fabric, Sleeve, etc)
        $filterParams = request()->all();

        foreach($filterParams as $filterKey => $filterValues){
            //skip know default filters (color,size,brand,price,sort,page,json)
            if(in_array($filterKey, ['color','size','brand','price','sort','page','json']))
            {
                continue;
            }
            //Filter values can be "~" seperated
            $selectedValues = explode('~', $filterValues);

            if(!empty($selectedValues)){
                $query->whereHas('filterValues', function($q) use ($selectedValues){
                    $q->whereIn('value', $selectedValues);
                });
            }
        }

    return $query;
}

}
