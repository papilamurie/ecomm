<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Product;

return new class extends Migration
{
    public function up(): void
    {
        // Update all existing products that have null product_url
        Product::whereNull('product_url')->get()->each(function($product){
            $product->product_url = Str::slug($product->product_name) . '-' . uniqid();
            $product->save();
        });
    }

    public function down(): void
    {
        // Optional: remove all values
        Product::query()->update(['product_url' => null]);
    }
};

