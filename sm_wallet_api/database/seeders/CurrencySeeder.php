<?php

namespace Database\Seeders;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Currency seeder
        Currency::create([
            'currency' => 'BGN'
        ]);

        Currency::create([
            'currency' => 'EUR'
        ]);

        Currency::create([
            'currency' => 'GBR'
        ]);

        Currency::create([
            'currency' => 'USD'
        ]);
    }
}
