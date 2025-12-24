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
        // Call the ProdiSeeder we just created
        $this->call([
            ProdiSeeder::class,
        ]);
    }
}