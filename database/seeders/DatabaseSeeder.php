<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Cashier;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'admin1234',
            'role' => 'admin',
        ]);

        User::factory(1)->create(['username' => 'cham', 'role' => 'cashier', 'password' => 'cashier']);
        // User::factory(20)->create(['role' => 'customer', 'password' => 'customer']);
    }
}
