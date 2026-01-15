<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banners;
use Carbon\Carbon;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            ['type' => 'Slider', 'title' => 'Products On Sale', 'alt' =>'Products on Sale'],
           ['type' => 'Slider',  'title' => 'Products On 50% Sale', 'alt' =>'Products on 50% Sale'],

        ];

        foreach ($banners as $data) {
            Banners::create([
                'type'        => $data['type'],
                'title'             => $data['title'],
                'alt'              => $data['alt'],
                'image'            => '',
                'link'             => '',
                'status'           => 1,
                'sort'             => 1,
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ]);
        }
    }
}
