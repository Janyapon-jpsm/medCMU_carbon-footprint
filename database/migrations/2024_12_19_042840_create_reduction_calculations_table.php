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
        Schema::create('reduction_calculations', function (Blueprint $table) {
            $table->id('re_cal_id');
            $table->unsignedBigInteger('re_id');
            $table->unsignedBigInteger('re_sub_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('re_id')->references('re_id')->on('reduction_types')->cascadeOnDelete();
            $table->foreign('re_sub_id')->references('re_sub_id')->on('reduction_sub_types')->cascadeOnDelete();
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
        Schema::dropIfExists('reduction_calculations');
    }
};
