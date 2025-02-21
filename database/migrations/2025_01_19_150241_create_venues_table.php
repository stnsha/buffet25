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
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('location');
            $table->string('waze_link')->nullable();
            $table->string('gmap_link')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });


        DB::table('venues')->insert([
            [
                'name' => 'Dewan Arena',
                'code' => 'ARN',
                'location' => 'Ujong Pasir',
            ],
            [
                'name' => 'Dewan Chermin',
                'code' => 'CMN',
                'location' => 'Nilai',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
