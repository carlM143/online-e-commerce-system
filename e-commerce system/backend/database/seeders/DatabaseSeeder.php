<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Call only one seeder once
        $this->call(ProductSeeder::class);
    }
}
