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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('venue_id');
            $table->string('ref_id');
            $table->double('subtotal');
            $table->double('discount_total');
            $table->double('total');
            $table->string('fpx_id')->nullable();
            $table->boolean('is_bchair')->default(0);
            $table->integer('total_chair')->default(0);
            $table->integer('status')->default(1); //1 - Reserved

            $table->softDeletes();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('venue_id')->references('id')->on('capacities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
