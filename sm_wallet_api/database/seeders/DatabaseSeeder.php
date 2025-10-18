<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\CardTypeSeeder;
use Database\Seeders\CurrencySeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CardTypeSeeder::class,
            CurrencySeeder::class,
            RoleSeeder::class,
            UserSeeder::class
        ]);
    }
}
