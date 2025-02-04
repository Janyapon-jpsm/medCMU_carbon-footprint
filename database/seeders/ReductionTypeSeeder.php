<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReductionTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                're_id' => 1,
                'type' => 'Energy Efficiency',
                'detail' => 'Measures to reduce energy consumption and improve efficiency',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                're_id' => 2,
                'type' => 'Sustainable Transportation',
                'detail' => 'Initiatives to reduce transportation-related emissions',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                're_id' => 3,
                'type' => 'Waste Reduction',
                'detail' => 'Programs to minimize waste generation and improve recycling',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                're_id' => 4,
                'type' => 'Water Conservation',
                'detail' => 'Measures to reduce water consumption and improve efficiency',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                're_id' => 5,
                'type' => 'Green Technology',
                'detail' => 'Implementation of environmentally friendly technologies',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('reduction_types')->insert($types);
    }
} 