<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'image',
        'size_chart',
        'discount',
        'url',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'menu_status',
        'status'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function parentcategory()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id')
                    ->select('id','name','url')
                    ->where('status',1)
                    ->orderBy('id','ASC');
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->where('status',1);
    }

    /*
    |--------------------------------------------------------------------------
    | REQUIRED METHOD → Fixes your error!
    |--------------------------------------------------------------------------
    */
    public static function getCategories($type)
    {
        $getCategories = Category::with(['subcategories.subcategories'])
            ->where('parent_id', 0)
            ->where('status',1);
            if($type == "Front"){
                $getCategories = $getCategories->where('menu_status',1);
            }
            return $getCategories->get()->toArray();
    }

    public function categoryDetails($url)
    {
        $category = self::with(['subcategories' => function($q){
            $q->with(['subcategories:id,parent_id,name']);
        }])
            ->where('url', $url)
            ->where('status', 1)
            ->first();

        if(!$category) return null;

        $catIds = [$category->id];

        foreach($category->subcategories as $subcat){
            $catIds[] = $subcat->id;

            foreach($subcat->subcategories as $subsubcat){
                $catIds[] = $subsubcat->id;
            }
        }

        $breadcrumbs = ' <nav aria-label="breadcrumb" class="breadcrumb-nav">';
        $breadcrumbs .= '<ol class="breadcrumb">';
        $breadcrumbs .= ' <li class="breadcrumb-item"><a href="' . url('/') . '"><i class="icon-home"></i></a></li>';
        if($category->parent_id == 0){
            $breadcrumbs .= '<li class="breadcrumb-item active" aria-current="page">' . $category->name . '</li>';
        }else{
            $parentCategory = self::select('name','url')
                ->where('id', $category->parent_id)
                ->first();
            if($parentCategory){
                $breadcrumbs .= '<li class="breadcrumb-item">
                <a href="' . url($parentCategory->url) . '">' . $parentCategory->name . '</a></li>';
            }
        $breadcrumbs .= '<li class="breadcrumb-item active" aria-current="page">' . $category->name . '</li>';
        }
        $breadcrumbs .= '</ol>';
        $breadcrumbs .= ' </nav>';


        return [
            'catIds' => $catIds,
            'categoryDetails' => $category,
            'breadcrumbs' => $breadcrumbs
        ];
    }
}









