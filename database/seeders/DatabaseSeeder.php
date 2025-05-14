<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\GeneralSeeder;
use Database\Seeders\MasterDataSeeder;
use Database\Seeders\ContingentsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GeneralSeeder::class,
            MasterDataSeeder::class,
            ContingentsSeeder::class,
            UserSeeder::class,
        ]);
    }
}
