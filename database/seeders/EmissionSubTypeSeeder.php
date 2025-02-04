<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmissionSubTypeSeeder extends Seeder
{
    public function run(): void
    {
        $subTypes = [
            // Electricity Consumption Sub-types
            [
                'em_sub_id' => 1,
                'sub_type' => 'Grid Electricity',
                'emission_factor' => 0.4612, // kgCO2e per kWh
                'unit' => 'kWh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'em_sub_id' => 2,
                'sub_type' => 'Solar Power',
                'emission_factor' => 0.0455, // kgCO2e per kWh
                'unit' => 'kWh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Transportation Sub-types
            [
                'em_sub_id' => 3,
                'sub_type' => 'Diesel Vehicle',
                'emission_factor' => 2.6876, // kgCO2e per liter
                'unit' => 'L',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'em_sub_id' => 4,
                'sub_type' => 'Petrol Vehicle',
                'emission_factor' => 2.3154, // kgCO2e per liter
                'unit' => 'L',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Waste Management Sub-types
            [
                'em_sub_id' => 5,
                'sub_type' => 'Medical Waste',
                'emission_factor' => 0.5263, // kgCO2e per kg
                'unit' => 'kg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'em_sub_id' => 6,
                'sub_type' => 'General Waste',
                'emission_factor' => 0.2532, // kgCO2e per kg
                'unit' => 'kg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Water Consumption Sub-types
            [
                'em_sub_id' => 7,
                'sub_type' => 'Tap Water',
                'emission_factor' => 0.3440, // kgCO2e per m3
                'unit' => 'm³',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'em_sub_id' => 8,
                'sub_type' => 'Wastewater Treatment',
                'emission_factor' => 0.7080, // kgCO2e per m3
                'unit' => 'm³',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Medical Equipment Sub-types
            [
                'em_sub_id' => 9,
                'sub_type' => 'X-ray Machine',
                'emission_factor' => 0.8900, // kgCO2e per hour
                'unit' => 'hr',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'em_sub_id' => 10,
                'sub_type' => 'MRI Scanner',
                'emission_factor' => 1.2500, // kgCO2e per hour
                'unit' => 'hr',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('emission_sub_types')->insert($subTypes);
    }
} 