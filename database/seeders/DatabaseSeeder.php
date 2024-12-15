<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MaterialSeeder::class,
            UserSeeder::class,
            OrderSeeder::class,
            WarehouseSeeder::class
        ]);
    }
}
