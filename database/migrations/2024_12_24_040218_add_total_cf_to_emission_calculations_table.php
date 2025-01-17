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
        Schema::table('emission_calculations', function (Blueprint $table) {
            $table->decimal('total_cf', 15, 4)->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emission_calculations', function (Blueprint $table) {
            $table->dropColumn('total_cf');
        });
    }
};
