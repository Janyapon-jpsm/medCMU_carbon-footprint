<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmissionTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'em_id' => 1,
                'type' => 'Electricity Consumption',
                'detail' => 'Emissions from electricity usage in facilities',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'em_id' => 2,
                'type' => 'Transportation',
                'detail' => 'Emissions from vehicles and transportation activities',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'em_id' => 3,
                'type' => 'Waste Management',
                'detail' => 'Emissions from waste disposal and treatment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'em_id' => 4,
                'type' => 'Water Consumption',
                'detail' => 'Emissions from water usage and treatment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'em_id' => 5,
                'type' => 'Medical Equipment',
                'detail' => 'Emissions from medical equipment usage and maintenance',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('emission_types')->insert($types);
    }
} 