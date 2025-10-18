<?php

namespace Database\Seeders;
use App\Models\CardType;
use Illuminate\Database\Seeder;

class CardTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CardType seeder
        CardType::create([
            'account_type' => 'Спестовна'
        ]);

        CardType::create([
            'account_type' => 'Разплащателна'
        ]);

        CardType::create([
            'account_type' => 'Студентска'
        ]);
    }
}
