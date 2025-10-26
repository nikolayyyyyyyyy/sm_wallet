<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\AccountTypeSeeder;
use Database\Seeders\CurrencySeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AccountTypeSeeder::class,
            CurrencySeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            TransactionTypeSeeder::class
        ]);
    }
}
