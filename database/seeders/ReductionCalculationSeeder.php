<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReductionCalculationSeeder extends Seeder
{
    public function run(): void
    {
        // Get emission factors from sub-types
        $reductionFactors = DB::table('reduction_sub_types')
            ->pluck('emission_factor', 're_sub_id')
            ->toArray();
        
        $calculations = [];
        
        // Sample user IDs (assuming we have users with IDs 1-5)
        $userIds = [1, 2, 3, 4, 5];
        
        // Generate data for the last 12 months
        for ($month = 1; $month <= 12; $month++) {
            foreach ($userIds as $userId) {
                // LED Lighting reductions
                $amount = rand(500, 1000); // Monthly energy saved in kWh
                $calculations[] = [
                    're_id' => 1, // Energy Efficiency
                    're_sub_id' => 1, // LED Lighting
                    'user_id' => $userId,
                    'amount' => $amount,
                    'total_cf' => $amount * $reductionFactors[1], // Calculate total carbon footprint reduction
                    'month' => $month,
                    'year' => 2024,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Electric Vehicle usage
                $amount = rand(50, 150); // Monthly fuel avoided in liters
                $calculations[] = [
                    're_id' => 2, // Sustainable Transportation
                    're_sub_id' => 3, // Electric Vehicle
                    'user_id' => $userId,
                    'amount' => $amount,
                    'total_cf' => $amount * $reductionFactors[3],
                    'month' => $month,
                    'year' => 2024,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Medical Waste Recycling
                $amount = rand(50, 150); // Monthly recycled waste in kg
                $calculations[] = [
                    're_id' => 3, // Waste Reduction
                    're_sub_id' => 5, // Medical Waste Recycling
                    'user_id' => $userId,
                    'amount' => $amount,
                    'total_cf' => $amount * $reductionFactors[5],
                    'month' => $month,
                    'year' => 2024,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Water-Efficient Fixtures
                $amount = rand(100, 300); // Monthly water saved in m³
                $calculations[] = [
                    're_id' => 4, // Water Conservation
                    're_sub_id' => 7, // Water-Efficient Fixtures
                    'user_id' => $userId,
                    'amount' => $amount,
                    'total_cf' => $amount * $reductionFactors[7],
                    'month' => $month,
                    'year' => 2024,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Solar Panel Installation
                $amount = rand(1000, 2000); // Monthly energy generated in kWh
                $calculations[] = [
                    're_id' => 5, // Green Technology
                    're_sub_id' => 9, // Solar Panel Installation
                    'user_id' => $userId,
                    'amount' => $amount,
                    'total_cf' => $amount * $reductionFactors[9],
                    'month' => $month,
                    'year' => 2024,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert in chunks to avoid memory issues
        foreach (array_chunk($calculations, 100) as $chunk) {
            DB::table('reduction_calculations')->insert($chunk);
        }
    }
} 