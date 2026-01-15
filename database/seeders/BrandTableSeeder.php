<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
use Carbon\Carbon as CarbonAlias;
use Illuminate\Support\Carbon;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brandRecords = [
            [
                'name' => 'Arrow', 'image' => '', 'logo' => '', 'discount' => 0, 'description' => '', 'url'=>'arrow',
                'meta_title' =>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1, 'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'name' => 'Gap', 'image' => '', 'logo' => '', 'discount' => 0, 'description' => '', 'url'=>'gap',
                'meta_title' =>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1, 'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'name' => 'Monte Carlo', 'image' => '', 'logo' => '', 'discount' => 0, 'description' => '', 'url'=>'monte-carlo',
                'meta_title' =>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1, 'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'name' => 'Peter England', 'image' => '', 'logo' => '', 'discount' => 0, 'description' => '', 'url'=>'peter-england',
                'meta_title' =>'', 'meta_description'=>'', 'meta_keywords'=>'', 'status'=>1, 'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
        ];
        Brand::insert($brandRecords);
    }
}
