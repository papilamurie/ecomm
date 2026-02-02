<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Currency::truncate();
        Currency::create([
            'code' => 'GBP', 'symbol' => '£', 'name' => 'British Pound',
            'rate' => 1.00000000, 'status' =>1, 'is_base'=> true, 'flag' => 'gb.png'
        ]);
        Currency::create([
             'code' => 'USD', 'symbol' => '$', 'name' => 'US Dollar',
            'rate' => 1.27000000, 'status' =>1, 'is_base'=> false, 'flag' => 'us.png'
        ]);
        Currency::create([
             'code' => 'EUR', 'symbol' => '€', 'name' => 'Euro',
            'rate' => 1.15000000, 'status' =>1, 'is_base'=> false, 'flag' => 'eu.png'
        ]);
        Currency::create([
             'code' => 'INR', 'symbol' => '₹', 'name' => 'Indian Rupee',
            'rate' => 104.50000000, 'status' =>1, 'is_base'=> false, 'flag' => 'in.png'
        ]);
    }
}
