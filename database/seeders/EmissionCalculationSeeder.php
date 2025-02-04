<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmissionCalculationSeeder extends Seeder
{
    public function run(): void
    {
        // Get emission factors from sub-types
        $emissionFactors = DB::table('emission_sub_types')
            ->pluck('emission_factor', 'em_sub_id')
            ->toArray();
        
        $calculations = [];
        
        // Sample user IDs (assuming we have users with IDs 1-5)
        $userIds = [1, 2, 3, 4, 5];
        
        // Generate data for the last 12 months
        for ($month = 1; $month <= 12; $month++) {
            foreach ($userIds as $userId) {
                // Electricity consumption calculations
                $amount = rand(5000, 8000); // Monthly electricity usage in kWh
                $calculations[] = [
                    'em_id' => 1, // Electricity Consumption
                    'em_sub_id' => 1, // Grid Electricity
                    'user_id' => $userId,
                    'amount' => $amount,
                    'total_cf' => $amount * $emissionFactors[1], // Calculate total carbon footprint
                    'month' => $month,
                    'year' => 2024,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Transportation calculations
                $amount = rand(100, 300); // Monthly fuel consumption in liters
                $calculations[] = [
                    'em_id' => 2, // Transportation
                    'em_sub_id' => 3, // Diesel Vehicle
                    'user_id' => $userId,
                    'amount' => $amount,
                    'total_cf' => $amount * $emissionFactors[3],
                    'month' => $month,
                    'year' => 2024,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Medical waste calculations
                $amount = rand(200, 500); // Monthly medical waste in kg
                $calculations[] = [
                    'em_id' => 3, // Waste Management
                    'em_sub_id' => 5, // Medical Waste
                    'user_id' => $userId,
                    'amount' => $amount,
                    'total_cf' => $amount * $emissionFactors[5],
                    'month' => $month,
                    'year' => 2024,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Water consumption calculations
                $amount = rand(1000, 2000); // Monthly water usage in m³
                $calculations[] = [
                    'em_id' => 4, // Water Consumption
                    'em_sub_id' => 7, // Tap Water
                    'user_id' => $userId,
                    'amount' => $amount,
                    'total_cf' => $amount * $emissionFactors[7],
                    'month' => $month,
                    'year' => 2024,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Medical equipment usage calculations
                $amount = rand(80, 160); // Monthly usage hours
                $calculations[] = [
                    'em_id' => 5, // Medical Equipment
                    'em_sub_id' => 9, // X-ray Machine
                    'user_id' => $userId,
                    'amount' => $amount,
                    'total_cf' => $amount * $emissionFactors[9],
                    'month' => $month,
                    'year' => 2024,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert in chunks to avoid memory issues
        foreach (array_chunk($calculations, 100) as $chunk) {
            DB::table('emission_calculations')->insert($chunk);
        }
    }
} 