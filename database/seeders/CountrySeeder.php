<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/data/countries.json');
        if(!File::exists($path))
            {
                $this->command->error("countries.json not found at database/seeders/data/countries.json. Create it and add full list");
                return;
            }
            $json = File::get($path);
            $items = json_decode($json, true);
            foreach($items as $c){
                Country::updateOrCreate(
                    ['name' => $c['name']],
                    ['iso_code' => $c['iso_code'] ?? null, 'is_active'=>true]
                );
            }
            $this->command->info('Countries seeded:' . count($items));

    }
}
