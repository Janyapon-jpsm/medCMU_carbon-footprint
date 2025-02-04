<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create basic types first
        $this->call([
            EmissionTypeSeeder::class,
            EmissionSubTypeSeeder::class,
            ReductionTypeSeeder::class,
            ReductionSubTypeSeeder::class,
        ]);

        // Create users
        $this->call(UserSeeder::class);

        // Create calculations after types and users are created
        $this->call([
            EmissionCalculationSeeder::class,
            ReductionCalculationSeeder::class,
        ]);
    }
}
