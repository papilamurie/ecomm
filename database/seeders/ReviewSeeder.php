<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Review::create(['product_id'=>1,'user_id'=>1,'rating'=>5,'review'=>'Excellent Product!','status'=>1]);
        Review::create(['product_id'=>2,'user_id'=>1,'rating'=>3,'review'=>'Average Quality!','status'=>1]);
    }
}
