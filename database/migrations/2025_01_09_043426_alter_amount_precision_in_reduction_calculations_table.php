<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reduction_calculations', function (Blueprint $table) {
            $table->decimal('amount', 15, 4)->change(); // Change 10 to 15 or your desired precision
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reduction_calculations', function (Blueprint $table) {
            $table->decimal('amount', 10, 4)->change(); // Revert back to the original precision
        });
    }
};
