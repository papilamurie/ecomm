<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Carbon\Carbon;

class CategoryTableSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['parent_id' => 0, 'name' => 'Clothing', 'url' => 'clothing'],
            ['parent_id' => 0, 'name' => 'Electronics', 'url' => 'electronics'],
            ['parent_id' => 0, 'name' => 'Appliances', 'url' => 'appliances'],
            ['parent_id' => 1, 'name' => 'Men', 'url' => 'men'],
            ['parent_id' => 1, 'name' => 'Women', 'url' => 'women'],
            ['parent_id' => 1, 'name' => 'Kids', 'url' => 'kids'],
        ];

        foreach ($categories as $data) {
            Category::create([
                'parent_id'        => $data['parent_id'],
                'name'             => $data['name'],
                'url'              => $data['url'],
                'image'            => '',
                'size_chart'       => '',
                'discount'         => 0,
                'description'      => '',        // FIXED
                'meta_title'       => '',
                'meta_description' => '',
                'meta_keywords'    => '',
                'status'           => 1,
                'menu_status'      => 1,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ]);
        }
    }
}
