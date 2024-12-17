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
            $table->string('customer_name');
            $table->string('customer_company')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->integer('order_status')->default(5); //1 = completed, 2 = processing, 3 = reserved, 4 = cancelled, 5 = pending
            $table->unsignedBigInteger('venue_paxes_id');
            $table->double('subtotal')->default(0);
            $table->double('discount')->nullable();
            $table->double('final_total')->default(0);
            $table->integer('payment_status')->default(0); //1 = completed, 2 = processing, 3 = failed

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
