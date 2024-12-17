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
        Schema::create('venue_paxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venue_dates_id');
            $table->unsignedBigInteger('date_id');
            $table->integer('max_pax')->default(0);
            $table->integer('min_pax')->default(0);
            $table->integer('baby_chair')->default(0);
            $table->integer('confirmed_pax')->default(0);
            $table->integer('reserved_pax')->default(0);
            $table->integer('cancelled_pax')->default(0);
            $table->boolean('sold_out')->default('0');
            $table->timestamps();

            $table->foreign('venue_id')->references('id')->on('venues');
            $table->foreign('venue_dates_id')->references('id')->on('venue_dates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venue_paxes');
    }
};
