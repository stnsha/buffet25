<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'superadmin',
        //     'email' => 'anasuharosli@gmail.com',
        //     'password' => Hash::make('anasuha97')
        // ]);

        User::create([
            'name' => 'admin',
            'email' => 'nabilajunho@gmail.com',
            'password' => Hash::make('nabila97')
        ]);
    }
}
