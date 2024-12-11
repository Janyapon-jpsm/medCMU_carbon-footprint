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
        Schema::create('emission_sub_types', function (Blueprint $table) {
            $table->id();
            $table->string('sub_type');
            $table->decimal('emission_factor', 10, 4);
            $table->string('unit');
            $table->foreignId('emission_type_id')->constrained('emission_types')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emission_sub_types');
    }
};