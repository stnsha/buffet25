<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('prices')->insert(
            [
                [
                    'venue_id' => 1,
                    'name' => 'Group',
                    'normal_price' => 58,
                    'description' => '(20 pax free 1 pax)',
                ],
                [
                    'venue_id' => 2,
                    'name' => 'Group',
                    'normal_price' => 63,
                    'description' => '(20 pax free 1 pax)',
                ],
            ]
        );
    }
}