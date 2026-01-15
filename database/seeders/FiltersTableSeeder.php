<?php

namespace Database\Seeders;

use App\Models\Filter;
use App\Models\FilterValue;
use Illuminate\Database\Seeder;

class FiltersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create filters
        $fabric = Filter::create([
            'filter_name' => 'Fabric',
            'sort'        => 1,
            'status'      => 1
        ]);

        $sleeve = Filter::create([
            'filter_name' => 'Sleeve',
            'sort'        => 2,
            'status'      => 1
        ]);

        // Insert filter values with timestamps
        FilterValue::insert([
            [
                'filter_id'  => $fabric->id,
                'value'      => 'Cutton',
                'sort'       => 1,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'filter_id'  => $fabric->id,
                'value'      => 'Polyester',
                'sort'       => 2,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'filter_id'  => $sleeve->id,
                'value'      => 'Full Sleeve',
                'sort'       => 1,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'filter_id'  => $sleeve->id,
                'value'      => 'Half Sleeve',
                'sort'       => 2,
                'status'     => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
