<?php

namespace App\Services\front;
use App\Models\Banners;
use App\Models\Category;
use App\Models\Product;

class IndexService
{
    public function getHomePageBanner(){
        $homeSliderBanner = Banners::where('type', 'Slider')
        ->where('status',1)
        ->orderBy('sort','DESC')
        ->get()
        ->toArray();
        $homeFixBanner = Banners::where('type', 'Fix')
        ->where('status',1)
        ->orderBy('sort','DESC')
        ->get()
        ->toArray();
        $homeLogoBanner = Banners::where('type', 'Logo')
        ->where('status',1)
        ->orderBy('sort','DESC')
        ->get()
        ->toArray();
    return compact('homeSliderBanner','homeFixBanner','homeLogoBanner');
    }

    public function featuredProducts()
{
    return Product::with(['product_images', 'category'])
        ->where('is_featured', 'Yes')
        ->where('status', 1)
        ->where('stock', '>', 0)
        ->inRandomOrder()
        ->limit(8)
        ->get();

}

public function newArrivalProducts()
{
    return Product::with(['product_images', 'category'])
        ->where('status', 1)
        ->where('stock', '>', 0)
        ->latest()
        ->limit(8)
        ->get();
}

    public function homeCategories()
    {
        $categories = Category::select('id','name','image','url')
        ->where(function ($q) {
            $q->whereNull('parent_id')
            ->orWhere('parent_id', 0);
        }) // Parent Categories (NULL or 0)
        ->where('status', 1)       // Only Active Categories
        ->where('menu_status', 1)
        ->get()
        ->map(function ($category) {

            $allCategoryIds = $this->getAllCategoryIds($category->id);

            $productCount = Product::whereIn('category_id', $allCategoryIds)
                ->where('status', 1)
                ->where('stock', '>', 0)
                ->count();

            return [
                'id'            => $category->id,
                'name'          => $category->name,
                'image'         => $category->image,
                'url'           => $category->url,
                'product_count' => $productCount
            ];
        });

    return ['categories' => $categories->toArray()];
    }

    private function getAllCategoryIds($parentId)
    {
        $categoryIds = [$parentId]; // Start with the current parent category
        $childIds = Category::where('parent_id',$parentId)
        ->where('status',1)
        ->pluck('id'); // Get child category Ids
        foreach($childIds as $childId){
            $categoryIds = array_merge($categoryIds, $this->getAllCategoryIds($childId));
        }

        return $categoryIds;

    }
}
