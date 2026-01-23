<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $menTShirtsCategory = Category::where('name', 'Men T-Shirts')->first();
       if ($menTShirtsCategory){
        product::create([
            'category_id' => $menTShirtsCategory->id,
            'brand_id' => 1,
            'admin_id' => 1,
            'admin_type' => 'admin',
            'product_name' => 'Blue T-Shirt',
            'product_url' => Str::slug('blue-t-shirt') . '-' . uniqid(),
            'product_code' => 'BT001',
            'product_color' => 'Dark Blue',
            'family_color' => 'Blue',
            'group_code' => 'BT000',
            'product_price' => 1000,
            'product_discount' => 10,
            'product_discount_amount' => 100,
            'discount_applied_on' => 'product',
            'product_gst' => 12,
            'final_price' => 900,
            'main_image'=>'',
            'product_weight' => 500,
            'product_video' => '',
            'description' => 'Test Product',
            'wash_care' => '',
            'search_keywords' => '',
            'fabric' => '',
            'pattern' => '',
            'sleeve' => '',
            'fit' => '',
            'occassion' => '',
            'stock' => 10,
            'sort' => 1,
            'meta_title' => '',
            'meta_description' => '',
            'meta_keywords' => '',
            'is_featured' => 'No',
            'status' => 1,
            'created_at' => Carbon::Now(),
            'updated_at' => Carbon::Now(),
        ]);
         product::create([
            'category_id' => $menTShirtsCategory->id,
            'brand_id' => 1,
            'admin_id' => 1,
            'admin_type' => 'admin',
            'product_name' => 'Red T-Shirt',
            'product_url' => Str::slug('red-t-shirt') . '-' . uniqid(),
            'product_code' => 'RT001',
            'product_color' => 'Red',
            'family_color' => 'Red',
            'group_code' => 'RT000',
            'product_price' => 1000,
            'product_discount' => 10,
            'product_discount_amount' => 100,
            'discount_applied_on' => 'product',
            'product_gst' => 12,
            'final_price' => 900,
            'main_image'=>'',
            'product_weight' => 500,
            'product_video' => '',
            'description' => 'Test Product',
            'wash_care' => '',
            'search_keywords' => '',
            'fabric' => '',
            'pattern' => '',
            'sleeve' => '',
            'fit' => '',
            'occassion' => '',
            'stock' => 10,
            'sort' => 1,
            'meta_title' => '',
            'meta_description' => '',
            'meta_keywords' => '',
            'is_featured' => 'No',
            'status' => 1,
            'created_at' => Carbon::Now(),
            'updated_at' => Carbon::Now(),
        ]);
       }
    }
}
