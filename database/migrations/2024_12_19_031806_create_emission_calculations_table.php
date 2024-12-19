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
        Schema::create('emission_calculations', function (Blueprint $table) {
            $table->id('em_cal_id');
            $table->unsignedBigInteger('em_id');
            $table->unsignedBigInteger('em_sub_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('em_id')->references('em_id')->on('emission_types')->cascadeOnDelete();
            $table->foreign('em_sub_id')->references('em_sub_id')->on('emission_sub_types')->cascadeOnDelete();
            $table->foreign('user_id')->references('user_id')->on('users')->cascadeOnDelete();
            $table->decimal('amount', 10, 4);
            $table->integer('month');
            $table->integer('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emission_calculations');
    }
};
