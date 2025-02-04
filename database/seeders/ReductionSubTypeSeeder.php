<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReductionSubTypeSeeder extends Seeder
{
    public function run(): void
    {
        $subTypes = [
            // Energy Efficiency Sub-types
            [
                're_sub_id' => 1,
                'sub_type' => 'LED Lighting',
                'emission_factor' => 0.0600, // kgCO2e reduction per kWh saved
                'unit' => 'kWh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                're_sub_id' => 2,
                'sub_type' => 'Smart HVAC System',
                'emission_factor' => 0.1200, // kgCO2e reduction per kWh saved
                'unit' => 'kWh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Sustainable Transportation Sub-types
            [
                're_sub_id' => 3,
                'sub_type' => 'Electric Vehicle',
                'emission_factor' => 2.1000, // kgCO2e reduction per liter of fuel avoided
                'unit' => 'L',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                're_sub_id' => 4,
                'sub_type' => 'Telecommuting',
                'emission_factor' => 1.8000, // kgCO2e reduction per trip avoided
                'unit' => 'trip',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Waste Reduction Sub-types
            [
                're_sub_id' => 5,
                'sub_type' => 'Medical Waste Recycling',
                'emission_factor' => 0.3200, // kgCO2e reduction per kg recycled
                'unit' => 'kg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                're_sub_id' => 6,
                'sub_type' => 'Paper Digitization',
                'emission_factor' => 0.0085, // kgCO2e reduction per sheet saved
                'unit' => 'sheet',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Water Conservation Sub-types
            [
                're_sub_id' => 7,
                'sub_type' => 'Water-Efficient Fixtures',
                'emission_factor' => 0.2500, // kgCO2e reduction per m3 saved
                'unit' => 'm³',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                're_sub_id' => 8,
                'sub_type' => 'Rainwater Harvesting',
                'emission_factor' => 0.3000, // kgCO2e reduction per m3 harvested
                'unit' => 'm³',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Green Technology Sub-types
            [
                're_sub_id' => 9,
                'sub_type' => 'Solar Panel Installation',
                'emission_factor' => 0.4000, // kgCO2e reduction per kWh generated
                'unit' => 'kWh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                're_sub_id' => 10,
                'sub_type' => 'Energy-Efficient Medical Equipment',
                'emission_factor' => 0.5500, // kgCO2e reduction per hour of operation
                'unit' => 'hr',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('reduction_sub_types')->insert($subTypes);
    }
} 