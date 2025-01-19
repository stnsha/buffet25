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
        Schema::create('person_in_charges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('person_in_charges')->insert(
            [
                'name' => 'Myra',
                'phone' => '60194464177',
            ],
            [
                'name' => 'Nabila',
                'phone' => '60193044022',
            ],
            [
                'name' => 'Linn',
                'phone' => '60172469492',
            ],
            [
                'name' => 'Emy',
                'phone' => '60127844505',
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_in_charges');
    }
};
