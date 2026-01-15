<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsAttribute;

class ProductsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
{
    $product = Product::first(); // or find by SKU

    if (! $product) {
        return; // safety guard
    }

    ProductsAttribute::insert([
        [
            'product_id' => $product->id,
            'price' => 1000,
            'size' => 'Small',
            'sku' => 'RT001-S',
            'sort' => 1,
            'status' => 1,
            'stock' => 10,
        ],
        [
            'product_id' => $product->id,
            'price' => 1600,
            'size' => 'Medium',
            'sku' => 'RT001-M',
            'sort' => 2,
            'status' => 1,
            'stock' => 20,
        ],
        [
            'product_id' => $product->id,
            'price' => 1700,
            'size' => 'Large',
            'sku' => 'RT001-L',
            'sort' => 3,
            'status' => 1,
            'stock' => 15,
        ],
    ]);
}
}
