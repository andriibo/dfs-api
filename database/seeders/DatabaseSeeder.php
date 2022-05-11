<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ContestSeeder::class,
            LeagueSeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
