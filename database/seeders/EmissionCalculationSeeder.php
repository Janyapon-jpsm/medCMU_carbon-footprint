<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmissionCalculationSeeder extends Seeder
{
    private function getSeasonalMultiplier($month)
    {
        // Higher usage in summer (air conditioning) and winter (heating)
        // Months: 1 = January, 12 = December
        switch ($month) {
            case 3: case 4: case 5: // Spring
                return 0.8;
            case 6: case 7: case 8: // Summer
                return 1.3;
            case 9: case 10: case 11: // Fall
                return 0.9;
            case 12: case 1: case 2: // Winter
                return 1.2;
        }
    }

    private function getYearlyGrowthMultiplier($year)
    {
        // 5% year-over-year growth from base year 2021
        return 1 + (($year - 2021) * 0.05);
    }

    public function run(): void
    {
        // Get emission factors from sub-types
        $emissionFactors = DB::table('emission_sub_types')
            ->pluck('emission_factor', 'em_sub_id')
            ->toArray();
        
        $calculations = [];
        $userIds = [1, 2, 3, 4, 5];
        $years = [2021, 2022, 2023, 2024];
        
        foreach ($years as $year) {
            $yearMultiplier = $this->getYearlyGrowthMultiplier($year);
            
            for ($month = 1; $month <= 12; $month++) {
                $seasonalMultiplier = $this->getSeasonalMultiplier($month);
                
                foreach ($userIds as $userId) {
                    // Electricity consumption calculations - affected by seasons
                    $baseAmount = rand(5000, 8000);
                    $amount = round($baseAmount * $seasonalMultiplier * $yearMultiplier);
                    $calculations[] = [
                        'em_id' => 1,
                        'em_sub_id' => 1,
                        'user_id' => $userId,
                        'amount' => $amount,
                        'total_cf' => $amount * $emissionFactors[1],
                        'month' => $month,
                        'year' => $year,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // Transportation - slightly lower in summer months
                    $baseAmount = rand(100, 300);
                    $amount = round($baseAmount * (($month >= 6 && $month <= 8) ? 0.9 : 1.0) * $yearMultiplier);
                    $calculations[] = [
                        'em_id' => 2,
                        'em_sub_id' => 3,
                        'user_id' => $userId,
                        'amount' => $amount,
                        'total_cf' => $amount * $emissionFactors[3],
                        'month' => $month,
                        'year' => $year,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // Medical waste - consistent throughout the year with slight growth
                    $baseAmount = rand(200, 500);
                    $amount = round($baseAmount * $yearMultiplier);
                    $calculations[] = [
                        'em_id' => 3,
                        'em_sub_id' => 5,
                        'user_id' => $userId,
                        'amount' => $amount,
                        'total_cf' => $amount * $emissionFactors[5],
                        'month' => $month,
                        'year' => $year,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // Water consumption - higher in summer months
                    $baseAmount = rand(1000, 2000);
                    $waterMultiplier = ($month >= 6 && $month <= 8) ? 1.3 : 1.0;
                    $amount = round($baseAmount * $waterMultiplier * $yearMultiplier);
                    $calculations[] = [
                        'em_id' => 4,
                        'em_sub_id' => 7,
                        'user_id' => $userId,
                        'amount' => $amount,
                        'total_cf' => $amount * $emissionFactors[7],
                        'month' => $month,
                        'year' => $year,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // Medical equipment - consistent with slight yearly growth
                    $baseAmount = rand(80, 160);
                    $amount = round($baseAmount * $yearMultiplier);
                    $calculations[] = [
                        'em_id' => 5,
                        'em_sub_id' => 9,
                        'user_id' => $userId,
                        'amount' => $amount,
                        'total_cf' => $amount * $emissionFactors[9],
                        'month' => $month,
                        'year' => $year,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Insert in chunks to avoid memory issues
        foreach (array_chunk($calculations, 100) as $chunk) {
            DB::table('emission_calculations')->insert($chunk);
        }
    }
} 