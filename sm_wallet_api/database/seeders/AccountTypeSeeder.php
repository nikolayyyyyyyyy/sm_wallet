<?php

namespace Database\Seeders;
use App\Models\AccountType;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CardType seeder
        AccountType::create([
            'account_type' => 'Спестовна'
        ]);

        AccountType::create([
            'account_type' => 'Разплащателна'
        ]);
    }
}
