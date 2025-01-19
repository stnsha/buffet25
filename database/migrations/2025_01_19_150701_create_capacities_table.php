<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('capacities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venue_id');
            $table->dateTime('venue_date');
            $table->integer('full_capacity')->default(0);
            $table->integer('baby_chair')->default(0);
            $table->integer('min_capacity')->default(1);
            $table->integer('available_capacity')->default(0);
            $table->integer('available_bchair')->default(0);
            $table->integer('total_paid')->default(0);
            $table->integer('total_reserved')->default(0);
            $table->integer('status')->default(1); //1 - Available

            $table->softDeletes();
            $table->foreign('venue_id')->references('id')->on('venues');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capacities');
    }
};
