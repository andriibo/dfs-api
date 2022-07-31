<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserTransaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTransactionSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        UserTransaction::factory(10)->for(User::factory()->verified()->create())->create();
    }
}
