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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venue_id');
            $table->string('name');
            $table->double('normal_price');
            $table->string('description')->nullable();

            $table->softDeletes();
            $table->foreign('venue_id')->references('id')->on('venues');

            $table->timestamps();
        });

        DB::table('prices')->insert(
            [
                [
                    'venue_id' => 1,
                    'name' => 'Kanak-kanak',
                    'normal_price' => 39,
                    'description' => '(6-12 tahun)',
                ],
                [
                    'venue_id' => 1,
                    'name' => 'Kanak-kanak',
                    'normal_price' => 10,
                    'description' => '(5 tahun dan ke bawah)',
                ],
                [
                    'venue_id' => 1,
                    'name' => 'Dewasa',
                    'normal_price' => 65,
                    'description' => '',
                ],
                [
                    'venue_id' => 1,
                    'name' => 'Warga emas',
                    'normal_price' => 45,
                    'description' => '(60 & ke atas)',
                ],
                [
                    'venue_id' => 2,
                    'name' => 'Kanak-kanak',
                    'normal_price' => 10,
                    'description' => '(5 tahun dan ke bawah)',
                ],
                [
                    'venue_id' => 2,
                    'name' => 'Kanak-kanak',
                    'normal_price' => 39,
                    'description' => '(6-12 tahun)',
                ],
                [
                    'venue_id' => 2,
                    'name' => 'Dewasa',
                    'normal_price' => 69,
                    'description' => '',
                ],
                [
                    'venue_id' => 2,
                    'name' => 'Warga emas',
                    'normal_price' => 45,
                    'description' => '(60 & ke atas)',
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
