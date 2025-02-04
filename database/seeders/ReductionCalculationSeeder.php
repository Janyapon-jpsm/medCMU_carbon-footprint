<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReductionCalculationSeeder extends Seeder
{
    private function getSeasonalMultiplier($month)
    {
        // Solar and energy efficiency vary by season
        switch ($month) {
            case 3: case 4: case 5: // Spring
                return 1.1;
            case 6: case 7: case 8: // Summer
                return 1.4;
            case 9: case 10: case 11: // Fall
                return 0.9;
            case 12: case 1: case 2: // Winter
                return 0.7;
        }
    }

    private function getYearlyGrowthMultiplier($year)
    {
        // 15% year-over-year growth in reduction efforts from base year 2021
        // Higher growth rate than emissions as sustainability efforts increase
        return 1 + (($year - 2021) * 0.15);
    }

    public function run(): void
    {
        // Get emission factors from sub-types
        $reductionFactors = DB::table('reduction_sub_types')
            ->pluck('emission_factor', 're_sub_id')
            ->toArray();
        
        $calculations = [];
        $userIds = [1, 2, 3, 4, 5];
        $years = [2021, 2022, 2023, 2024];
        
        foreach ($years as $year) {
            $yearMultiplier = $this->getYearlyGrowthMultiplier($year);
            
            for ($month = 1; $month <= 12; $month++) {
                $seasonalMultiplier = $this->getSeasonalMultiplier($month);
                
                foreach ($userIds as $userId) {
                    // LED Lighting reductions - affected by seasonal daylight
                    $baseAmount = rand(500, 1000);
                    $amount = round($baseAmount * $seasonalMultiplier * $yearMultiplier);
                    $calculations[] = [
                        're_id' => 1,
                        're_sub_id' => 1,
                        'user_id' => $userId,
                        'amount' => $amount,
                        'total_cf' => $amount * $reductionFactors[1],
                        'month' => $month,
                        'year' => $year,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // Electric Vehicle usage - consistent growth
                    $baseAmount = rand(50, 150);
                    $amount = round($baseAmount * $yearMultiplier);
                    $calculations[] = [
                        're_id' => 2,
                        're_sub_id' => 3,
                        'user_id' => $userId,
                        'amount' => $amount,
                        'total_cf' => $amount * $reductionFactors[3],
                        'month' => $month,
                        'year' => $year,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // Medical Waste Recycling - steady increase
                    $baseAmount = rand(50, 150);
                    $amount = round($baseAmount * $yearMultiplier);
                    $calculations[] = [
                        're_id' => 3,
                        're_sub_id' => 5,
                        'user_id' => $userId,
                        'amount' => $amount,
                        'total_cf' => $amount * $reductionFactors[5],
                        'month' => $month,
                        'year' => $year,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // Water-Efficient Fixtures - more savings in summer
                    $baseAmount = rand(100, 300);
                    $waterMultiplier = ($month >= 6 && $month <= 8) ? 1.3 : 1.0;
                    $amount = round($baseAmount * $waterMultiplier * $yearMultiplier);
                    $calculations[] = [
                        're_id' => 4,
                        're_sub_id' => 7,
                        'user_id' => $userId,
                        'amount' => $amount,
                        'total_cf' => $amount * $reductionFactors[7],
                        'month' => $month,
                        'year' => $year,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // Solar Panel Installation - highly seasonal
                    $baseAmount = rand(1000, 2000);
                    $amount = round($baseAmount * $seasonalMultiplier * $yearMultiplier);
                    $calculations[] = [
                        're_id' => 5,
                        're_sub_id' => 9,
                        'user_id' => $userId,
                        'amount' => $amount,
                        'total_cf' => $amount * $reductionFactors[9],
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
            DB::table('reduction_calculations')->insert($chunk);
        }
    }
} 