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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->integer('total_warga_emas')->default(0);
            $table->double('price_warga_emas')->default(0);
            $table->double('subtotal_warga_emas')->default(0);
            $table->integer('total_dewasa')->default(0);
            $table->double('price_dewasa')->default(0);
            $table->double('subtotal_dewasa')->default(0);
            $table->integer('total_kanak')->default(0);
            $table->double('price_dewasa')->default(0);
            $table->double('subtotal_kanak')->default(0);
            $table->integer('total_baby')->default(0);
            $table->double('price_dewasa')->default(0);
            $table->boolean('is_baby_chair')->default(0);
            $table->integer('total_baby_chair')->default(0);
            $table->timestamps();


            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
